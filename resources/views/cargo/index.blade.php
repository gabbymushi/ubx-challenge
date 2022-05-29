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

        <section style="padding-top:90px">
            <form method="POST" action="/" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <input class="form-control" name="cargo_file" type="file" required="required">
                    </div>
                    <div class="col">
                        <input class="btn btn-success" type="submit" value="Upload">
                    </div>
                    <div class="col"></div>
                </div>
            </form>
            <div class="row" style="margin-top: 10px;">
                <div class="col"></div>
                <div class="col">
                    <a href="/wharfage" class="btn btn-success">Process bill</a>
                </div>
                <div class="col"></div>
            </div>
        </section>
    </div>
</body>

</html>