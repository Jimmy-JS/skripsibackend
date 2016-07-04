@extends('layouts.app')

@section('title')
    New Received {{ $title }}s | {{ $group }}
@stop

@section('header_styles')
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
            <h3>
                {{ $group }}
                <small>
                New Received {{ $title }}s
                </small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Received {{ $title }}s</h2>
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
                                <th width="15%">From</th>
                                <th width="10%">Rating</th>
                                <th width="60%">Feedback</th>
                                <th width="10%">Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $startNumber + $count }}</td>
                                <td>
                                    <u><a href="{{ route('alumni.show', $feedback->user->id) }}" title="Click to View Alumni Profile" data-toggle="tooltip" data-placement="top">{{ $feedback->user->first_name }} {{ substr($feedback->user->last_name, 0, 1) }}. <br />({{ $feedback->user->nim }})</a></u>
                                </td>
                                <td>
                                    @for ($i = 1; $i <= $feedback->rating; $i++) 
                                        <span style = "color:gold;" class="glyphicon glyphicon-star"></span>
                                    @endfor
                                    <?php $norating = 5 - $feedback->rating; ?>
                                    @if($norating > 0)
                                        @for ($i = 1; $i <= $norating; $i++)
                                        <span style = "color:silver;" class="glyphicon glyphicon-star"></span>
                                        @endfor
                                    @endif
                                </td>
                                <td>{{ $feedback->feedback }}</td>
                                <td>{{ $feedback->created_at->diffForHumans() }}</td>
                            </tr>
                            <?php $count++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $feedbacks->links() !!}
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