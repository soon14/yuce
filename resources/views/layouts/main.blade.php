<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="description" content="九宫智能预测，以梅花易数为基础，使用人工智能算法智能算卦." />
    <meta name="keywords" content="预测,算卦,智能预测,人工智能预测,疑难解惑" />

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css?'.time())}}">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <![endif]-->
    @section('style')
    @show
</head>
<body>
<div class="container">
@include('layouts.header')
@yield('content')
    <!-- body end-->
</div>

@include('layouts.footer')

@section('script')

@show

</body>
</html>