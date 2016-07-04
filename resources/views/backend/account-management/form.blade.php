@extends('layouts.app')

@section('title')
    {{ $title }} | {{ $group }}
@stop

@section('header_styles')
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="">
            <h3>
                {{ $group }}
                <small>
                {{ $title }}
                </small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $title }} Form</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    {!! Form::open(['url' => 'account', 'id' => 'form', 'method' => 'post', 'class' => 'form-horizontal form-label-left']) !!}
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">First Name <span class="required">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Last Name <span class="required">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="email" required="required" value="{{ old('email') }}">
                                @if($errors->first('email')){!! '<p class="text-danger">'.$errors->first('email').'</p>' !!}@endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Password <span class="required">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="password" class="form-control" name="password" required="required">
                                @if($errors->first('password')){!! '<p class="text-danger">'.$errors->first('password').'</p>' !!}@endif
                            </div>
                        </div>
                        <input type="hidden" name="isAdmin" value="1">
                        <input type="hidden" name="isSuperAdmin" value="{{ ($type == 'superAdmin') ? '1' : '0'}}">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 text-center">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
@stop