@extends('layouts.app')

@section('title')
    {{ $title }} Lists | {{ $group }}
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
                {{ $title }} Lists
                </small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="filter row">
        <form action="{{ route('feedback.index') }}" method="GET" class="form">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="rating">Rating : </label>
                    <select name="rating" id="rating" class="form-control">
                        <option value="">-- Select Rating --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="search">Search : </label>
                    <input type="text" placeholder="Type Alumni Name or NIM" name="search" class="form-control" value="{{ Request::get('search') }}"/>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="btn-group w100">
                    @if(!empty(Request::get('rating')) || !empty(Request::get('search')))
                        <button type="submit" class="btn btn-warning w50">Submit Filter</button>
                        <a href="{{ route('feedback.index') }}" class="btn btn-danger w50">Clear Filter</a>
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
                                <th width="15%">From</th>
                                <th width="10%">Rating</th>
                                <th width="70%">Feedback</th>
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
                            </tr>
                            <?php $count++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $feedbacks->appends(Request::only('rating', 'search'))->links() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <script>
        $(document).ready(function() {
            @if(!empty(Request::get('rating')))
                $('select#rating option[value={{ Request::get('rating') }}]').attr('selected','selected');
            @endif
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop