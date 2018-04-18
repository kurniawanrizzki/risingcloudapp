@extends("templates/components/dashboard")
@section("dashboard.title",trans('id.transaction_title'))
@section("dashboard.content")
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                <i class="glyphicon glyphicon-menu-left"></i>
                {{env("APP_NAME")}}
            </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a data-toggle="modal" data-target="#user-own-form" data-backdrop="static" data-keyboard="false" id="profile-id"><i class="fa fa-user fa-fw"></i>
                        {{ trans('id.profile_title') }}
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> 
                        {{ trans('id.logout_title') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        
    </nav>
    
    <div class="page-wrapper" style="margin: 10px;">
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default" style="min-height: 518px">
                    <div class="panel-heading">
                        {{ \Lang::get('id.product_transaction_title_txt') }}
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::text('product_autocomplete','',['class'=>'form-group form-control','placeholder'=>trans('id.search_product_text')]) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="overflow-y:scroll; height:355px">
                            <div class="col-md-12">
                                <div id="products_transaction" class="panel-group">
                                    
                                    @foreach ($products as $value)

                                        <div class="panel panel-primary" id="panel-category-{{ $value['category_id'] }}">

                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#category-{{ $value['category_id'] }}" data-parent="#products_transaction">{{ $value['category_name'] }}</a>
                                                </h4>

                                            </div>

                                            <div id="category-{{ $value['category_id'] }}" class="panel-collapse collapse">

                                                <div class="panel-body" style="overflow-y:scroll; height:300px">
                                                    <div class="row">
                                                        
                                                        @foreach ($value['products'] as $item)
                                                        
                                                        <div class="col-md-3 product_item" style="margin-bottom: 5px;" id="col-item-product-{{ $item->id }}">
                                                            
                                                            <div class="panel panel-default product-panel-event" data-product="{{ $item }}">
                                                            
                                                                <div class="panel-heading rs-ellipsis">
                                                                    <span>{{ $item->name }}</span>
                                                                </div>

                                                                <div class="panel-body">
                                                                    <img class="img-responsive" src="{{ asset('img/'.$item->img) }}" style="height: 141px;width: 141px;"/>
                                                                </div>

                                                                <div class="panel-footer">
                                                                    <p {{ $item->stock > 0 ?'':'style=color:red'}}>
                                                                        {{ \Config::get('global.APPLIED_CURRENCY').number_format($item->sell, 2) }}
                                                                        @if($item->stock == 0)
                                                                            {{ '( '.trans('id.out_of_stock_msg').' )' }}
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        @endforeach
                                                        
                                                        
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ \Lang::get('id.detail_transaction_title_txt') }}
                            </div>
                            <div class="panel-body" style="overflow-y:scroll;height: 133px;">
                                
                                <div class="list-group" id="detailed-list-group">
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        
                        <div class="panel panel-default" style="min-height: 167px">
                            <div class="panel-heading">
                                {{ \Lang::get('id.total_transaction_title_txt') }}
                            </div>
                            <div class="panel-body">
                                <form id="cashier-form-id">
                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label>Sub Total</label>
                                        <div class="input-group">
                                            
                                            <span class="input-group-addon">
                                                {{ \Config::get('global.APPLIED_CURRENCY') }}
                                            </span>
                                            <input class="form-control" name="sub_total_field" disabled="" style="direction: rtl;">
                                            
                                        </div>
                                        <p class="help-block">Jumlah yang harus dibayarkan.</p>
                                    </div>  
                                    <div class="form-group">
                                        <label>Bayar</label>
                                        <div class="input-group">
                                            
                                            <span class="input-group-addon">
                                                {{ \Config::get('global.APPLIED_CURRENCY') }}
                                            </span>
                                            <input class="form-control" name="pay_field" style="direction: rtl;">
                                            
                                        </div>
                                        <p class="help-block">Jumlah uang yang dibayarkan.</p>
                                    </div>  
                                    <div class="form-group">
                                        <input class="btn btn-md btn-success btn-block" value="Cetak Nota" id="transaction_btn" type="submit" disabled="">
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
@endsection
