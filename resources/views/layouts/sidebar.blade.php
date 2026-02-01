<div class="d-flex">

    {{-- LEFT SIDEBAR --}}
    <div id="sidebar" class="bg-website text-white vh-100 p-3">

        @if (config('setting.show_site_log'))
            <div class="text-center mb-4">
                <img src="{{ asset(config('setting.img_logo_path')) }}" width="70">
            </div>
        @endif

        <ul class="nav flex-column">
            @include('admin.sidebar_menu')
        </ul>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-grow-1">
        {{-- TOP BAR --}}
        <nav class="navbar bg-light px-3 bg-website">
            <button class="btn btn-outline-secondary text-white"
                onclick="document.getElementById('sidebar').classList.toggle('d-none')">
                <i class="fa fa-bars"></i>
            </button>

            <div class="list-unstyled ml-auto align-items-center d-flex py-2">
                @auth
                    <li class="nav-item mr-3">
                        <span class="mr-3">
                            Welcome, {{ ucfirst(auth()->user()->name) }}
                        </span>
                    </li>
                    <x-notification />
                    @if (config('setting.login_profile'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout_user') }}">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        </li>
                    @endif
                @endauth
            </div>
        </nav>

        {{-- CONTENT --}}
        <div class="container-fluid mt-3">
            @yield('content')
        </div>

    </div>
</div>

@yield('footer')
</body>

</html>
