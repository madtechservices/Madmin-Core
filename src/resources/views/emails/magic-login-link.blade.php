@extends('madmin-core::email.template')

@section('style')
    <style type="text/css">
        a {
            color: #fff;
        }

        a.footer-link {
            color: #2e58ff;
        }

        /*
        .background {
            background: #c7c7c7;
        }

        .foreground {
            background: #526c8b;
        }
        */
    </style>
@endsection

@section('content')
<x-madmin-core::email-title>
    Üdv, {{ $name }}!
</x-madmin-core::email-title>
<x-madmin-core::email-content>
    <p>
        Please click on the link below to log in.
    </p>
</x-madmin-core::email-content>
<x-madmin-core::email-button
    :href="$url"
    text="Login"
    background="#2e58ff"
    textColor="#fff"
></x-madmin-core::email-button>
<x-madmin-core::email-content>
    <p>
        <a href="{{ $url }}">{{ $url }}</a>
    </p>
</x-madmin-core::email-content>
@endsection
