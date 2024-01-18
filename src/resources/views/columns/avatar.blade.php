@php
    $url = backpack_avatar_url($entry)
@endphp
<div class="d-flex align-items-center">
    @if ($url)
        <div class="avatar mr-3">
            <img class="img-avatar" src="{{ $url }}" alt="{{ $entry->name??'' }}" >
        </div>
    @endif
    <strong>
        {{ $entry->name??'' }}
    </strong>
</div>
