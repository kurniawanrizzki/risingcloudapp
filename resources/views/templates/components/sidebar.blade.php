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
                    <i class="fas fa-user-circle"></i> <i class="fas fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="#"><i class="fas fa-user-circle"></i>
                        {{ trans('id.profile_title') }}
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('auth.logout') }}"><i class="fas fa-sign-out-alt"></i> 
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
                        <a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i>
                        {{ trans('id.main_title') }}
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-exchange-alt"></i> 
                            {{ trans('id.transaction_title') }}<span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fas fa-file-alt"></i>
                                    {{ trans('id.report_title') }}
                                </a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-sellsy"></i>
                                    {{ trans('id.cashier_title') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-users"></i>
                            {{ trans('id.users_title') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

@endsection
