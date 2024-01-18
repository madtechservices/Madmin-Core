@if(isset($tabs) && !empty($tabs) && rendered_tab_count($tabs, $type))
    <div class="row" id="tabs" data-type="{{ $type }}">
        {{--<div class="{{ isset($crud) ? $crud->getCreateContentClass() : 'col-12' }}">--}}
        <div class="col-12">
            <ul class="nav nav-pills">
                @foreach ($tabs as $tab)
                    {{ $tab->render($type) }}
                @endforeach
            </ul>
        </div>
    </div>
@endif