@yield('topbar_right')

@if (config('madmin-core.config.show_account_selector') === true || ($crud_account_selector??false) === true)
    @if (session('account_id') && backpack_user()->selectable_accounts->count() > 1)
        <li class="nav-item mr-2">
            <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {{ backpack_user()->selectable_accounts->firstWhere('id', session('account_id'))?->name??'' }}
            </button>
            <div class="dropdown-menu dropdown-menu-right py-0">
                @foreach (backpack_user()->selectable_accounts as $account)
                    <a
                        class="dropdown-item {{ session('account_id') == $account->id ? 'active disabled' : '' }}"
                        href="{{ route('admin.change-account', [$account->id]) }}"
                    >
                        {{ $account->name??'' }}
                    </a>
                @endforeach
            </div>
        </li>
    @endif
@endif

@php
    $locales_array = config('backpack.crud.locales');
@endphp

@if(!empty($locales_array) && count($locales_array) > 1)
    <li class="nav-item mr-2">
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
    </li>
@endif
