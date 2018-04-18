@extends("templates/components/sidebar")
@section("dashboard.title",trans('id.report_title'))
@section("dashboard.content")

    <div id="page-wrapper">
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ trans('id.report_title') }}
                </h1>
            </div>       
        </div>
        
        <div class="row">
            
            <div class="row pull-right" style="margin-right: 2px;">

                <div class='col-sm-5'>
                    <div class="form-group">
                        <label>Mulai dari</label>
                        <div class='input-group date' id='report-from-filter'>
                            <input type='text' class="form-control" name="report-from-filter-field"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class='col-sm-5'>
                    <div class="form-group">
                        <label>Berakhir pada</label>
                        <div class='input-group date' id='report-end-filter'>
                            <input type='text' class="form-control" name="report-end-filter-field"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-2' style="margin-top:4px;">
                    &nbsp;
                    <button type="button" class="btn btn-primary input-group" id="transaction_search_btn"><i class="fa fa-search fa-fw"></i> {{ trans('id.search_txt') }}</button>
                </div>

            </div>
            
        </div>
        
        <div class="row" id="transaction_total_result" style="display:none;">
            <div class="col-md-2">
                <h4>Total Transaksi</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    <i id="total_output"></i>
                </h4>
            </div>
            <div class="col-md-1">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <a type="button" class="btn btn-outline btn-primary btn-circle" style="margin-top: 5px;" id="download_report_id"><i class="fa fa-download fa-fw"></i></a>
            </div>
        </div>
        
        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left" style="padding-top: 7.5px;">{{ trans('id.report_list_text') }}</h4>
                    </div>
                
                    <div class="panel-body">
                        
                        <table width="100%" class="table table-striped table-bordered table-hover" id="transactions_table">
                            <thead>
                                <tr>
                                    @foreach (\Config::get('global.TRANSACTIONS_COLUMNS_TITLE') as $key)
                                        <th> {{ $key }} </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($report['item'] as $key => $data)
           
                                <tr>
                                    <td> {{ "TRAN".str_pad($data['id'], 6, "0", STR_PAD_LEFT) }} </td>
                                    <td> {{ $data['reported'] }} </td>
                                    <td style="direction: rtl;" class="created_at_transaction_item"> {{ $data['created_at'] }} </td>
                                    <td style="direction: rtl;"> {{ \Config::get('global.APPLIED_CURRENCY').number_format($data['amount'], 2) }} </td>
                                    <td align="center">
                                       
                                        <button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#transaction-details-view" data-transaction="{{ json_encode($data) }}"><i class="fa fa-search fa-fw"></i></button>
                                        
                                    </td>
                                </tr>
                                
                                @endforeach
                                
                            </tbody>
                        </table>                        
                    </div>
                        
                </div>
                
                <div class='modal fade' id='transaction-details-view' tabindex='-1' role='dialog' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                            <div class='modal-header'>
                                <h4 class='modal-title' id="transaction-details-view-title"></h4>
                            </div>

                            <div class='row'>
                                <div class='col-lg-12'>
                                    <div class='panel'>
                                        <div class="panel-body">
                                            
                                            <table class="table table-hover">
                                                
                                                <tr>
                                                    <td>{{ \Config::get('global.TRANSACTIONS_COLUMNS_TITLE')[0] }}</td>
                                                    <td>:</td>
                                                    <td id="transaction-details-view-id"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ \Config::get('global.TRANSACTIONS_COLUMNS_TITLE')[1] }}</td>
                                                    <td>:</td>
                                                    <td id="transaction-details-view-cashier"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ \Config::get('global.TRANSACTIONS_COLUMNS_TITLE')[2] }}</td>
                                                    <td>:</td>
                                                    <td id="transaction-details-view-created_at"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ \Config::get('global.TRANSACTIONS_COLUMNS_TITLE')[3] }}</td>
                                                    <td>:</td>
                                                    <td id="transaction-details-view-amount"></td>
                                                </tr>
                                                
                                            </table>
                                            
                                            <table class="table table-hover" id='transaction-details-items-view'>
                                                
                                                <thead>
                                                    <tr>
                                                        @foreach (\Config::get('global.TRANSACTION_DETAILS_COLUMNS_TITLE') as $key)
                                                        <th>{{ $key }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                
                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

@endsection



