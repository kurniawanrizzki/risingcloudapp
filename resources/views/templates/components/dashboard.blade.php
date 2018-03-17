@extends("templates/layout")

@section("title")
    @parent
    @yield("dashboard.title")
@endsection

@section("content")

    <div id="wrapper">
        @yield("dashboard.sidebar")
        @yield("dashboard.content")
    </div>

@endsection


