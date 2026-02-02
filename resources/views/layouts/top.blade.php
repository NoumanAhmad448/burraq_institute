{{-- TOP NAVBAR (existing code) --}}
<nav class="navbar navbar-expand-lg bg-website px-3">

    @if (config('setting.show_site_log'))
        <a class="navbar-brand text-white" href="{{ route('index') }}">
            <img src="{{ asset(config('setting.img_logo_path')) }}"
                 width="60">
        </a>
    @endif

    <button class="navbar-toggler text-white border-0"
            type="button"
            data-toggle="collapse"
            data-target="#mainNavbar">
        <i class="fa fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mx-auto" id="side_menu">
            @include('admin.sidebar_menu')
        </ul>

        @auth
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item mr-3">
                <span class="navbar-text text-white">
                    Welcome, {{ ucfirst(auth()->user()->name) }}
                </span>
            </li>
            {{-- <x-notification/> --}}
            @if (config('setting.login_profile'))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>
            @endif
        </ul>
        @endauth
    </div>
</nav>

{{-- CONTENT --}}
<div class="container-fluid mt-3">
    @yield('content')
</div>

@yield('footer')
</body>
</html>
