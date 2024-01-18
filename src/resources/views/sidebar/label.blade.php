@if (!isset($permissions) || user_can_any($permissions))
    <li class="nav-title">{{ __($title) }}</li>
@endif