<?php

use App\Models\UserAnnModel;
use App\Models\Categories;
use Illuminate\Support\Facades\Cache;

$ann = UserAnnModel::select('message')->orderByDesc('updated_at')->first();

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title id="seo_title">
        @if (isset($title))
            {{ $title }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <meta id="seo_desc" name="description"
        content="@if (isset($desc) && $desc !== '') {{ $desc }} @else {{ __('description.default') }} @endif">
    <meta property="og:title"
        content="@if (isset($title)) {{ $title }} @else {{ config('app.name') }} @endif">
    <meta id="seo_fb" property="og:description"
        content="@if (isset($desc) && $desc !== '') {{ $desc }} @else {{ __('description.default') }} @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">         --}}

    <link rel="stylesheet" href="{{ asset('css/text.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .loading-section {
            height: 100vh;
            z-index: 9999;
        }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-185115352-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-185115352-1');
    </script>

    @yield('page-css')
</head>

<body style="min-height: 100vh !important" class="d-flex flex-column ">


    <!-- main Content -->
    <main>
        @yield('content')
    </main>

    @yield('script')
</body>

</html>
