<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/*" href="{{ asset('images/fav/favicon.png') }}" id="favicon" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/sms.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    @laravelPWA
</head>

<body>
    <div id="app"></div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
