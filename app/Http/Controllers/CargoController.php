<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
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
    public function create()
    {
        //
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
            // dd($file);
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
