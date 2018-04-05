@extends("templates/components/sidebar")
@section("dashboard.title",trans('id.product_title'))
@section("dashboard.content")
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ isset($categoryName)?$categoryName:trans('id.product_title') }}
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
                            <li><a href="?orderBy=stock&sortBy=desc">{{ trans('id.max_stock_text') }}</a></li>
                            <li><a href="?orderBy=stock&sortBy=asc">{{ trans('id.min_stock_text') }}</a></li>
                            <li><a href="?orderBy=sell&sortBy=desc">{{ trans('id.max_price_text') }}</a></li>
                            <li><a href="?orderBy=sell&sortBy=asc">{{ trans('id.min_price_text') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    {!! Form::text('search','',['class'=>'form-control input-sm','placeholder'=> trans('id.search_product_text')]) !!}
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" type="button" id="search_btn">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <hr>
	</div>
        
        @if(isset($alert) || \Session::has('alert'))
       
        <div class="row">
            <div class='col-md-12 alert {{ !isset($alert)?
                (\Session::get('alert')->responseJSON->status == 200?'alert-success':'alert-danger'):
                ($alert->getData()->responseJSON->status == 200?'alert-success':'alert-danger') }}'>

                <i>{{ !isset($alert)?
                    \Session::get('alert')->responseJSON->message:
                    $alert->getData()->responseJSON->message 
                }}</i>

            </div>
        </div>

        @endif 
        
        <div class="row-fluid">

            @if(isset($products))
            
                @foreach ($products as $key => $data)
                    <div class="col-md-5 box">
                        <div class="panel {{ $data->stock > 0 ? 'panel-primary':'panel-red' }}">
                            <div class="panel-heading">
                                {{ "PROD".str_pad($data->id, 6, "0", STR_PAD_LEFT) ." - ". $data->name }}
                            </div>
                            <div class="panel-body" style="height: 250px;">
                                <img src='{{ asset('img/'.$data->img) }}' class='img-responsive' style="width:30%;margin-bottom:5px"/>
                                <p class="rs-ellipsis">
                                    {{ $data->description }}
                                </p>
                                <p>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> {{ trans('id.tools_text') }}
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a data-toggle='modal' data-target='#product-edit-form' data-backdrop='static' data-keyboard='false' data-edit='{{ $data }}'>{{ trans('id.edit_text') }}</a></li>
                                            <li><a data-toggle='modal' data-target='#delete-alert' data-backdrop='static' data-keyboard='false' data-id='{{ $data->id }}'  style="color:red">{{ trans('id.delete_text') }}</a></li>
                                        </ul>
                                    </div>
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
            
            @endif
            
        </div>
        
        <div class="row">
            
            @if(isset($products))
            
                <div class="col-md-6 pull pull-right">
                    {{ $products->render() }}
                </div>
            
            @endif
            
            
        </div>
        
    </div>
@endsection

