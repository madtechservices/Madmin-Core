<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<body class="app flex-row align-items-center">

  @yield('header')

  @php
$locales_array = config('backpack.crud.locales');
@endphp

@if(!empty($locales_array) && count($locales_array) > 1)
<div class="auth-lang">
    <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        @php
            $locale = \Illuminate\Support\Facades\App::getLocale();
            if($locale == 'en')
                $locale = 'gb';
            if(strpos($locale, '_') !== false)
                $locale = substr($locale, 0, strpos($locale, '_'));
        @endphp
        <img
            src="https://flagcdn.com/16x12/{{$locale}}.png"
            width="16"
            height="12"
        >
    </button>
    <div class="dropdown-menu dropdown-menu-right py-0 lang-selector">
        @foreach ($locales_array as $locale_shortcode => $locale_name)
            <a
                class="dropdown-item {{ \Illuminate\Support\Facades\App::getLocale() == $locale_shortcode ? 'active disabled' : '' }}"
                href="{{ route('change-lang', [$locale_shortcode]) }}"
            >
                @php
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
            </a>
        @endforeach
    </div>
</div>
@endif

  <div class="container">
    <div class="auth-card">
        <div class="auth-top">
          <div class="auth-brand" title="{{ config('backpack.base.project_name') }}">
            {!! config('madmin-core.config.login_logo') ?? config('backpack.base.project_logo') !!}
          </div>
        </div>
        <div class="auth-bottom">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <footer class="app-footer sticky-footer">
    @include('backpack::inc.footer')
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

</body>
</html>
