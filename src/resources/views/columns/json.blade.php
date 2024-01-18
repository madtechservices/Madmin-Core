@php
    $uid = uniqid()
@endphp

@push('before_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jsonview/1.2.3/jquery.jsonview.css" />
@endpush

@push('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jsonview/1.2.3/jquery.jsonview.min.js"></script>
    <script>
        $(".json").each(function( index ) {
            $(this).JSONView($(this).data("json"));
        });
    </script>
@endpush

<div class="json" data-json="{{ $entry->{$column['name']} }}"></div>