<html>
    <head>
        
        <title>            
            {{env('APP_NAME')." - Struk"}}  
        </title>
        <link href="{{asset('dist/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('dist/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        
        <div style="margin: 10px; max-width: 200px">            
            <div class="row">
                <div class="col-sm-3">
                    <img src="{{ asset('img/roundlogo.jpg') }}" class="img-responsive" style="max-height: 40px;max-width: 40px;"/>
                </div>
                <div class="col-sm-6" style="padding: 4px">
                    <strong style="font-size: 8px;">{{ \Config::get('global.STORE_NAME') }}</strong>
                    <p style="font-size: 6px;">{{ \Config::get('global.STORE_ADDRESS') }}</p>
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col-md-9">
                    
                    <table>
                        <tr>
                            <td style="font-size: 6px;width: 18px;">No</td>
                            <td style="font-size: 6px;width: 5px;">:</td>
                            <td style="font-size: 6px;width: 97px;">
                                {{ "TRAN".str_pad($struk[0]->id, 6, "0", STR_PAD_LEFT) }}
                            </td>
                            <td style="font-size: 6px;">{{ explode(" ",$struk[0]->created_at)[0] }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 6px;">Kasir</td>
                            <td style="font-size: 6px;">:</td>
                            <td style="font-size: 6px;">{{ $struk[0]->cashier }}</td>
                            <td style="font-size: 6px;">{{ explode(" ",$struk[0]->created_at)[1] }}</td>
                        </tr>
                    </table>
                    
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col-md-9">
                    
                    <table>
                        <thead>
                            <tr>
                                @foreach (\Config::get('global.STRUK') as $key => $value)
                                    <th style="font-size: 6px;width: {{ $value[1] }}">{{ $value[0] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        @foreach($struk as $key => $value)
                        <tr>
                            <td style="font-size: 6px;">{{ $value->product_name }}</td>
                            <td style="font-size: 6px;">{{ $value->counted }}</td>
                            <td style="font-size: 6px;">{{ \Config::get('global.APPLIED_CURRENCY').number_format($value->sell,2) }}</td>
                            <td style="font-size: 6px;">{{ number_format($value->total,2) }}</td>
                        </tr>
                        @endforeach
                    </table>
                    
                </div>
            </div>
            
            <div class="row" style="margin-top: 10px">
                <div class="col-md-9">
                    
                    <table>
                        <tr>
                            <td style="font-size: 6px;width: 30px">Total</td>
                            <td style="font-size: 6px;width: 5px;">:</td>
                            <td style="font-size: 6px;width: 80px;">
                                {{ number_format($struk[0]->amount,2) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 6px;">Tunai</td>
                            <td style="font-size: 6px;">:</td>
                            <td style="font-size: 6px;">{{ \Config::get('global.APPLIED_CURRENCY').number_format($struk[0]->cash,2) }}</td>
                        </tr>
                        @if($struk[0]->remained > 0)
                        <tr>
                            <td style="font-size: 6px;">Kembali</td>
                            <td style="font-size: 6px;">:</td>
                            <td style="font-size: 6px;">{{ \Config::get('global.APPLIED_CURRENCY').number_format(($struk[0]->remained),2) }}</td>
                        </tr>
                        @endif
                    </table>
                    
                </div>
            </div>
            <div style="margin-top: 20px;max-width: 150px;">
                <p style="font-size: 6px; text-align: center;">
                    {{ \Lang::get('id.thank_you_text') }}
                </p>
            </div>
        </div>
        
        <script src="{{asset('dist/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('dist/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    </body>
</html>

