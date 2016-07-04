@extends('layouts.app')

@section('title')
    Report | Reporting
@stop

@section('header_styles')
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
            <h3>
                {{ (empty(Request::get('studyProgram')) && empty(Request::get('class'))) ? 'All Reporting' : 'Reporting By:'}}
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="filter row">
        <form action="{{ route('reporting.index') }}" method="GET" class="form">
            <div class="col-sm-6 col-xs-12">
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
            <div class="col-sm-6 col-xs-12">
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
            <div class="col-xs-12">
                <div class="btn-group w100">
                    @if(!empty(Request::get('studyProgram')) || !empty(Request::get('class')))
                        <button type="submit" class="btn btn-warning w50">Submit Filter</button>
                        <a href="{{ route('reporting.index') }}" class="btn btn-danger w50">Clear Filter</a>
                    @else
                        <button type="submit" class="btn btn-warning w100">Submit Filter</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Filled / Unfilled Questionnaire Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="filledQuestionnaire" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Overall Rating</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="overallRating" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Alumni Work Location</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="mapChart" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12" id="build1">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Question Feedback Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="buildInQuestion" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Question Feedback Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="buildInQuestion2" style="height:350px;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_styles')
    <!-- echart -->
    <script src="{{ asset('assets/js/echart/echarts-all.js') }}"></script>
    <script src="{{ asset('assets/js/echart/green.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if(!empty(Request::get('studyProgram')))
                $('select#studyProgram option[value={{ Request::get('studyProgram') }}]').attr('selected','selected');
            @endif
            @if(!empty(Request::get('class')))
                $('select#class option[value={{ Request::get('class') }}]').attr('selected','selected');
            @endif
        });
        /* Filled Questionnaire Start */
        var myChart = echarts.init(document.getElementById('filledQuestionnaire'), theme);
        myChart.setOption({
            tooltip: {
                trigger: 'item',
                formatter: "{b} ({d}%)"
            },
            toolbox: {
                orient: 'vertical',
                x: 'right',
                show: true,
                feature: {
                    saveAsImage: {
                        name: 'Filled / Unfilled Questionnaire Report',
                        title: 'Save as PNG',
                        show: true,
                        lang : ['Click to Save']
                    }
                }
            },
            calculable: true,
            series: [{
                name: 'Total',
                type: 'pie',
                radius: [45, 100],
                center: ['50%', '48%'], //left,top
                data: [{
                    value: {{ $filledQuestionnaire }},
                    name: 'Filled Questionnaire : {{ $filledQuestionnaire }}'
                }, {
                    value: {{ $unfilledQuestionnaire }},
                    name: 'Unfilled Questionnaire : {{ $unfilledQuestionnaire }}'
                }]
            }],
            title: {
                show: true,
                text: 'Filled / Unfilled Questionnaire Graph',
                textAlign: 'center',
                x: 'center'
            }
        });
        /* Filled Questionnaire END */

        /* Overall Rating Start */
        var myChart = echarts.init(document.getElementById('overallRating'), theme);
        myChart.setOption({
            tooltip: {
                formatter: "{a} <br/>{b} : {c}"
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        name: 'Filled / Unfilled Questionnaire Report',
                        title: 'Save as PNG',
                        show: true,
                        lang : ['Click to Save']
                    }
                }
            },
            series: [{
                name: 'Average Rating',
                type: 'gauge',
                center: ['50%', '50%'],
                radius: [0, '75%'],
                startAngle: 140,
                endAngle: -140,
                min: 0,
                max: 5,
                precision: 0,
                splitNumber: 10,
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: [
                            [0.2, 'lightgreen'],
                            [0.5, 'skyblue'],
                            [0.8, 'orange'],
                            [1, '#ff4500']
                        ],
                        width: 30
                    }
                },
                axisTick: {
                    show: true,
                    splitNumber: 5,
                    length: 11  ,
                    lineStyle: {
                        color: '#eee',
                        width: 1,
                        type: 'solid'
                    }
                },
                axisLabel: {
                    show: false,
                    textStyle: {
                        color: '#333'
                    }
                },
                splitLine: {
                    show: true,
                    length: 30,
                    lineStyle: {
                        color: '#eee',
                        width: 2,
                        type: 'solid'
                    }
                },
                pointer: {
                    length: '80%',
                    width: 8,
                    color: 'auto'
                },
                title: {
                    show: true,
                    offsetCenter: ['-65%', -10],
                    textStyle: {
                        color: '#333',
                        fontSize: 15
                    }
                },
                detail: {
                    show: true,
                    backgroundColor: 'rgba(0,0,0,0)',
                    borderWidth: 0,
                    borderColor: '#ccc',
                    width: 100,
                    height: 30,
                    offsetCenter: ['-65%', 0],
                    formatter: '{value}',
                    textStyle: {
                        color: 'auto',
                        fontSize: 30
                    }
                },
                data: [{
                    value: {{ $averageRating }},
                    name: 'Average Rating'
                }]
            }]
        });
        /* Overall Rating END */

        /* Built in Question 1 Start */
        var myChart = echarts.init(document.getElementById('buildInQuestion'), theme);
        myChart.setOption({
            tooltip: {
                trigger: 'item',
                formatter: "{b} ({d}%)"
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        name: 'Report',
                        title: 'Save as PNG',
                        show: true,
                        lang : ['Click to Save']
                    }
                }
            },
            calculable: true,
            series: [{
                type: 'pie',
                radius: '100',
                center: ['50%', '60%'], //left,top
                data: [
                @foreach ($firstBuildInQuestionResponses as $response)
                {!!'{
                    name: "' . $response->answer->answer . ' : ' . $response->total . '",
                    value: ' . $response->total . '
                },' !!}
                @endforeach
                ]
            }],
            title: {
                show: true,
                text: 'Apakah kegiatan Anda setelah lulus sekarang ini ?',
                textAlign: 'center',
                subtext: 'Total Respondent : {{ $filledQuestionnaire }}',
                x: 'center',
                textStyle: {
                    fontSize: 16,
                }
            }
        });
        /* Built in Question 1 END */

        /* Built in Question 2 Start */
        var myChart = echarts.init(document.getElementById('buildInQuestion2'), theme);
        myChart.setOption({
            tooltip: {
                trigger: 'item',
                formatter: "{b} ({d}%)"
            },
            toolbox: {
                orient: 'vertical',
                show: true,
                feature: {
                    saveAsImage: {
                        name: 'Report',
                        title: 'Save as PNG',
                        show: true,
                        lang : ['Click to Save']
                    }
                }
            },
            calculable: true,
            series: [{
                type: 'pie',
                radius: [30, 100],
                roseType: 'radius',
                center: ['50%', '60%'],
                sort: 'ascending',
                data: [
                @foreach ($secondBuildInQuestionResponses as $response)
                {!!'{
                    name: "' . $response->answer->answer . ' : ' . $response->total . '",
                    value: ' . $response->total . '
                },' !!}
                @endforeach
                ]
            }],
            title: {
                show: true,
                text: 'Menurut Anda, bagaimana relevansi pekerjaan \nAnda atau pekerjaan yang Anda harapkan dengan \nBidang Ilmu yang saudara tempuh saat kuliah?',
                subtext: 'Total Respondent : {{ $filledQuestionnaire }}',
                textAlign: 'center',
                x: 'center',
                textStyle: {
                    fontSize: 16,
                }
            }
        });
        /* Built in Question 2 END */

        /* Map Start */
        var myChart = echarts.init(document.getElementById('mapChart'), theme);
        myChart.setOption({
            title: {
                text: 'Alumni Work Location Graph',
                x: 'center',
                y: 'top'
            },
            tooltip: {
                trigger: 'item'
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        name: 'Filled / Unfilled Questionnaire Report',
                        title: 'Save as PNG',
                        show: true,
                        lang : ['Click to Save']
                    }
                }
            },
            dataRange: {
                min: 0,
                max: {{ $max }},
                text: ['High', 'Low'],
                realtime: false,
                calculable: true,
                color: ['#087E65', '#26B99A', '#CBEAE3']
            },
            series: [{
                name: 'Total Alumni that work on',
                type: 'map',
                mapType: 'world',
                roam: false,
                mapLocation: {
                    y: 60
                },
                itemStyle: {
                    emphasis: {
                        label: {
                            show: true
                        }
                    }
                },
                data: [
                @foreach ($countries as $country)
                {!!'{
                    name: "' . $country->country . '",
                    value: ' . $country->count . '
                },' !!}
                @endforeach
                ]
            }]
        });
        /* Map END */
    </script>
@stop