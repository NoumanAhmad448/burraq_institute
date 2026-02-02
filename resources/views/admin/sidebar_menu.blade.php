@php
    $menuGroups = [
        [
            'title' => 'Companies',
            'icon' => 'fa-user-circle',
            'items' => [
                // [
                //     'title' => 'HR',
                //     'icon'  => 'fa-user-circle',
                //     'route' => route('hr.index'),
                //     'img'   => 'hr.png',
                //     'access_roles' => ['admin', 'hr_role'],
                // ],
                [
                    'title' => 'Companies',
                    'icon' => 'fa-users',
                    'route' => route('admin.user.index'),
                    'access_roles' => ['admin',"super_admin"],
                ],
                [
                    'title' => 'Deleted Companies',
                    'icon' => 'fa-user-times',
                    'route' => route('admin.user.index', ['type' => 'deleted']),
                    'img' => 'deleted_users.png',
                    'access_roles' => ['admin'],
                ],
            ],
        ],

        [
            'title' => 'System',
            'icon' => 'fa-cogs',
            'items' => [
                [
                    'title' => 'Cron Jobs',
                    'icon' => 'fa-clock',
                    'route' => route('cron-jobs.index'),
                    'access_roles' => ['admin'],
                ],
            ],
        ],
    ];
@endphp
@foreach ($menuGroups as $gIndex => $group)
    @php
        $visibleItems = collect($group['items'])->filter(function ($item) {
            return empty($item['access_roles']) ||
                in_array(auth()->user()->role, $item['access_roles']) ||
                auth()->user()->is_admin;
        });
    @endphp

    @if ($visibleItems->isNotEmpty())
        <li class="nav-item dropdown text-center px-3">

            <!-- Parent -->
            <a class="navbar-text text-white dropdown-toggle" href="#" id="menuDropdown{{ $gIndex }}"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fa {{ $group['icon'] }} d-block mb-1"></i>
                <small>{{ $group['title'] }}</small>
            </a>

            <!-- Children -->
            <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="menuDropdown{{ $gIndex }}">

                @foreach ($visibleItems as $index => $item)
                    <a class="dropdown-item d-flex align-items-center" href="{{ $item['route'] }}"
                        data-index="{{ $index }}">

                        @if (!empty($item['img']))
                            <img src="{{ asset('img/' . $item['img']) }}" width="22" class="mr-2 rounded">
                        @else
                            <i class="fa {{ $item['icon'] }} mr-2 text-primary"></i>
                        @endif

                        {{ $item['title'] }}
                    </a>
                @endforeach

            </div>
        </li>
    @endif
@endforeach
