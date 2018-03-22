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
            <div class="col-md-6 col-md-offset-7">
                <div class="col-md-4">
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> {{ trans('id.filter_according_to_text') }}
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">{{ trans('id.max_stock_text') }}</a></li>
                            <li><a href="#">{{ trans('id.min_stock_text') }}</a></li>
                            <li><a href="#">{{ trans('id.max_price_text') }}</a></li>
                            <li><a href="#">{{ trans('id.min_price_text') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    {!! Form::text('username','',['class'=>'form-control input-sm','placeholder'=> trans('id.search_product_text')]) !!}
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <hr>
	</div>
        
        <div class="row-fluid">
            @foreach ($products as $key => $data)
                <div class="col-md-5 box">
                    <div class="panel {{ $data->stock > 0 ? 'panel-primary':'panel-red' }}">
                        <div class="panel-heading">
                            {{ $data->name }}
                        </div>
                        <div class="panel-body">
                            <img src='{{ null != $data->img ? $data->img : asset('dist/img/noimage.png') }}' class='img-responsive' style="width:30%;margin-bottom:5px"/>
                            <p>
                                {{ $data->description }}
                            </p>
                            <p>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> {{ trans('id.tools_text') }}
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">{{ trans('id.edit_text') }}</a></li>
                                        <li><a href="#" style="color:red">{{ trans('id.delete_text') }}</a></li>
                                    </ul>
                                </div>
                                <a href="#" class="btn">{{ trans('id.view_text') }}</a>
                            </p>
                        </div>
                        <div class="panel-footer">
                            <p {{ $data->stock > 0 ?'':'style=color:red'}}>
                                {{ \Config::get('global.APPLIED_CURRENCY').number_format($data->sell, 2) }}
                            </p>
                            @if($data->stock == 0)
                                <p style="color:red">
                                    <i>{{ trans('id.out_of_stock_msg') }}</i>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

