@if (!isset($permissions) || user_can_any($permissions))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle text-capitalize" href="#">
            @if($icon !== "")
                <i class="nav-icon {{ $icon }}"></i>
            @endif
            {{ __($title) }}
        </a>
        <ul class="nav-dropdown-items">
            @isset($items)
                @foreach ($items as $item)
                    {{ $item->render() }}
                @endforeach
            @endisset
        </ul>
    </li>
@endif