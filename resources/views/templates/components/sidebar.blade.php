@extends("templates/components/dashboard")
@section("dashboard.sidebar")

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('dashboard.index') }}">{{env("APP_NAME")}}</a>
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

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                        {{ trans('id.main_title') }}
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> 
                            {{ trans('id.transaction_title') }}<span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            
                            @if(\Session::get('role') == \Config::get('global.ADMIN_ROLE_ID'))
                    
                                <li>
                                    <a href="{{ route('dashboard.transaction.view') }}"><i class="fa fa-files-o fa-fw"></i>
                                        {{ trans('id.report_title') }}
                                    </a>
                                </li>

                            @endif
                            
                            <li>
                                <a href="{{ route('dashboard.transaction.index') }}"><i class="fa fa-barcode fa-fw"></i>
                                    {{ trans('id.cashier_title') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(\Session::get('role') == \Config::get('global.ADMIN_ROLE_ID'))
                    
                        <li>
                            <a href="{{ route('dashboard.user') }}"><i class="fa fa-users fa-fw"></i>
                                {{ trans('id.users_title') }}
                            </a>
                        </li>
                    
                    @endif
                </ul>
            </div>
        </div>
    </nav>
        
    @modal (
        user-own-form,
        user-canceled-own-filled-form,
        id.profile_title,
        global.PROFILE_ACTION
    )
    
    @modal (
        user-add-form,
        user-canceled-filled-add-form,
        id.create_form_title_text,
        global.USER_ADD_ACTION
    )

    @modal (
        user-edit-form,
        user-canceled-edit-filled-edit-form,
        id.edit_form_title_text,
        global.USER_EDIT_ACTION
    )
    
    @modal (
        category-add-form,
        category-canceled-filled-add-form,
        id.category_create_form_title_text,
        global.CATEGORY_ADD_ACTION
    )
    
    @modal (
        category-edit-form,
        category-canceled-edit-filled-edit-form,
        id.category_edit_form_title_text,
        global.CATEGORY_EDIT_ACTION
    )
    
    @modal (
        product-add-form,
        product-canceled-filled-add-form,
        id.product_create_form_title_text,
        global.PRODUCT_ADD_ACTION
    )
    
    @modal (
        product-edit-form,
        product-canceled-edit-filled-edit-form,
        id.product_edit_form_title_text,
        global.PRODUCT_EDIT_ACTION
    )
    
    @modal (
        product-add-form,
        product-canceled-filled-add-form,
        id.product_create_form_title_text,
        global.PRODUCT_ADD_ACTION
    )
    
    @modal (
        user-own-password-form,
        user-own-canceled-password-filled-form,
        id.edit_form_change_password_text,
        global.OWN_CHANGE_PASSWORD_ACTION
    )
    
    @modal (
        user-password-form,
        user-canceled-password-filled-form,
        id.edit_form_change_password_text,
        global.USER_CHANGE_PASSWORD_ACTION
    )

    @alert (
        delete-alert,
        FALSE,
        danger,
        id.delete_msg
    )

@endsection
