@extends('crud::list')

@section('content')
    @include('madmin-core::crud.tabs.tabs', [ 'type' => 'list' ])
    @parent
@endsection
