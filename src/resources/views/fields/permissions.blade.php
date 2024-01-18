<!-- checklist -->
@php
  $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
  if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
    $field['value'] = $field['value']->pluck("id")->toArray();
  } elseif (is_string($field['value'])){
    $field['value'] = json_decode($field['value']);
  }
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';
  $group = null;
@endphp


@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    <div class="row">
        @foreach ($field['permisisons'] as $key => $option)
            @if ($group !== $option->group)
              @php
                  $group = $option->group;
              @endphp
              <div class="col-12 mt-2">
                <div style="display: flex; flex-flow: row; align-items: flex-end; margin-bottom: 15px;">
                  <div style="font-size: 14px; font-weight: 700; display: inline-block; margin: 0; padding: 0 10px 0 0; text-transform: uppercase;">
                      {{ $group }}
                      <a href="#" class="ml-2 select-all-perm" style="font-size: 12px;" data-group="{{ $group }}">Összes kijelölése</a>
                  </div>
                  <div style="display: flex; flex: 1 1; background: #e5e5e5; height: 1px;"></div>
              </div>
              </div>
            @endif
            <div class="col-sm-4 mb-3" >
                <div class="custom-control custom-checkbox">
                    <input 
                      type="checkbox" 
                      class="custom-control-input" 
                      data-group="{{ $group }}" 
                      id="permCheck{{ $option->id }}" 
                      value="{{ $option->id }}"
                    >
                    <label class="custom-control-label" for="permCheck{{ $option->id }}" style="line-height: 1.3;">
                        <span class="m-0">
                            {{ $option->name }}
                            <br/>
                            <small class="text-primary">
                                {{ $option->readable_name }}
                            </small>
                        </span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitChecklist(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var checkboxes = element.find('input[type=checkbox]');
                var container = element.find('.row');
                var selectAlls = element.find('.select-all-perm');
                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                  var id = $(this).val();
                  if (selected_options.find(e => e.id == id)) {
                    $(this).prop('checked', 'checked');
                  } else {
                    $(this).prop('checked', false);
                  }
                });
                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.on("change", function() {
                  var newValue = [];
                  checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                      var id = $(this).val();
                      newValue.push(id);
                    }
                  });
                  hidden_input.val(JSON.stringify(newValue));
                });

                selectAlls.on("click", function(e) {
                  e.preventDefault();
                  var group = $(this).data("group");
                  var boxes = element.find('input[type=checkbox][data-group="' + group + '"]');
                  boxes.each(function(key, option) {
                    if (!$(this).is(':checked')) {
                      $(this).click();
                    }
                  });
                });
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
