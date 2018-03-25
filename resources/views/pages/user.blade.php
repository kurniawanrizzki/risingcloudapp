@extends("templates/components/sidebar")
@section("dashboard.title",trans('id.users_title'))
@section("dashboard.content")

    <div id="page-wrapper">
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ trans('id.users_title') }}
                </h1>
            </div>       
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left" style="padding-top: 7.5px;">{{ trans('id.users_list_text') }}</h4>
                        <button type="button" class="btn btn-default btn-outline pull-right" data-toggle="modal" data-target="#user-add-form" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus fa-fw"></i> {{ trans('id.form_user_create_text') }}</button>
                    </div>
                
                    <div class="panel-body">
                        @if(\Session::has('alert')) 
                        <div class="alert alert-danger">
                            {{ \Session::get('alert')->responseJSON->message }}
                        </div>
                        @endif
                        <table width="100%" class="table table-striped table-bordered table-hover" id="users_table">
                            <thead>
                                <tr>
                                    @foreach (\Config::get('global.USERS_COLUMNS_TITLE') as $key)
                                        <th> {{ $key }} </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($users as $key => $data)
           
                                <tr>
                                    <td> {{ "USER".str_pad($data->id, 6, "0", STR_PAD_LEFT) }} </td>
                                    <td> {{ $data->username }} </td>
                                    <td> {{ $data->role == \Config::get('global.ADMIN_ROLE_ID')?trans('id.role_options_text')[0]:trans('id.role_options_text')[1] }} </td>
                                    <td> {{ $data->phone }} </td>
                                    <td> {{ $data->address }} </td>
                                    <td align="center">
                                       
                                        <button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#user-edit-form" data-backdrop="static" data-keyboard="false" data-edit="{{ $data }}"><i class="fa fa-pencil fa-fw"></i></button>
                                        <button type="button" class="btn btn-success btn-circle" data-toggle="modal" data-target="#user-password-form" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}"><i class="fa fa-key fa-fw"></i></button>

                                        @if ($data->id != \Session::get('id'))
                                            <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#delete-alert" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}"><i class="fa fa-trash-o fa-fw"></i></button>
                                        @endif
                                        
                                    </td>
                                </tr>
                                
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@endsection


