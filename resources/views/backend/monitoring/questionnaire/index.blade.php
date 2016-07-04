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
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $title }}</h2>
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
                                <th>#</th>
                                <th>Respondent</th>
                                <th>Nim</th>
                                <th>Submitted Date</th>
                                <th>View Reponse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; $numItems = count($respondents); ?>
                            @foreach($respondents as $respondent)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>
                                    <u><a href="{{ route('alumni.show', $respondent->user->id) }}#questionnaire-response-content" title="" data-toggle="tooltip" data-placement="top" data-original-title="Click to View Alumni Response">
                                        {{ $respondent->user->first_name }} {{ $respondent->user->last_name}}
                                    </a></u>
                                </td>
                                <td>{{ $respondent->user->nim }}</td>
                                <td>{{ $respondent->created_at->diffForHumans() . ' (' . $respondent->created_at->format('d F Y') . ')' }}</td>
                                <td class="">
                                    <a href="{{ route('monitoring.questionnaire.show', $respondent->user->id) }}" class="nodecor" data-toggle="modal" data-target="#view_response">
                                        <i class="livicon" data-name="eye-open" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14" title="View Response" data-toggle="tooltip" data-placement="top"></i>
                                    </a>
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
    <div class="modal fade" id="view_response" tabindex="-1" role="dialog" aria-labelledby="view_response" aria-hidden="true">
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
@stop