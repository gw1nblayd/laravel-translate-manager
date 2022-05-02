<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('translate-manager.title') }}</title>

    <link rel="icon" href="{{ asset('vendor/translate-manager/favicon/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('vendor/translate-manager/css/app.css') }}">
</head>
<body class="bg-gray-100 tracking-wider tracking-normal">

<div
    id="app"
    data-app-name="{{ config('app.name', 'Laravel') }}"
    data-app-locale="{{ config('app.locale', 'en') }}"
    data-site-url="{{ value(config('translate-manager.site_url', url('/'))) }}"
></div>

<script src="{{ asset('vendor/translate-manager/js/app.js') }}"></script>
</body>
</html>