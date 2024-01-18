@php
    $field['wrapper'] = $field['wrapper'] ?? ($field['wrapperAttributes'] ?? []);
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitUploadElement';
    $field['wrapper']['data-field-name'] = $field['wrapper']['data-field-name'] ?? $field['name'];
    $field['accepted_file_types'] = $field['accepted_file_types'] ?? [];
    $field['max_file_size'] = $field['max_file_size'] ?? null;
    $field['clickable'] = $field['clickable'] ?? false;
    
    $urls = [];
    if (!empty($field['value'])) {
        foreach ($field['value'] as $file) {
            $urls[$file->id] = $file;
        }
    }
@endphp

<!-- text input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

<input type="file" name="upload_{{ $field['name'] }}[]" multiple>
<div
    class="file-removes"
    data-urls="{{ json_encode($urls) }}"
    data-max-file-size="{{ json_encode($field['max_file_size']) }}"
    data-accepted-file-types="{{ json_encode($field['accepted_file_types']) }}"
    data-clickable="{{ json_encode($field['clickable']) }}"
></div>

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
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    @endpush

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
        <script>
            function bpFieldInitUploadElement(element) {
                const fileInput = element.find("input[type='file']");
                const fileRemoves = element.find(`.file-removes`);

                const accepted_file_types = JSON.parse(fileRemoves[0].dataset.acceptedFileTypes);
                const max_file_size = JSON.parse(fileRemoves[0].dataset.maxFileSize);
                const uuids = JSON.parse(fileRemoves[0].dataset.urls);
                const clickable = JSON.parse(fileRemoves[0].dataset.clickable);
                const files = [];

                if (Object.entries(uuids).length > 0) {
                    Object.entries(uuids).forEach((entry) => {
                        files.push({
                            source: entry[1].uuid,
                            options: {
                                type: 'local',
                            },
                        });
                    });
                }

                $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
                $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);
                $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
                $(fileInput).filepond({
                    storeAsFile: true,
                    imagePreviewTransparencyIndicator: 'grid',
                    credits: false,
                    labelIdle: '{!! __('madmin-core::file.browse') !!}',
                    server: {
                        restore: '/file/',
                        load: '/file/',
                        fetch: '/file/',
                    },
                    files: files,
                    imagePreviewHeight: 200,
                    acceptedFileTypes: accepted_file_types ?? [],
                    maxFileSize: max_file_size ?? null,
                    allowFileSizeValidation: max_file_size ? true : false,
                    onremovefile: (error, file) => {
                        if (file.serverId) {
                            let file_id = null;
                            for (const [id, uuid] of Object.entries(uuids)) {
                                if (uuid === file.serverId) {
                                    file_id = id;
                                }
                            }

                            if (file_id === null) {
                                return;
                            }

                            const removeInput = document.createElement('input');
                            removeInput.name = "remove_{{ $field['name'] }}[]";
                            removeInput.value = file_id;
                            removeInput.type = "hidden";

                            fileRemoves.append(removeInput);
                        }
                    },
                    onactivatefile: (file) => {
                        if (clickable && file.serverId) {
                            window.open(`/file/${file.serverId}`, '_blank');
                        }
                    },
                });
            }
        </script>
    @endpush
@endif
