@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ __('madmin-core::magic-link.login') }}</h3>
            <div class="card">
                <div class="card-body">
                    @if(!session()->has('success'))
                        <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('magic-link.post') }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label class="control-label" for="{{ $username }}">{{ config('backpack.base.authentication_column_name') }}</label>

                                <div>
                                    <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                                    @if ($errors->has($username))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first($username) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('madmin-core::magic-link.post') }}
                                    </button>
                                    
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-success" role="alert">
                            {{ __('madmin-core::magic-link.sent') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center"><a href="{{ route('backpack.auth.login') }}">{{ __('madmin-core::magic-link.back_to_login') }}</a></div>
        </div>
    </div>
@endsection
