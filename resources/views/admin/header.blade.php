<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if (isset($title))
            {{ __('messages.' . $title) }}
        @else
            {{ __('messages.admin') }}
        @endif
    </title>
    <meta name="description"
        content="@if (isset($desc)) {{ $desc }} @else {{ __('description.default') }} @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <!-- jQuery MUST come first -->

    @include('lib.custom_lib')

    @yield('page-css')
</head>

<body class="d-flex flex-column min-vh-100">


@if (config("app.name") == "site1")
    @include("layouts.top")
@else
    @include("layouts.sidebar")
@endif