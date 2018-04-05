@extends("templates/components/sidebar")
@section("dashboard.title",trans('id.main_title'))
@section("dashboard.content")
    <div id="page-wrapper">
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ trans('id.main_title') }}
                </h1>
            </div>       
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2  pull-right">
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> {{ trans('id.form_create_text') }}
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" data-target="#product-add-form" data-backdrop="static" data-keyboard="false">{{ trans('id.new_product_text') }}</a></li>
                            <li><a data-toggle="modal" data-target="#category-add-form" data-backdrop="static" data-keyboard="false">{{ trans('id.new_category_text') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <div class="row">

            @if(isset($alert) || \Session::has('alert'))
                <div class='col-md-12 alert 
                        {{ !isset($alert)?
                                 (\Session::get('alert')->responseJSON->status == 200?'alert-success':'alert-danger'):
                                'alert-success' 
                        }}'>
                    <i>
                        {{ !isset($alert)?\Session::get('alert')->responseJSON->message:$alert }}
                    </i>
                </div>
            @endif 

        </div>

        <div class="row">

            @if(isset($categories)) 
                @foreach ($categories as $key => $data)

                    <div class="col-md-3">
                        <div class="rs-img-frame">
                            <a href="{{ route('dashboard.product.view',$data->id) }}">
                                <img src='{{ asset('img/'.$data->img) }}' class='img-responsive' alt='{{ $data->name }}'/>
                            </a>
                            <div class="overlay">
                                <h4>{{ $data->name }}</h4>
                                <p class="rs-ellipsis">
                                    {{ $data->description }}
                                </p>

                                @if(\Session::get('role') === \Config::get('global.ADMIN_ROLE_ID'))
                                    <div class="pull-right">

                                        <button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#category-edit-form" data-backdrop="static" data-keyboard="false" data-edit="{{ $data }}"><i class="fa fa-pencil fa-fw"></i></button>
                                        <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#delete-alert" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}"><i class="fa fa-trash-o fa-fw"></i></button>

                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                @endforeach

            @endif

        </div>

    </div>
@endsection

