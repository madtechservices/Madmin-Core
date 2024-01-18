@if (!isset($permission) || user_can($permission))
    <li class="nav-item">
        <a
            class="{{ "nav-link" . ($disabled ? " disabled" : "") . (Request::url() == $url ? " active" : "") }}"
            href="{{ url($url) }}"
        >
            @if ($icon !== "")
                <i class="{{ $icon }}"></i>
            @endif
            {{ $title ?? "" }}
        </a>
    </li>
@endif