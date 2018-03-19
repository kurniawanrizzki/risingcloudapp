@extends("templates/layout")

@section('title')
    @parent
    {{ trans('id.login_title') }}
@endsection

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('id.login_header_text') }}</h3>
                    </div>
                    <div class="panel-body">

                        {!! Form::open([
                            'route' => 'auth.action', 
                            'method' => 'post'
                        ]) 
                        !!}
                        
                            {{ csrf_field() }}

                            {!! Form::text('username','',['class'=>'form-group form-control','placeholder'=> trans('id.username_text'), 'autofocus'=> '']) !!}
                            {!! Form::password('password',['class'=>'form-group form-control','placeholder'=> trans('id.password_text')]) !!}

                            {!! Form::submit(trans('id.login_button_text'), ['class'=>'btn btn-lg btn-success btn-block']) !!}

                        {!! Form::close() !!}
                        
                    </div>
                </div>
                
                @if (\Session::has('alert'))
                    <div class="alert {{ \Session::get('alert') != \Config::get('global.SESSION_END_ERROR') ? 'alert-danger':'alert-success' }}">
                        @switch(\Session::get('alert'))
                            @case(\Config::get('global.USERNAME_NOT_FOUND_ERROR'))
                                {{ trans('id.username_not_found_msg') }}
                            @break
                            @case(\Config::get('global.PASSWORD_NOT_MATCHED_ERROR'))
                                {{ trans('id.password_not_matched_msg') }}
                            @break;
                            @case(\Config::get('global.SESSION_END_ERROR'))
                                {{ trans('id.end_session_msg') }}
                            @break
                            @default
                        @endswitch
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

