<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- @if (!session()->has('token'))
        <form action="get-token" method="POST">
            @csrf
            <button type="submit">generate</button>
        </form>
    @endif --}}

    @if ( session()->has('token') )
    <p>{{ session('token') }}</p>
    @endif

    <form action="sendMail" method="POST">
        @csrf
        <input type="hidden" name="mailToken" value="ya29.a0ARrdaM8aHtuxz457ockvlFcEsT0oPfnuE3Vth6_kdNsoPqiIGXdPsiibtda6I3agyXUFulnFfUQ-fazuIwu6NY6tFdsvkSvc65_hOOFW8TsVoU1rJqUVnwsqQVqXrZk5lyyh-jFjLgDxUqBVWnoSUIEchome">
        <button type="submit">Send</button>
    </form>
</body>
</html>