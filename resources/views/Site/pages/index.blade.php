@extends('Site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

    @include('Site.includes.search')
    @include('Site.includes.offer')
    @include('Site.includes.cat')
    @include('Site.includes.app')
    @include('Site.includes.contact')

@endsection