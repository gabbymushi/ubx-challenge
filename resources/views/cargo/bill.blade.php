<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container" style="min-height: 800px;background-color:#CCCC">
        <section style="margin-top:40px">
            <form method="POST" action="/" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cargo no</th>
                                    <th>Cargo type</th>
                                    <th>Cargo size</th>
                                    <th>Weight(Kg)</th>
                                    <th>Remarks</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($charges as $key=> $charge)
                                <tr>
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
                    </div>
                    <div class="col-1"></div>
                </div>
            </form>
            <div class="row" style="margin-top: 10px;">
                <!-- <div class="col-offset-8"></div> -->
                <div class="col-md-2 offset-md-10">
                    <input class="btn btn-primary" type="submit" value="Next" style="width: 90px;">
                </div>
            </div>
        </section>
    </div>
</body>

</html>