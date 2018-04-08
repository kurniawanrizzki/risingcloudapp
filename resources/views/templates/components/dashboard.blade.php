@extends("templates/layout")

@section("title")
    @parent
    @yield("dashboard.title")
@endsection

@section("content")

    <div id="wrapper">
        
        @if(\Route::currentRouteName() !== 'dashboard.transaction.index')
            @yield("dashboard.sidebar")
        @endif
        
        @yield("dashboard.content")
    </div>

@endsection


