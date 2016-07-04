@extends('layouts.app')

@section('title')
    Alumni | Alumni List
@stop

@section('header_styles')
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
            <h3>
                Alumni
                <small>
                Alumni List
                </small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="filter row">
        <form action="{{ route('alumni.index') }}" method="GET" class="form">
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="studyProgram">Study Program : </label>
                    <select name="studyProgram" id="studyProgram" class="form-control">
                        <option value="">-- Select Study Program --</option>
                        <option value="1">Teknik Informatika</option>
                        <option value="2">Akuntansi</option>
                        <option value="3">Kedokteran</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="class">Class : </label>
                    <select name="class" id="class" class="form-control">
                        <option value="">-- Select Class Year --</option>
                        @foreach($classYears as $classYear)
                            <option value="{{ $classYear->class }}">{{ $classYear->class }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="search">Search : </label>
                    <input type="text" placeholder="Type Alumni Name or NIM" name="search" class="form-control" value="{{ Request::get('search') }}"/>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="btn-group w100">
                    @if(!empty(Request::get('studyProgram')) || !empty(Request::get('class')) || !empty(Request::get('search')))
                        <button type="submit" class="btn btn-warning w50">Submit Filter</button>
                        <a href="{{ route('alumni.index') }}" class="btn btn-danger w50">Clear Filter</a>
                    @else
                        <button type="submit" class="btn btn-warning w100">Submit Filter</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    @foreach($alumni as $data)
                    <div class="col-md-4 col-sm-4 col-xs-12 animated zoomInLeft">
                        <div class="well profile_view">
                            <div class="col-sm-12">
                                <h4 class="brief"><i>{{ $studyProgram[$data->study_program_id - 1] }}</i></h4>
                                <div class="left col-xs-7">
                                    <h2><u><a href="{{ route('alumni.show', $data->id) }}" title="Click to View Alumni Profile" data-toggle="tooltip" data-placement="top">{{ $data->first_name }} {{ $data->last_name }}</a></u></h2>
                                    <p><strong>NIM: </strong> {{ $data->nim }}</p>
                                    <p><strong>Class: </strong> {{ $data->class }}</p>
                                </div>
                                <div class="right col-xs-5 text-center">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="" class="img-circle img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-12 bottom">
                                <div class="col-xs-6 emphasis text-left">
                                    <a href="{{ route('alumni.show', $data->id) }}#questionnaire-response-content" class="btn btn-warning btn-xs"> <i class="fa fa-user">
                                    </i> View Reponse </a>
                                </div>
                                <div class="col-xs-6 emphasis text-right">
                                    <a href="{{ route('alumni.show', $data->id) }}" class="btn btn-primary btn-xs"> <i class="fa fa-user">
                                    </i> View Alumni Profile </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                    {!! $alumni->appends(Request::only('studyProgram', 'class', 'search'))->links() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <script>
        $(document).ready(function() {
            @if(!empty(Request::get('studyProgram')))
                $('select#studyProgram option[value={{ Request::get('studyProgram') }}]').attr('selected','selected');
            @endif
            @if(!empty(Request::get('class')))
                $('select#class option[value={{ Request::get('class') }}]').attr('selected','selected');
            @endif
            $('[data-toggle="tooltip"]').tooltip();
            $('ul.pagination li a').click(function(e) {
                $('.zoomInLeft').removeClass('zoomInLeft').addClass('zoomOutLeft');
                $('.zoomOutRight').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    
                });
            });
        });
    </script>
@stop