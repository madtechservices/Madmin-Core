@php
    $field['wrapper'] = $field['wrapper'] ?? $field['wrapperAttributes'] ?? [];
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitMapElement';
    $field['wrapper']['data-field-name'] = $field['wrapper']['data-field-name'] ?? $field['name'];

    $default_lat = $field['default']['lat'] ?? 47.133074;
    $default_lng = $field['default']['lng'] ?? 19.248949;
    $default_zoom = $field['default']['zoom'] ?? 6;

    $json = isset($field['value']) ? json_decode($field['value']) : null;
    if ($json) {
        $value = [
            'lat' => $json?->lat??'',
            'lng' => $json?->lng??'',
        ];
    } else {
        $value = [
            'lat' => '',
            'lng' => '',
        ];
    }
@endphp


<!-- text input -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div id="{{ $field['name'] }}_map"></div>
    <input
        type="hidden"
        id="{{ $field['name'] }}_value"
        name="{{ $field['name'] }}"
        value="@json(isset($field['value']) ? $field['value'] : '')"
    >

    <div class="row mt-3">
        <div class="col-12 col-md-6">
            <input
                type="text"
                class="form-control {{ $field['name'] }}_lat"
                readonly
                name="{{ $field['name'] }}_lat"
                value="{{ $value['lat'] }}"
            >
        </div>
        <div class="col-12 col-md-6">
            <input
                type="text"
                class="form-control {{ $field['name'] }}_lng"
                readonly
                name="{{ $field['name'] }}_lng"
                value="{{ $value['lng'] }}"
            >
        </div>
    </div>
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')



{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_styles')
        <style type="text/css">
            #{{ $field['name'] }}_map {
                width: 100%;
                height: 400px;
            }
        </style>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    @endpush

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
        <script>
            function bpFieldInitMapElement(element) {
                const mapElement = element.find("#{{ $field['name'] }}_map");
                const valueElement = element.find("#{{ $field['name'] }}_value");
                const latInputElement = element.find(".{{ $field['name'] }}_lat")[0];
                const lngInputElement = element.find(".{{ $field['name'] }}_lng")[0];

                let def_lat = {{ $default_lat }};
                let def_lng = {{ $default_lng }};
                let def_zoom = {{ $default_zoom }};
                let marker = null;

                if (latInputElement && lngInputElement) {
                    const _lat = $(latInputElement).val();
                    const _lng = $(lngInputElement).val();
                    if (_lat && _lng) {
                        def_lat = _lat;
                        def_lng = _lng;
                        def_zoom = 14;
                    }
                }
    
                let map = L.map('{{ $field["name"] }}_map').setView([def_lat, def_lng], def_zoom);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                if (latInputElement && lngInputElement) {
                    const _lat = $(latInputElement).val();
                    const _lng = $(lngInputElement).val();
                    if (_lat && _lng) {
                        marker = new L.marker([_lat, _lng]).addTo(map);
                    }
                }

                map.on('click', (e) => {
                    $(latInputElement).val(e.latlng.lat);
                    $(lngInputElement).val(e.latlng.lng);
                    $(valueElement).val(JSON.stringify(e.latlng));

                    if (marker === null) {
                        marker = new L.marker(e.latlng).addTo(map);
                    } else {
                        marker.setLatLng(e.latlng);
                    }
                });
            }
        </script>
    @endpush
@endif
