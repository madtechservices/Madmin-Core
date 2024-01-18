@extends('crud::create')

@section('content')
    @include('madmin-core::crud.tabs.tabs', [ 'type' => 'create' ])
    @parent
@endsection
