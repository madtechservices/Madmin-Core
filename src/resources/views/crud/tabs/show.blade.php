@extends('crud::show')

@section('content')
    @include('madmin-core::crud.tabs.tabs', [ 'type' => 'show' ])
    @parent
@endsection
