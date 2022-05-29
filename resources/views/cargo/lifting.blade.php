<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<style>
    .button {
        border: none;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
    }

    /*  .button1 {
        border-radius: 2px;
        background-color: #04AA6D;
    }

    .button2 {
        border-radius: 4px;
    }

    .button3 {
        border-radius: 8px;
    }

    .button4 {
        border-radius: 12px;
    } */

    .button1 {
        color: #CCCC;
        border-radius: 50%;
        background-color: white;
    }

    .button2 {
        color: white;
        border-radius: 50%;
        background-color: #04AA6D;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UBX Cargo') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container" style="min-height: 800px;background-color:#CCCC">
        <section style="paddiSng-top:90px">
        <div class="row">
            <div class="col"></div>
                <div class="col">
                    <button class="button button1">1</button>
                    <p>WHARFAGE SHIP CHARGES</p>
                </div>
                <div class="col">
                    <button class="button button1">2</button>
                    <p>STORAGE CHARGES</p>
                </div>
                <div class="col">
                    <button class="button button1">3</button>
                    <p>DESTUFFING CHARGES</p>
                </div>
                <div class="col">
                    <button class="button button2">4</button>
                    <p>LIFTING CHARGES</p>
                </div>
                <div class="col">
                    <button class="button button1">5</button>
                    <p>FINISH</p>
                </div>
            </div>
            <form method="POST" action="/" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col">
                    <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" onclick="createBill('all')"></th>
                                    <th>#</th>
                                    <th>Cargo no</th>
                                    <th>Cargo type</th>
                                    <th>Cargo size</th>
                                    <th>Weight(Kg)</th>
                                    <th>Remarks</th>
                                    <th>Lifting</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($charges as $key=> $charge)
                                <tr>
                                    <td><input type="checkbox" onclick="createBill('{{$charge->id}}','lifting')"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$charge->cargo_no}}</td>
                                    <td>{{$charge->type}}</td>
                                    <td>{{$charge->size}}</td>
                                    <td>{{$charge->weight}}</td>
                                    <td>{{$charge->remarks}}</td>
                                    <td>{{$charge->amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="sub_summary">
                            <table class="table">
                                <tr style="background-color: white;">
                                    <td>USD Exchange Rate</td>
                                    <td>{{number_format(1230)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: white;">
                                    <td>Subtotal (USD)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: white;">
                                    <td>Subtotal (TZS)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: white;">
                                    <td>VAT (TZS)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: white;">
                                    <td>Grand Total (TZS)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-1"></div>
                </div>
            </form>
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-3 offset-md-9">
                    <a href="/destuffing" class="btn btn-warning" style="width: 90px;">PREVIOUS</a>
                    <a href="/summary" class="btn btn-primary" style="width: 90px;">NEXT</a>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

<script>
    function createBill(id, category) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/create-bill',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                charge_id: id,
                category: category
            },
            // dataType: 'JSON',
            success: function(data) {
                $("#sub_summary").html(data);
            }
        });
    }
</script>