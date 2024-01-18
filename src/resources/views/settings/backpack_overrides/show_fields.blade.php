@php
    $groupedFields = [];
    if(!empty($fields)) {
        $result = array();
        foreach($fields as $val) {
            if(array_key_exists('group', $val)){
                $result[$val['group']][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
        $groupedFields = $result;   
    }
@endphp

@foreach ($groupedFields as $fieldGroup => $fields)
    <div class="col-12">
        @if(is_string($fieldGroup) && $fieldGroup != '')
            <div style="display: flex; flex-flow: row; align-items: flex-end; margin-bottom: 15px;">
                <div style="font-size: 18px; font-weight: 600; display: inline-block; margin: 0; padding: 0 10px 0 0;">
                    {{ $fieldGroup }}
                </div>
                <div style="display: flex; flex: 1 1; background: #e5e5e5; height: 1px;"></div>
            </div>
        @endif
        <div class="row">
            @foreach($fields as $field)
                @php
                    $fieldsViewNamespace = $field['view_namespace'] ?? 'crud::fields';
                @endphp
                @include($fieldsViewNamespace . '.' . $field['type'], ['field' => $field])
            @endforeach
        </div>
    </div>
@endforeach
