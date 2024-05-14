@if (isset($permission) && auth()->user()->getRoleName() != 'superadmin')
    @if (auth()->user()->hasAnyPermission($permission))
        <li class="nav-item">
            <a href="{{ $url }}" class="nav-link {!! request()->is($active) ? 'active' : '' !!}">
                <i class="nav-icon {{ $icon }}"></i>
                <p>{{ $title }}
                    @if (isset($notif))
                        {!! $notif ? '<span class="badge badge-info right">' . $notif . '</span>' : '' !!}
                    @endif
                </p>
            </a>
        </li>
    @endif
@else
    <li class="nav-item">
        <a href="{{ $url }}" class="nav-link {!! request()->is($active) ? 'active' : '' !!}">
            <i class="nav-icon {{ $icon }}"></i>
            <p>{{ $title }}
                @if (isset($notif))
                    {!! $notif ? '<span class="badge badge-info right">' . $notif . '</span>' : '' !!}
                @endif
            </p>
        </a>
    </li>
@endif
