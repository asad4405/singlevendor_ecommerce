
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset($generalsetting->favicon) }}">
    <title>{{ $generalsetting->name }} - @yield('title')</title>
    <link href="{{ asset('public/Frontend') }}/css/themify-icons.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/animate.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/owl.theme.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/slick.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/swiper.min.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/owl.transitions.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{ asset('public/Frontend') }}/sass/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">

</head>
