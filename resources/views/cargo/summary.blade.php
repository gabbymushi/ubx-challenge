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
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>

<body>
    <div class="container" style="min-height: 800px;background-color:#CCCC">
        <section style="padding-top:90px">
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
                    <button class="button button1">4</button>
                    <p>LIFTING CHARGES</p>
                </div>
                <div class="col">
                    <button class="button button2">5</button>
                    <p>FINISH</p>
                </div>
            </div>
            <form method="POST" action="/" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col card">
                        <center>
                            <h1>BILL SUMMARY</h1>
                            <div class="alert alert-dark d-flex align-itemss-center col-4" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Instructions: <br />
                                    NOTE: All prices are VAT included
                                </div>
                            </div>
                        </center>
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
                                <td>WHARFAGE CHARGES (USD)</td>
                                <td>{{number_format($wharfage)}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr style="background-color: white;">
                                <td>STORAGE CHARGES (USD)</td>
                                <td>{{number_format($storage)}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr style="background-color: white;">
                                <td>DESTUFFING CHARGES (USD)</td>
                                <td>{{($destuffing)}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr style="background-color: white;">
                                <td>LIFTING CHARGES (USD)</td>
                                <td>{{number_format($lifting)}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-1"></div>
                </div>
            </form>
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