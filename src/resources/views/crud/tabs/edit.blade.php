@extends('madmin-core::crud.edit')

@section('content')
    @include('madmin-core::crud.tabs.tabs', [ 'type' => 'edit' ])
    @parent
@endsection
