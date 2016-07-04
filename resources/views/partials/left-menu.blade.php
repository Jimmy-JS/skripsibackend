<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><img src="{{ asset('assets/images/logo_thumb.png') }}" alt=""> <span style="padding-left: 15px;">Study Tracer</span></a>
        </div>
        <hr>
        <div class="clearfix"></div>
        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('dashboard.index') }}"><i class="fa fa-home"></i>Dashboard</a>
                    </li>
                </ul>
                @if ($user->is_super_admin != 1)
                    <ul class="nav side-menu">
                        <li>
                            <a href="{{ url('questionnaire') }}"><i class="fa fa-edit"></i>Question List</a>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="menu_section">
                @if ($user->is_super_admin == 1)
                    <h3>Setting</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-edit"></i> Questionnaire <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="{{ url('questionnaire/create') }}">Create New Question</a></li>
                                <li><a href="{{ url('questionnaire') }}">Question List</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div>
            @if ($user->is_super_admin == 1)
                <div class="menu_section">
                    <h3>Account Management</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a href="{{ url('account/create/admin') }}"><i class="fa fa-user"></i> Create Admin Account </a>
                        </li>
                        <li>
                            <a href="{{ url('account/create/superAdmin') }}"><i class="fa fa-user-secret"></i> Create Super Admin </a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="menu_section">
                    <h3>Monitoring & Report</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-laptop"></i> Monitoring <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu" style="display: none">
                                <li><a href="{{ route('monitoring.alumni') }}">Recent Registered Alumni</a>
                                </li>
                                <li><a href="{{ route('monitoring.feedback') }}">Recent Received Feedback</a>
                                </li>
                                <li><a href="{{ route('monitoring.questionnaire.index') }}">Recent Received Responses</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('reporting.index') }}"><i class="fa fa-bar-chart-o"></i> Report</a>
                        </li>
                        <li>
                            <a href="{{ route('alumni.index') }}"><i class="fa fa-user"></i> Alumni List </a>
                        </li>
                        <li>
                            <a href="{{ route('feedback.index') }}"><i class="fa fa-comments-o"></i> Feedback List </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>