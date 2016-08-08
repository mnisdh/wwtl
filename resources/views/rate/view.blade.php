@extends('layouts.app')

@section('css')
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/rate.view.css" rel="stylesheet">
@endsection
@section('content')
    <input type="hidden" value="{{ $target->seq }}" id="target" />
    <div class="panel panel-default">
        <div class="panel-heading">
            All about this person
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
                    {{ substr($score, 0,4) }}
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
                    <% if(v.seq ==  {{ $user }}){ %>
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
                        <div id="info">
                            <span id="score"></span>
                            <span id="year"><b>Knew year :</b> <span></span></span>
                            <p class="text-right" id="dt">Update : <span></span></p>
                            <div id="comment">
                                <b>Comment ></b>
                                <span class="text-left"></span>
                            </div>
                        </div>
                        <div id="recent">
                            Recently Top 5
                        </div>
                        <div id="chart">chart</div>
                    </div>
                    <div class="col-md-5 text-left" id="list-user">
                        @foreach($main as $data)
                            <a class="rate"
                               data-type="{{$data->rate_type}}"
                               data-score="{{ substr($data->rate_score, 0, 4)  }}"
                               data-year="{{ $data->knew_year }}"
                               data-dt="2016/05/01"
                               data-comment="{{ $data->comment }}">
                                <img src="{{ $data->photo }}" />{{ $data->nick_name }}
                            </a>
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
@endsection
@section('scripts')
    <script src="/scripts/views/rate.view.js"></script>

@endsection
