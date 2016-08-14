@extends('layouts.app')

@section('css')
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/rate.view.css" rel="stylesheet">
@endsection
@section('content')
    <input type="hidden" value="{{ $target->seq }}" id="target" />
    <div class="panel panel-default">
        <div class="panel-heading">
            All about this person <a class="btn btn-rate btn-sm" href="/rate/target/-1"><i class="glyphicon glyphicon-thumbs-up"></i> Rate Someone Else</a>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 text-center photo">
                    <img src="{{ $target->photo }}" />
                </div>
                <div class="col-md-6 target-info">
                    <table>
                        <tr>
                            <td colspan="2" class="name">
                                {{ $target->nick_name  }} ({{ $target->first_name }} {{ $target->last_name }})
                                @if(Auth::user())
                                @if($target->user_seq == Auth::user()->seq)
                                <a id="edit-target" href="/rate/target/{{$target->seq}}"><i class="glyphicon glyphicon-edit"></i></a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th><td>{{ substr($target->birth, 0, 10) }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th><td>{{$target->gender==0?'Male':'Female'}}</td>
                        </tr>
                        <tr>
                            <th>Job</th><td>{{$target->job}}</td>
                        </tr>
                        <tr>
                            <th>Country</th><td>{{$target->locale}}</td>
                        </tr>
                        <tr>
                            <th>State</th><td>{{$target->locale}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3 text-center target-score">
                    @if($score != null && $score != '')
                    {{ substr($score, 0,4) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Anything else to say about this person?
        </div>
        <div class="panel-body" id="reply">
            <div id="list-reply"></div>
            <?php
                $user = '';
                if(!Auth::guest()){
                    $user = \Auth::user()->seq;
                }
            ?>
            <script type="text/template" id="tmpl-reply">
            <% _.each(data, function(v, i){%>
            <div class="reply-item">
                <p class="creator">
                    <a><%- v.nick_name %></a> <img src="<%- v.photo %>" /> |
                    <span><%- v.update_dt %></span>
                    <% if(v.seq ==  '{{ $user }}'){ %>
                    <a class="update" data-id="<%- v.id %>"><i class="glyphicon glyphicon-edit"></i></a><a class="delete" data-id="<%- v.id %>"><i class="glyphicon glyphicon-trash"></i></a>
                    <%}%>
                </p>
                <p class="comment"><%- v.comment %></p>
            </div>
            <hr />
            <%})%>
            </script>
            @if(Auth::guest())
                <p class="text-center">
                    After Login, You can use this service. <a href="/login">Login</a>
                </p>
            @else
                <div class="input-group">
                    <textarea class="form-control" id="reply-comment"></textarea>
                    <div class="input-group-btn">
                        <a class="btn btn-primary" id="reply-submit">Submit</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Featured :
            <select id="sel-type">
                @if(count($type) > 0)
                    <option value="-1">All</option>
                    @foreach($type as $data )
                        <option value="{{$data->rate_type}}">{{$data->name}}</option>
                    @endforeach
                @else
                    <option value="-1">No rate</option>
                @endif
            </select>
            <a href="/rate/rate/{{$target->seq}}" class="btn btn-success btn-sm">Rate '{{$target->nick_name}}'</a>
        </div>
        <div class="panel-body text-center">
            @if(count($main) > 0)
                <div class="row-fluid">
                    <div class="col-md-7 text-left" id="view-rate">
                        <div class="text-right">
                            <a title="All rating score" class="btn btn-default btn-sm" id="chart-all"><i class="glyphicon glyphicon-align-left"></i></a>
                            <select id="sel-sort">
                                <option value="hl">High to Low Score</option>
                                <option value="lh">Low to High Score</option>
                            </select>
                        </div>
                        <div id="chart"><canvas id="myChart" width="50" height="50"></canvas></div>
                    </div>
                    <div class="col-md-5 text-left" id="list-user">
                        @foreach($main as $data)
                            <a class="rate"
                               data-target="{{$data->target_seq}}"
                               data-rate="{{$data->rate_id}}"
                               data-type="{{$data->rate_type}}">
                                <img src="{{ $data->photo }}" />{{ $data->nick_name }} <span>rate {{$data->name}}</span>
                            </a>
                            <div class="info">
                                <span id="score">{{ substr($data->rate_score, 0, 4)  }}</span>
                                <span id="year"><b>Year known :</b> <span>{{ $data->knew_year }}</span></span>
                                <p class="text-right" id="dt">Update : <span>{{ substr($data->dt_update, 0, 10)}}</span></p>
                                <div id="comment">
                                    <b>Comment ></b>
                                    <span class="text-left">{{ $data->comment }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="/rate/rate/{{$target->seq}}">Please rate <b>{{ $target->nick_name }}</b></a>
            @endif
        </div>
    </div>
@endsection


@section('plugin')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
@endsection
@section('scripts')
    <script src="/scripts/views/rate.view.js"></script>
@endsection
