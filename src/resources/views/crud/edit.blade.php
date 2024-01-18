@extends(backpack_view('blank'))


@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.edit') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>

            @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getEditContentClass() }}">
            {{-- Default box --}}

            @include('crud::inc.grouped_errors')

            <form method="post"
                  action="{{ url($crud->route.'/'.$entry->getKey()) }}"
                  @if ($crud->hasUploadFields('update', $entry->getKey()))
                  enctype="multipart/form-data"
                @endif
            >
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}

                @if ($crud->model->translationEnabled())
                    <div class="mb-2 text-right">
                        {{-- Single button --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @php
                                    $locale_shortcode = request()->input('_locale')?request()->input('_locale'):App::getLocale();
                                    if($locale_shortcode == 'en')
                                        $locale_shortcode = 'gb';
                                    if(strpos($locale_shortcode, '_') !== false)
                                        $locale_shortcode = substr($locale_shortcode, 0, strpos($locale_shortcode, '_'));
                                @endphp
                                <img
                                    src="https://flagcdn.com/16x12/{{$locale_shortcode}}.png"
                                    width="16"
                                    height="12"
                                >
                            </button>
                            <ul class="dropdown-menu lang-selector">
                                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                    @php
                                        $locale_shortcode = $key;
                                        if($locale_shortcode == 'en')
                                            $locale_shortcode = 'gb';
                                        if(strpos($locale_shortcode, '_') !== false)
                                            $locale_shortcode = substr($locale_shortcode, 0, strpos($locale_shortcode, '_'));
                                    @endphp
                                    <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?_locale={{ $key }}">
                                        <img
                                            src="https://flagcdn.com/16x12/{{$locale_shortcode}}.png"
                                            width="16"
                                            height="12"
                                        >
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                {{-- load the view from the application if it exists, otherwise load the one in the package --}}
                @if(view()->exists('vendor.backpack.crud.form_content'))
                    @include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                @else
                    @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                @endif
                {{-- This makes sure that all field assets are loaded. --}}
                <div class="d-none" id="parentLoadedAssets">{{ json_encode(Assets::loaded()) }}</div>
                @include('crud::inc.form_save_buttons')
            </form>
        </div>
    </div>
@endsection

