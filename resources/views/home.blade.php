@extends('layouts.app')
@section('css')
    <link href="/css/views/home.css" rel="stylesheet">
@endsection
@section('main')
    <div class="row">
        <div class="col-md-7" id="target-board">
            <?php $i = 0 ?>
            @foreach(\App\Target::orderBy('dt_update', 'DESC')->groupBy('seq')->take(10)->get() as $data )
                <a href="/rate/view/{{$data->seq}}" class="target t{{$i++}} img-circle">
                    <img src="{{$data->photo}}" />
                    <div>{{$data->nick_name}}</div>
                </a>
            @endforeach
        </div>
        <div class="col-md-7" id="search-board">
        </div>
        <script type="text/template" id="tmpl-search">
        <% _.each(data, function(v, i){%>
                <a class="target" href="/rate/view/<%- v.seq %>">
                    <img class="img-rounded" src="<%- v.photo %>" />
                    <span><%- v.nick_name %></span>
                </a>
        <%})%>
        </script>
        <div class="col-md-5 search">
            <div class="row">
                <div class="col-xs-12 txt">
                    <i class="glyphicon glyphicon-user"></i>
                    <input type="text" id="target" placeholder="name, nick name or year of birth">
                </div>
                <div class="col-xs-12 txt">
                    <i class="glyphicon glyphicon glyphicon-map-marker"></i>
                    <input type="text" id="autocomplete" placeholder="city or state" autocomplete="off">
                    <input type="hidden" id="state_cd">
                </div>
                <div class="col-xs-12">
                    <a id="search" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-search"></i> Find Person</a>
                    <a id="rate" href="/rate/target/-1" class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-thumbs-up"></i> Rate Someone</a>
                </div>
                <div class="col-xs-12 featured">
                    <select class="no-radius">
                        <option>Looking for someone in particular?</option>
                        @foreach($ratetype as $data )
                            <option value="{{$data->rate_type}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                    <div class="cont row-fluid" id="list-featured"></div>
                    <script id="tmpl-featured-btn" type="text/template">
                        <a class="type" data-cd="<%- item_cd %>">
                            <%- item_nm %> <i class="glyphicon glyphicon-remove-sign"></i>
                        </a>
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if(!Auth::guest())
    <div class="row" style="margin-top:20px">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Who might rate me?</div>
                <div class="panel-body rate">
                    @foreach($rateme as $data)
                        <a href="/rate/view/{{ $data->target_seq }}">
                            <img src="{{ $data->photo }}" />
                            <span>{{ $data->nick_name }}</span>
                            <p>{{ $data->name }} / score: <b>{{ $data->rate_score }}</b></p>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Person who I rated.</div>
                <div class="panel-body rate">
                    @foreach($rated as $data)
                    <a href="/rate/view/{{ $data->target_seq }}">
                        <img src="{{ $data->photo }}" />
                        <span>{{ $data->nick_name }}</span>
                        <p>{{ $data->name }} / score: <b>{{ $data->rate_score }}</b></p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body search-all">
                    <div class="input-group">
                        <input type="text" class="form-control" id="val-all" />
                        <div class="input-group-btn">
                            <a class="btn btn-primary" id="search-all">Search</a>
                        </div>
                    </div>
                    <div id="result-all" class="rate">
                        <p style="font-size:100px; font-weight:bolder; color:#ccc; text-align: center">WWTL</p>
                        <p style="color:#bbb; text-align: center">Search all!!</p>
                    </div>
                    <script type="text/template" id="tmpl-result-all">
                        <hr />
                        <% if(data[0].length > 0 ){%>
                        <b>Target</b>
                        <% _.each(data[0], function(v, i){%>
                        <a href="/rate/view/<%- v.seq %>">
                            <img src="<%- v.photo %>" />
                            <span><%- v.nick_name %></span>
                            <p>
                                <%-v.name %>
                            </p>
                        </a>
                        <%})%>
                        <hr />
                        <%} if(data[1].length > 0 ){%>
                        <b>Target's Job</b>
                        <% _.each(data[1], function(v, i){%>
                        <a href="/rate/view/<%- v.seq %>">
                            <img src="<%- v.photo %>" />
                            <span><%- v.nick_name %></span>
                            <p>
                                Job: <%-v.job %>
                            </p>
                        </a>
                        <%})%>
                        <hr />
                        <%} if(data[2].length > 0){%>
                        <b>Creator</b>
                        <% _.each(data[2], function(v, i){%>
                        <a>
                            <img src="<%- v.photo %>" />
                            <span><%- v.nick_name %></span>
                        </a>
                        <%})%>
                        <hr />
                        <%} if(data[3].length > 0){%>
                        <b>Creator</b>
                        <% _.each(data[3], function(v, i){%>
                        <a href="/rate/view/<%- v.seq %>">
                            <img src="<%- v.photo %>" />
                            <span><%- v.nick_name %></span>
                            <p>
                                Job: <%-v.job %>
                            </p>
                        </a>
                        <%})%>
                        <hr />
                        <%} if(data[4].length > 0){%>
                        <b>Reply Comment</b>
                        <% _.each(data[4], function(v, i){%>
                        <a href="/rate/view/<%- v.seq %>">
                            <img src="<%- v.photo %>" />
                            <span><%- v.nick_name %></span>
                            <p>
                                <%- v.comment.substr(0, 80) %>
                                <%- v.comment.length > 80 ? '...': ''%>
                            </p>
                        </a>
                        <%})}%>
                    </script>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Find someone.</div>
                <div class="panel-body search-detail">
                    <div class="form-inline text-right condition">
                        <select class="form-control" id="sel-condition">
                            <option val="c-name">Name</option>
                            <option val="c-featured">Rate featured</option>
                            <option val="c-job">Job</option>
                            <option val="c-birth">Year of Birth</option>
                        </select>
                        <input type="text" class="form-control val-condition c-name" />
                        <input type="text" class="form-control val-condition c-job" />
                        <select class="form-control val-condition c-featured">
                            @foreach($ratetype as $data )
                                <option value="{{$data->rate_type}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                        <select class="form-control val-condition c-birth">
                            @for($i=date('Y')+1; $i--; $i>1700)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-default btn-sm">Add condition</a>
                        <a class="btn btn-default btn-sm">Remove all</a>
                        <a class="btn btn-default btn-sm" id="search-detail">Search</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
    <script src="/scripts/views/home.js"></script>
@endsection