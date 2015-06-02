@extends('front-end.layouts.default')

@section('page-title')
    <h2>{{ $page->title }}</h2>
@stop

@section('page-breadcrumb')

@stop

@section('content')
    {{ $page->body }}
@stop