<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('translate-manager.title') }}</title>
</head>
<body>
<h1>{{ config('translate-manager.title') }}</h1>

<p>
    <b>{{ config('app.locale') }}:</b> {{ __('translates.auth.failed') }}
</p>
</body>
</html>