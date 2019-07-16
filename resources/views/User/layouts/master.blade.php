@extends("Site.layouts.pure-master")

@section("main-title")
    @yield('title')
@endsection

@section("main-class")
    @yield('class')
@endsection

@section("main-content")
    @include("Site.includes.warning")
    @include("User.includes.header")

        @yield("content")

    @include("Site.includes.footer")
@endsection

@section('main-style')
    @yield("style")
@endsection

@section("main-script")
    @yield("script")
@endsection

