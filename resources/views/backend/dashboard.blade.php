@extends('layouts.app')

@section('title')
    Dashboard
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/maps/jquery-jvectormap-2.0.3.css') }}" />
    <link href="{{ asset('assets/css/icheck/flat/green.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/floatexamples.css" rel="stylesheet') }}" type="text/css" />
@stop

@section('content')
    <!-- top tiles -->
    <!-- Top Tiles 2 -->
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="count">{{ $data['statistic']['recentSignUp'] }}</div>
                <h3>New Sign ups</h3>
                <p>in the Last 7 Days</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-comments-o"></i></div>
                <div class="count">{{ $data['statistic']['recentFeedback'] }}</div>
                <h3>New Feedback</h3>
                <p>in the Last 7 Days</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-edit"></i></div>
                <div class="count">{{ $data['statistic']['recentResponse'] }}</div>
                <h3>New Responses</h3>
                <p>in the Last 7 Days</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12 dashboard">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Last Registered Alumni</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="{{ route('monitoring.alumni') }}"><i class="fa fa-external-link"></i> View All</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled msg_list">
                        @foreach($data['recentAlumni'] as $alumni)
                        <li>
                            <a href="{{ route('alumni.show', $alumni['id']) }}">
                                <span class="image">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="img" />
                                </span>
                                    <span>{{ $alumni['first_name'] . ' ' . $alumni['last_name'] }}</span>
                                    <span class="time">{{ $alumni['human_created_at'] }}</span>
                                <span class="message">{{ $alumni['nim'] }} <br> {{ $alumni['class'] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Daily Active Users -->
        <div class="col-sm-6 col-xs-12 dashboard">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Last Received Feedback</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="{{ route('monitoring.feedback') }}"><i class="fa fa-external-link"></i> View All</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled timeline">
                        @foreach($data['recentFeedback'] as $feedback)
                        <li>
                            <div class="block">
                                <div class="tags">
                                    <a href="" class="tag">
                                    <span>{{ $feedback['formatted_created_at'] }}</span>
                                    </a>
                                </div>
                                <div class="block_content">
                                    <h2 class="title">
                                        @for ($i = 1; $i <= $feedback['rating']; $i++) 
                                            <span style = "color:gold;" class="glyphicon glyphicon-star"></span>
                                        @endfor
                                        <?php $norating = 5 - $feedback['rating']; ?>
                                        @if($norating > 0)
                                            @for ($i = 1; $i <= $norating; $i++)
                                            <span style = "color:silver;" class="glyphicon glyphicon-star"></span>
                                            @endfor
                                        @endif
                                    </h2>
                                    <div class="byline">
                                        by <a href="{{ route('alumni.show', $feedback['user']['id']) }}">{{ $feedback['user']['first_name'] }}</a>
                                    </div>
                                    <p class="excerpt">{{ $feedback['feedback'] }}</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Timeline User Comment -->
    </div>
@stop

@section('footer_styles')
    
@stop