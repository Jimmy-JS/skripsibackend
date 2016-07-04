@extends('layouts.app')

@section('title')
    {{ $title }} Lists | {{ $group }}
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
                {{ $title }} Lists
                </small>
            </h3>
        </div>
        <div class="title_right">
            @if ($isSuperAdmin == 1)
            <div class="form-group pull-right text-right">
                <a href="{{ route('questionnaire.create') }}" class="btn btn-round btn-dark"><i class="glyphicon glyphicon-plus"></i> | Add New {{ $title }}</a>
            </div>
            @endif
            <div class="form-group pull-right text-right">
                <a href="{{ route('questionnaire.flush') }}" class="btn btn-round btn-danger"><i class="glyphicon glyphicon-refresh"></i> | Flush Cache</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $title }} Lists</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="50%">Question</th>
                                <th width="15%">Type</th>
                                <th width="10%">Position</th>
                                <th width="5%">Required</th>
                                <th width="15%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; $numItems = count($questions); ?>
                            @foreach($questions as $question)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $question->question }}</td>
                                <td><span class="badge badge-success">{{ $question->type }}</span></td>
                                <td>
                                    @if ($isSuperAdmin == 1)
                                        @if ($count == 1)
                                            <i class="fa fa-fw fa-toggle-up text-muted" style="cursor:not-allowed;"></i>
                                        @else
                                            <i class="fa fa-fw fa-toggle-up rearrangePosition text-success-ori" data-question-id="{{ $question->id }}" data-type="up" style="cursor:pointer;"></i>
                                        @endif
                                        <span class="iPosition">{{ $question->position }}</span>
                                        @if ($count == $numItems)
                                            <i class="fa fa-fw fa-toggle-down text-muted" style="cursor:not-allowed;"></i>
                                        @else
                                            <i class="fa fa-fw fa-toggle-down rearrangePosition text-danger-ori" data-question-id="{{ $question->id }}" data-type="down" style="cursor:pointer;"></i>
                                        @endif
                                    @else
                                        <span class="iPosition">{{ $question->position }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($question->required == 0)
                                        <i class="fa rearrangeActive fa-times text-danger-ori" data-id="1" data-active="0"></i>
                                    @elseif ($question->required == 1)
                                        <i class="fa fa-check text-success-ori rearrangeActive" data-id="2" data-active="1"></i>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($question->type == 'Text' || $question->type == 'Textarea')
                                    @else
                                        <a href="{{ route('questionnaire.show', $question->id) }}" class="nodecor" data-toggle="modal" data-target="#view_available_answer">
                                            <i class="livicon" data-name="eye-open" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14" title="View Available Answer" data-toggle="tooltip" data-placement="top"></i>
                                        </a>
                                    @endif
                                    @if ($isSuperAdmin == 1)
                                    <a href="{{ route('questionnaire.edit', $question->id)}}" class="nodecor">
                                        <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Edit Question" data-toggle="tooltip" data-placement="top"></i>
                                    </a>
                                    <a href="{{ url('deleteConfirmation/questionnaire/') . '/' . $question->id }}" class="nodecor" data-toggle="modal" data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Delete Question" data-toggle="tooltip" data-placement="top"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <?php $count++; ?>
                            @endforeach
                            @foreach($builtInQuestions as $question)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $question->question }}</td>
                                <td><span class="badge badge-success">{{ $question->type }}</span></td>
                                <td>
                                    -
                                </td>
                                <td>
                                    @if ($question->required == 0)
                                        <i class="fa rearrangeActive fa-times text-danger-ori" data-id="1" data-active="0"></i>
                                    @elseif ($question->required == 1)
                                        <i class="fa fa-check text-success-ori rearrangeActive" data-id="2" data-active="1"></i>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($question->type == 'Text' || $question->type == 'Textarea')
                                        -
                                    @else
                                        <a href="{{ route('questionnaire.show', $question->id) }}" class="nodecor" data-toggle="modal" data-target="#view_available_answer">
                                            <i class="livicon" data-name="eye-open" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14" title="View Available Answer" data-toggle="tooltip" data-placement="top"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <?php $count++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <div class="modal fade" id="view_available_answer" tabindex="-1" role="dialog" aria-labelledby="view_available_answer" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>
    $(function () {
        $('body').on('shown.bs.modal', '.modal', function () {
            $(document).ready(function () {
                if ($("input.flat")[0]) {
                    $('input.flat').iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_flat-green'
                    });
                }
            });
        });
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

    <!-- icheck -->
    <script src="{{ asset('assets/js/icheck/icheck.min.js') }}"></script>
    <!-- switchery -->
    <script src="{{ asset('assets/js/switchery/switchery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.rearrangePosition').click(function() {
                var type = $(this).attr('data-type');
                var id = $(this).attr('data-question-id');
                $.ajax({
                    url: "{{ url('questionnaire/changePosition/' ) }}/" + type + "-" + id,
                    type: 'GET',
                    success: function(data) {
                        if (data.status == 'success') {
                            swal("Success", data.message, "success");
                            swal({
                                    title: "Success",
                                    text: data.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "Continue",
                                    closeOnConfirm: false 
                                }, function(){
                                    window.location.reload();
                            });
                        } else if (data.status == 'error') {
                            swal("Error", data.message, "error");
                        }
                    }
                });
            });
        });
    </script>
@stop