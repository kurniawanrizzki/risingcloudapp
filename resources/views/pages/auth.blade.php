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
                            'method' => 'post'
                            ]) 
                        !!}

                            {!! Form::text('Username','',['class'=>'form-group form-control','placeholder'=> trans('id.username_text'), 'autofocus'=> '']) !!}
                            {!! Form::password('Password',['class'=>'form-group form-control','placeholder'=> trans('id.password_text')]) !!}

                            {!! Form::submit(trans('id.login_button_text'), ['class'=>'btn btn-lg btn-success btn-block']) !!}

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

