<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoBill;
use App\Models\CargoCharge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cargo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function processWharfageBill(Request $request)
    {
        $charges = $this->fetchCharges('wharfage');

        return view('cargo.bill', compact('charges'));
    }

    public function processStorageBill(Request $request)
    {
        $charges = $this->fetchCharges('storage');

        return view('cargo.storage', compact('charges'));
    }

    public function processDestuffingBill(Request $request)
    {
        $charges = $this->fetchCharges('destuffing');

        return view('cargo.destuffing', compact('charges'));
    }

    public function processLiftingBill(Request $request)
    {
        $charges = $this->fetchCharges('lifting');

        return view('cargo.lifting', compact('charges'));
    }

    public function summary(Request $request)
    {
        $wharfage = $this->fetchBills('wharfage');
        $storage = $this->fetchBills('storage');
        $destuffing = $this->fetchBills('destuffing');
        $lifting = $this->fetchBills('lifting');

        return view('cargo.summary', compact('wharfage', 'storage', 'destuffing', 'lifting'));
    }

    private function fetchCharges($category)
    {
        return CargoCharge::join('cargos', 'cargo_charges.cargo_id', '=', 'cargos.id')
            ->select('cargo_charges.id', 'cargo_no', 'type', 'size', 'weight', 'remarks',
             'amount','penalty_days','eletricity_amount')
            ->where('category', $category)
            ->get();
    }

    public function createBill(Request $request)
    {
        $cargo = CargoBill::create([
            'charge_id' => $request->charge_id,
        ]);

        $sum = $this->fetchBills($request->category);

        return view('cargo._summary', ['sum' => $sum]);
    }

    private function fetchBills($category)
    {
        return CargoBill::join('cargo_charges', 'cargo_bills.charge_id', '=',  'cargo_charges.id')
            ->join('cargos', 'cargo_charges.cargo_id', '=', 'cargos.id')
            ->where('category', $category)
            ->sum('cargo_charges.amount');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $file = $request->file('cargo_file');

        if ($file) {
            $file = $request->file('cargo_file');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();

            $this->checkUploadedFileProperties($extension, $fileSize);

            $location = 'uploads';

            $file->move($location, $filename);

            $filepath = public_path($location . "/" . $filename);

            $file = fopen($filepath, "r");
            $rawData = array();
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);

                if ($i == 0) {
                    $i++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $rawData[$i][] = $filedata[$c];
                }

                $i++;
            }
            fclose($file);

            $j = 0;
            foreach ($rawData as $importData) {
                try {
                    DB::beginTransaction();
                    $this->createCargo($importData);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            return back()->with(['message' => "Saved successfully"]);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createCargo($importData)
    {
        $cargoNo = $importData[0];
        $cargoType = $importData[1];
        $cargoSize = $importData[2];
        $cargoWeight = $importData[3];
        $remarks = $importData[4];
        $wharfage = $importData[5];
        $penalty = $importData[6];
        $storage = $importData[7];
        $eletricity = $importData[8];
        $destuffing = $importData[9];
        $lifting = $importData[10];

        $cargo = Cargo::create([
            'cargo_no' => $cargoNo,
            'type' => $cargoType,
            'size' => $cargoSize,
            'weight' => $cargoWeight,
            'remarks' => $remarks
        ]);

        $this->createCargoCharge($cargo->id, "wharfage", $wharfage);
        $this->createCargoCharge($cargo->id, "storage", $storage, $eletricity, $penalty);
        $this->createCargoCharge($cargo->id, "destuffing", $destuffing);
        $this->createCargoCharge($cargo->id, "lifting", $lifting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createCargoCharge(
        $cargoId,
        $category,
        $amount,
        $eletricityAmount = null,
        $penaltyDays = null
    ) {
        CargoCharge::create([
            'cargo_id' => $cargoId,
            'category' => $category,
            'amount' => $amount,
            'eletricity_amount' => $eletricityAmount,
            'penalty_days' => $penaltyDays
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $validExtension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $validExtension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }
}
