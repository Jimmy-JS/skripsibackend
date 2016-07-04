@extends('layouts.app')

@section('title')
    View Alumni Profile | Alumni
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/vertical_timeline/style.css') }}"> <!-- Resource style -->
    <script src="{{ asset('assets/js/vertical_timeline/modernizr.js') }}"></script> <!-- Modernizr -->
    <link href="{{ asset('assets/css/icheck/flat/green.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $alumni->first_name }}'s Profile</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left text-center well">
                        <div class="profile_img">
                            <img src="{{ asset('assets/images/user.png') }}" alt="{{ $alumni->first_name . ' ' . $alumni->last_name }} Photo" class="img-circle well-profile-circle img-responsive" style="margin: 0 auto;">
                        </div>
                        <h3>{{ $alumni->first_name . ' ' . $alumni->last_name }}</h3>
                        @if($isFilled)
                            <p class="label label-success">Already Filled the Questionnaire</p>
                        @else
                            <p class="label label-danger">Not Fill Questionnaire Yet</p>
                        @endif
                        <hr />

                        <div class="row top_tiles">
                            <div class="animated flipInY col-xs-12 label-dark">
                                <div class="tile-stats">
                                    <h2>Joined Since</h2>
                                    <h3 style="font-size: 20px;">{{ $alumni->created_at->format('d F Y') }}</h3>
                                </div>
                            </div>
                        </div>

                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $alumni->address }}
                            </li>
                            <li class="m-top-xs">
                                <i class="fa fa-envelope user-profile-icon"></i> {{ $alumni->email }}
                            </li>
                            <li>
                                <i class="fa fa-phone user-profile-icon"></i> {{ $alumni->phone }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Profile</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Work Experience</a>
                                </li>
                                <li role="presentation" class=""><a href="#questionnaire-response-content" role="tab" id="questionnaire-response-tab" data-toggle="tab" aria-expanded="false">Questionnaire Response</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">
                                    <table class="data table no-margin">
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ $alumni->first_name . ' ' . $alumni->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <td>{{ $alumni->nim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ($alumni->gender == 'M') ? 'Male' : 'Female' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Religion</th>
                                            <td>{{ $alumni->religion }}</td>
                                        </tr>
                                        <tr>
                                            <th>Birth Place & Date</th>
                                            <td>{{ $alumni->birth_place . ', ' . $alumni->birth_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Study Program</th>
                                            <td>{{ $studyProgram[$alumni->study_program_id - 1] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Class</th>
                                            <td>{{ $alumni->class }}</td>
                                        </tr>
                                        <tr>
                                            <th>ID Number</th>
                                            <td>{{ $alumni->id_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $alumni->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $alumni->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $alumni->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab2">
                                    @if (!empty($workingExperiences[0]))
                                        <section id="cd-timeline" class="cd-container">
                                            @foreach($workingExperiences as $workingExperience)
                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img">
                                                    <div class="fa fa-briefcase timelineicon"></div>
                                                </div> <!-- cd-timeline-img -->

                                                <div class="cd-timeline-content">
                                                    <h3>{{ $workingExperience->position }}</h3>
                                                    <hr />
                                                    <h2>{{ $workingExperience->company }}</h2>
                                                    <h2><span class="fa fa-map-marker"></span> {{ $workingExperience->location }}</h2>
                                                    <span class="cd-date">{{ $workingExperience->formated_start_date . ' - ' . $workingExperience->formated_end_date }}</span>
                                                </div> <!-- cd-timeline-content -->
                                            </div> <!-- cd-timeline-block -->
                                            @endforeach
                                        </section> <!-- cd-timeline -->
                                    @else
                                        <div class="no-work-exp text-center">
                                            <h2>{{ $alumni->first_name }} doesn't have any work experience yet</h2>
                                        </div>
                                    @endif
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="questionnaire-response-content" aria-labelledby="questionnaire-response-content">
                                    @if($isFilled)
                                    <div class="row padding20">
                                        <div class="col-xs-12">
                                        @foreach($responses as $response)
                                            <div class="row paddingb-5">
                                                <div class="col-xs-12">
                                                    <label>{{ $response->question }} {!! ($response->required == 1) ? '<span class="text-danger">*Required</span>' : '' !!}</label>
                                                    @if ($response->type == 'Text')
                                                        <input type="text" class="form-control" value="{{ $response->response->response or "" }}" />
                                                    @elseif ($response->type == 'Textarea')
                                                        <textarea class="form-control" row="5px">{{ $response->response->response or "" }}</textarea>
                                                    @elseif ($response->type == 'Radio')
                                                        @foreach ($response->answers as $answer)
                                                            <div class="radio">
                                                                <label for="radio">
                                                                    <input type="radio" class="flat" name="" value="{{ $answer->id }}"
                                                                    @if (isset($response->response->response))
                                                                        {{ ($response->response->response == $answer->id) ? ' checked="checked"' : '' }}
                                                                    @endif
                                                                    /> {{ $answer->answer }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @elseif ($response->type == 'Checkbox')
                                                        <?php
                                                            if (isset($response->response->response)) {
                                                                $checkboxResponse = explode(',', $response->response->response);
                                                            } else {
                                                                $checkboxResponse = [];
                                                            }
                                                        ?>
                                                        @foreach ($response->answers as $answer)
                                                            <div class="checkbox">
                                                                <label for="checkbox">
                                                                    <input type="checkbox" class="flat" name="" value="{{ $answer->id }}" 
                                                                    @foreach($checkboxResponse as $checkboxR)
                                                                        @if ($answer->id == $checkboxR)
                                                                            {{ 'checked="checked"' }}
                                                                        @endif
                                                                    @endforeach
                                                                    /> {{ $answer->answer }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @elseif ($response->type == 'Yes or No')
                                                        <div class="col-xs-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="flat" name=""
                                                                    @if (isset($response->response->response))
                                                                        {{ ($response->response->response == 'Yes') ? 'checked="checked"' : ''}}
                                                                    @endif
                                                                    > Ya
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="flat" name=""
                                                                    @if (isset($response->response->response)){{ ($response->response->response == 'No') ? 'checked="checked"' : ''}}
                                                                    @endif
                                                                    > Tidak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                        @endforeach
                                        </div>
                                    </div>
                                    @else
                                        <div class="no-work-exp text-center">
                                            <h2>{{ $alumni->first_name }} not filled questionnaire yet</h2>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <!-- bootstrap progress js -->
    <script src="{{ asset('assets/js/progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vertical_timeline/main.js') }}"></script> <!-- Resource jQuery -->
    <!-- icheck -->
    <script src="{{ asset('assets/js/icheck/icheck.min.js') }}"></script>
    <!-- switchery -->
    <script src="{{ asset('assets/js/switchery/switchery.min.js') }}"></script>

    <script>
        jQuery(document).ready(function($){
            if(window.location.hash != "") {
                $('a[href="' + window.location.hash + '"]').click()
            }
            $('#tab_content2').click(function() {
                var timelineBlocks = $('.cd-timeline-block'),
                    offset = 0.8;

                //hide timeline blocks which are outside the viewport
                hideBlocks(timelineBlocks, offset);

                //on scolling, show/animate timeline blocks when enter the viewport
                $(window).on('scroll', function(){
                    (!window.requestAnimationFrame) 
                        ? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
                        : window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
                });

                function hideBlocks(blocks, offset) {
                    blocks.each(function(){
                        ( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
                    });
                }

                function showBlocks(blocks, offset) {
                    blocks.each(function(){
                        ( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
                    });
                }
            });
        });
    </script>
@stop
