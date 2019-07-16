@extends("Site.layouts.pure-master")

@section("main-title")
    @yield('title')
@endsection

@section("main-class")
    @yield('class')
@endsection

@section('main-script')
    @yield("script")
@endsection
@section('main-style')
    @yield("style")
@endsection
@section("main-content")
    @include('Site.includes.warning')
    @if(auth()->check())
        @include('User.includes.header')
    @else
        @include('Site.includes.header')
    @endif
        @yield('content')

    @include('Site.includes.footer')
@endsection