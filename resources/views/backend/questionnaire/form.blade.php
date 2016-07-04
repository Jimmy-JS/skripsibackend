@extends('layouts.app')

@section('title')
    {{ $title }} | {{ $group }}
@stop

@section('header_styles')
    <link href="{{ asset('assets/css/icheck/flat/green.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
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
                    @if(isset($question))
                    {!! Form::open(['route' => ['questionnaire.update', $question->id], 'id' => 'form', 'method' => 'put', 'class' => 'form-horizontal form-label-left']) !!}
                    @else
                    {!! Form::open(['url' => 'questionnaire', 'id' => 'form', 'method' => 'post', 'class' => 'form-horizontal form-label-left']) !!}
                    @endif
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12" for="question">Question <span class="required">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <!-- <input type="textarea" name="question" required="required" class="form-control col-md-7 col-xs-12"> -->
                                <textarea name="question" id="iQuestion" required="required" class="form-control col-md-7 col-xs-12" rows="3" placeholder="Type your question here">{{ (isset($question)) ? $question->question : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12" for="type">Type <span class="required">*</span>
                            </label>
                            <div class="col-sm-6 col-xs-12">
                                <select name="type" class="form-control" id="iType">
                                    <option value="Text"{{ (isset($question) && $question->type == 'Text') ? ' selected="selected"' : ''}}>Text</option>
                                    <option value="Textarea"{{ (isset($question) && $question->type == 'Textarea') ? ' selected="selected"' : ''}}>Textarea</option>
                                    <option value="Checkbox"{{ (isset($question) && $question->type == 'Checkbox') ? ' selected="selected"' : ''}}>Checkbox</option>
                                    <option value="Radio"{{ (isset($question) && $question->type == 'Radio') ? ' selected="selected"' : ''}}>Radio</option>
                                    <option value="Yes or No"{{ (isset($question) && $question->type == 'Yes or No') ? ' selected="selected"' : ''}}>Yes or No</option>
                                </select>
                            </div>
                        </div>
                        @if(isset($question) && isset($answers))
                        <div class="form-group" id='iAnswerBox'>
                            <hr />
                            <label class="control-label col-sm-3 col-xs-12" for="type">Available Anwers <span class="required">*</span>
                            </label>
                            <div class="col-sm-5 col-xs-8">
                                <div class="form-group">
                                    <input type="text" name="answer[]" required='required' class="form-control col-xs-12 iAnswerInput" placeholder="Type Available Answer Here" value="{{ $answers[0]->answer }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="answer[]" required='required' class="form-control col-xs-12 iAnswerInput" placeholder="Type Available Answer Here" value="{{ $answers[1]->answer }}">
                                </div>
                            </div>
                            <div class="col-xs-4 text-left">
                                <a class="btn btn-round btn-dark" id="iAnswerAdd"><i class="glyphicon glyphicon-plus"></i> Add More</a>
                            </div>
                            <div id="iAnswerContainer">
                                <div id="iAnswerTemplate" class="iTemplate">
                                    <div class="col-md-offset-3 col-md-5 col-xs-8">
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control iAnswerTemplateInput" placeholder="Type Available Answer Here">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 text-left">
                                        <a class="btn btn-round btn-danger iAnswerRemove"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                                    </div>
                                </div>
                                @if(count($answers) > 2)
                                    @for($i = 2; $i < count($answers); $i++)
                                        <div class="">
                                            <div class="col-md-offset-3 col-md-5 col-xs-8">
                                                <div class="form-group">
                                                    <input type="text" name="answer[]" class="form-control iAnswerInput" required="required" placeholder="Type Available Answer Here" value="{{ $answers[$i]->answer }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-4 text-left">
                                                <a class="btn btn-round btn-danger iAnswerRemove"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="form-group iTemplate" id='iAnswerBox'>
                            <hr />
                            <label class="control-label col-sm-3 col-xs-12" for="type">Available Anwers <span class="required">*</span>
                            </label>
                            <div class="col-sm-5 col-xs-8">
                                <div class="form-group">
                                    <input type="text" name="" class="form-control col-xs-12 iAnswerInput" placeholder="Type Available Answer Here">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="" class="form-control col-xs-12 iAnswerInput" placeholder="Type Available Answer Here">
                                </div>
                            </div>
                            <div class="col-xs-4 text-left">
                                <a class="btn btn-round btn-dark" id="iAnswerAdd"><i class="glyphicon glyphicon-plus"></i> Add More</a>
                            </div>
                            <div id="iAnswerContainer">
                                <div id="iAnswerTemplate" class="iTemplate">
                                    <div class="col-md-offset-3 col-md-5 col-xs-8">
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control iAnswerTemplateInput" placeholder="Type Available Answer Here">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 text-left">
                                        <a class="btn btn-round btn-danger iAnswerRemove"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-offset-3 col-xs-9">
                                <input type="checkbox" class="flat" name="required" value="1"{{ (isset($question) && $question->required == 1) ? ' checked="checked"' : ''}} /> Required Question
                            </div>
                        </div>
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
    <!-- icheck -->
    <script src="{{ asset('assets/js/icheck/icheck.min.js') }}"></script>
    <!-- switchery -->
    <script src="{{ asset('assets/js/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#iType').change(function() {
                var type = $(this).val();
                if (type == 'Radio' || type == 'Checkbox') {
                    $('#iAnswerBox').removeClass('iTemplate');
                    $('.iAnswerInput').attr('name', 'answer[]').attr('required', 'required');
                } else {
                    $('#iAnswerBox').addClass('iTemplate');
                    $('.iAnswerInput').attr('name', '').removeAttr('required');
                }
            });

            $('#iAnswerAdd').click(function() {
                var parent = $('#iAnswerContainer');
                var template = $('#iAnswerTemplate');
                var clone = template.clone().removeClass('iTemplate').removeAttr('id').addClass('iAnswerList');
                $('.iAnswerTemplateInput', clone).removeClass('iAnswerTemplateInput').addClass('iAnswerInput').attr('name', 'answer[]').attr('required', 'required');
                parent.append(clone);
            });
            $('#iAnswerContainer').on('click', '.iAnswerRemove', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
@stop