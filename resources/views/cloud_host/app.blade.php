<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Hetzner App - Wie ist mein Cloud Host?</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark navbar-hetzner">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                My Hetzner App - Wie ist mein Host?
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">IP:</label>
                    <input type="text" class="form-control" id="ip" required>
                    <small id="emailHelp" class="form-text text-muted">Bitte geben Sie den Hostname oder die IP des
                        Servers
                        an.
                    </small>
                </div>
                <button type="submit" class="btn btn-primary" id="check"><i class="fas fa-spin fa-spinner fa-fw"
                                                                            id="loader"
                                                                            style="display:none;"></i> Prüfen
                </button>
            </form>
            <div class="alert alert-danger" role="alert" id="error_domain" style="display: none">
                Leider ist der eingegebene Wert ungültig.
            </div>
            <textarea id="result" style="display:none;" readonly class="form-control"></textarea>
        </div>
    </main>
    <div class="fixed-bottom"><a href="https://lukas-kaemmerling.de/legal">Impressum</a> | <a
                href="https://lukas-kaemmerling.de/datenschutz" target="_blank">Datenschutz</a></div>
</div>
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script defer src="https://pro.fontawesome.com/releases/v5.0.13/js/all.js"
        integrity="sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn"
        crossorigin="anonymous"></script>
<!-- Scripts -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" defer></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $('#check').on('click', function (e) {
        e.preventDefault();
        $('#loader').fadeIn();
        $('#check').attr('disabled', 'true');
        if ($('#result').css('display') == 'block') {
            $('#result').fadeOut();
        }
        var value = $('#ip').val();
        var beesl = value.split('.').pop();
        if ($.isNumeric(beesl)) {
            callApiTrace(value);
        } else {
            callApiDomain(value);
        }


    });

    function callApiTrace(value) {
        $.getJSON('/api/traceing/' + value + '/host', function (data) {
            $('#result').html(JSON.stringify(data, null, 2));
            $('#result').fadeIn();
            $('#check').removeAttr('disabled');
            $('#loader').fadeOut();
        });
    }

    function callApiDomain(value) {
        $.post('/api/domain', {hostname: value}, function (data) {
            var data = JSON.parse(data);
            if (data.resp == value) {
                $('#error_domain').fadeIn();
            } else {
                callApiTrace(data.resp);
            }
        });
    }
</script>
</body>
</html>
