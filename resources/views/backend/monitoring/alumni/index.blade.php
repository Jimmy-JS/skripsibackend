@extends('layouts.app')

@section('title')
    Recently Registered Alumni | Monitoring
@stop

@section('header_styles')
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
            <h3>
                Monitoring
                <small>
                Recently Registered Alumni
                </small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Recently Registered Alumni</h2>
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
                                <th>NIM</th>
                                <th>Name</th>
                                <th>Registered at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            @foreach($alumni as $data)
                            <tr>
                                <td>{{ $startNumber + $count }}</td>
                                <td>{{ $data->nim }}</td>
                                <td>
                                    <u><a href="{{ route('alumni.show', $data->id) }}" title="Click to View Alumni Profile" data-toggle="tooltip" data-placement="top">{{ $data->first_name }} {{ $data->last_name }}</a></u>
                                </td>
                                <td>{{ $data->human_created_at }} ({{ $data->created_at->format('d F Y h:i:s') }})</td>
                                <td>
                                    <a href="{{ route('alumni.show', $data->id) }}" class="nodecor">
                                        <i class="livicon" data-name="eye-open" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14" title="View Alumni Profile" data-toggle="tooltip" data-placement="top"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $count++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $alumni->links() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop