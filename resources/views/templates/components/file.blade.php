<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="{{public_path('dist/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{public_path('dist/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{public_path('dist/css/sb-admin-2.css')}}" rel="stylesheet">
    </head>
    <body>
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ trans('id.report_title') }}
                </h1>
            </div>       
        </div>
        
        <div class="row">
            <div class="col-md-2">
                <h4>Total Transaksi</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    <i>{{ \Config::get('global.APPLIED_CURRENCY').number_format($report['total_transactions'], 2) }}</i>
                </h4>
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
                                        @if($key !== \Config::get('global.TRANSACTIONS_COLUMNS_TITLE')[4])
                                            <th> {{ $key }} </th>
                                        @endif
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
                                </tr>
                                
                                @endforeach
                                
                            </tbody>
                        </table>                        
                    </div>
                        
                </div>
            </div>
        </div>
        
        
    </body>
</html>


