@extends('layouts.app')
@section('css')
    <link href="/css/views/home.css" rel="stylesheet">
@endsection
@section('main')
    <div id="map"></div>
@endsection
@section('content')
    <div class="row"  id="search">
        <div class="col-sm-12">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="sel-search-typ" data-val="all">All</span> <span class="caret"></span></button>
                    <ul id="search-typ" class="dropdown-menu">
                        <li data-val="all"><a>All</a></li>
                        <li data-val="name"><a>Name</a></li>
                        <li data-val="job"><a>Job</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($ratetype as $data )
                            <li data-val="{{$data->rate_type}}"><a>{{$data->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <input type="text" id="target" class="form-control" placeholder="Search for...">

                <div class="input-group-btn">
                    <a class="btn btn-default" id="btn-search"><i class="glyphicon glyphicon-search"></i></a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-globe"></i><span id="sel-country" data-val=""></span></button>
                    <ul class="dropdown-menu" id="country">
                        <li data-val=""><a>Worldwide</a></li>
                        @foreach($country as $data)
                            <li data-val="{{$data->country_code}}"><a>{{$data->country_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="res-type">
                <a class="on" data-val="target">Person who has been rated</a>
                <a data-val="reply">All comment about the person</a>
                <a data-val="writer">Who first rated the person</a>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="search-result">
                <ul id="search-board"></ul>
            </div>
        </div>
    </div>
    <script type="text/template" id="tmpl-search">
        <% _.each(data, function(tg){ %>
        <li>
        <% var seq = 0, tot = 0; var nm = '', comment = '', writer = '';
            _.each(tg, function(v, i){ if(seq != v.seq){
            seq = v.seq; comment = v.comment; writer = v.u_nick %>
            <img src="<%- v.photo %>">
            <p class="target_nm">
                <a class="target" href="/rate/view/<%- v.seq %>"><%- v.nick_name %></a>
            </p>
        <%}  tot += v.score; if(nm.indexOf(v.name) < 0){ nm += v.name + ', '; } })%>
        <p class="featured">
            <% nm = nm.substr(0, nm.length -2); if(nm != null && nm != '' && nm != 'null'){
            if(res == 'target'){%>
            <span><%- nm %></span>
            <%}else if(res=='reply'){%>
            <b><%- comment %> </b> <span> by <%- writer %></span>
            <%}else {%>
            <span> by <%- writer %></span>
            <%}}else{%>
            <span>No person rated. </span><a class="btn btn-rate btn-sm" href="/rate/rate/<%- tg[0].seq %>"><i class="glyphicon glyphicon-thumbs-up"></i> Rate</a>
            <%}%>
        </p>
        <% if(nm != null && nm != '' && nm != 'null'){ %>
        <p class="score"><%- res != 'writer' ? (tot / tg.length).toFixed(2) : '' %></p>
        <%}%>
        <div class="clear"></div>
        </li>
        <%})%>
    </script>
    {{--@if(!Auth::guest())--}}
        {{--<div class="row" style="margin-top:20px">--}}
            {{--<div class="col-md-4">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Who rated me?</div>--}}
                    {{--<div class="panel-body rate">--}}
                        {{--@foreach($rateme as $data)--}}
                            {{--<a href="/rate/view/{{ $data->target_seq }}">--}}
                                {{--<img src="{{ $data->photo }}" />--}}
                                {{--<span>{{ $data->nick_name }}</span>--}}
                                {{--<p>{{ $data->name }} / score: <b>{{ substr($data->rate_score, 0, 4) }}</b></p>--}}
                            {{--</a>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Person who I rated.</div>--}}
                    {{--<div class="panel-body rate">--}}
                        {{--@foreach($rated as $data)--}}
                            {{--<a href="/rate/view/{{ $data->target_seq }}">--}}
                                {{--<img src="{{ $data->photo }}" />--}}
                                {{--<span>{{ $data->nick_name }}</span>--}}
                                {{--<p>{{ $data->name }} / score: <b>{{ substr($data->rate_score, 0, 4)}}</b></p>--}}
                            {{--</a>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-8">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-body search-all">--}}
                        {{--<div class="input-group">--}}
                            {{--<input type="text" class="form-control" id="val-all" />--}}
                            {{--<div class="input-group-btn">--}}
                                {{--<a class="btn btn-primary" id="search-all">Search</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div id="result-all" class="rate">--}}
                            {{--<p style="font-size:100px; font-weight:bolder; color:#ccc; text-align: center">WWTL</p>--}}
                            {{--<p style="color:#bbb; text-align: center">Search all!!</p>--}}
                        {{--</div>--}}
                        {{--<script type="text/template" id="tmpl-result-all">--}}
                            {{--<%if(data.length> 0){%>--}}
                            {{--<hr />--}}
                            {{--<% if(data[0].length > 0 ){%>--}}
                            {{--<b>Person who has been rated</b>--}}
                            {{--<% _.each(data[0], function(v, i){%>--}}
                            {{--<a href="/rate/view/<%- v.seq %>">--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                                {{--<p>--}}
                                    {{--<%-v.name %>--}}
                                {{--</p>--}}
                            {{--</a>--}}
                            {{--<%})%>--}}
                            {{--<hr />--}}
                            {{--<%} if(data[1].length > 0 ){%>--}}
                            {{--<b>Person's Job</b>--}}
                            {{--<% _.each(data[1], function(v, i){%>--}}
                            {{--<a href="/rate/view/<%- v.seq %>">--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                                {{--<p>--}}
                                    {{--Job: <%-v.job %>--}}
                                {{--</p>--}}
                            {{--</a>--}}
                            {{--<%})%>--}}
                            {{--<hr />--}}
                            {{--<%} if(data[2].length > 0){%>--}}
                            {{--<b>Who first rated the person</b>--}}
                            {{--<% _.each(data[2], function(v, i){%>--}}
                            {{--<a>--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                            {{--</a>--}}
                            {{--<%})%>--}}
                            {{--<hr />--}}
                            {{--<%} if(data[3].length > 0){%>--}}
                            {{--<b>Who first rated the person</b>--}}
                            {{--<% _.each(data[3], function(v, i){%>--}}
                            {{--<a href="/rate/view/<%- v.seq %>">--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                                {{--<p>--}}
                                    {{--Job: <%-v.job %>--}}
                                {{--</p>--}}
                            {{--</a>--}}
                            {{--<%})%>--}}
                            {{--<hr />--}}
                            {{--<%} if(data[4].length > 0){%>--}}
                            {{--<b>All comment about the person</b>--}}
                            {{--<% _.each(data[4], function(v, i){%>--}}
                            {{--<a href="/rate/view/<%- v.seq %>">--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                                {{--<p>--}}
                                    {{--<%- v.comment.substr(0, 80) %>--}}
                                    {{--<%- v.comment.length > 80 ? '...': ''%>--}}
                                {{--</p>--}}
                            {{--</a>--}}
                            {{--<%})}%>--}}
                            {{--<%}else{%>--}}
                            {{--<p class="text-center">No data</p>--}}
                            {{--<%}%>--}}
                        {{--</script>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Find someone.</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="search-detail">--}}
                            {{--<div class="form-inline text-right condition">--}}
                                {{--<a class="condi-del"><i class="glyphicon glyphicon-remove"></i></a>--}}
                                {{--<select class="form-control sel-condition">--}}
                                    {{--<option value="c-name">Name</option>--}}
                                    {{--<option value="c-featured">Rate featured</option>--}}
                                    {{--<option value="c-job">Job</option>--}}
                                    {{--<option value="c-birth">Year of Birth</option>--}}
                                {{--</select>--}}
                                {{--<input type="text" class="form-control val-condition c-name on" />--}}
                                {{--<input type="text" class="form-control val-condition c-job" />--}}
                                {{--<select class="form-control val-condition c-featured">--}}
                                    {{--@foreach($ratetype as $data )--}}
                                        {{--<option value="{{$data->rate_type}}">{{$data->name}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                                {{--<select class="form-control val-condition c-birth">--}}
                                    {{--@for($i=date('Y')+1; $i--; $i>1700)--}}
                                        {{--<option>{{$i}}</option>--}}
                                    {{--@endfor--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<script type="text/template" id="tmpl-condition">--}}
                            {{--<div class="form-inline text-right condition">--}}
                                {{--<a class="condi-del"><i class="glyphicon glyphicon-remove"></i></a>--}}
                                {{--<select class="form-control sel-condition">--}}
                                    {{--<option value="c-name">Name</option>--}}
                                    {{--<option value="c-featured">Rate featured</option>--}}
                                    {{--<option value="c-job">Job</option>--}}
                                    {{--<option value="c-birth">Year of Birth</option>--}}
                                {{--</select>--}}
                                {{--<input type="text" class="form-control val-condition c-name on" />--}}
                                {{--<input type="text" class="form-control val-condition c-job" />--}}
                                {{--<select class="form-control val-condition c-featured">--}}
                                    {{--@foreach($ratetype as $data )--}}
                                        {{--<option value="{{$data->rate_type}}">{{$data->name}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                                {{--<select class="form-control val-condition c-birth">--}}
                                    {{--@for($i=date('Y')+1; $i--; $i>1700)--}}
                                        {{--<option>{{$i}}</option>--}}
                                    {{--@endfor--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</script>--}}
                        {{--<div class="text-right">--}}
                            {{--<a id="btn-condi-add" class="btn btn-default btn-sm">Add condition</a>--}}
                            {{--<a id="btn-condi-remove" class="btn btn-default btn-sm">Remove all</a>--}}
                            {{--<a id="btn-condi-search" class="btn btn-default btn-sm" id="search-detail">Search</a>--}}
                        {{--</div>--}}
                        {{--<div id="result-detail" class="rate"></div>--}}
                        {{--<script type="text/template" id="tmpl-result-detail">--}}
                            {{--<%if(data.length> 0){%>--}}
                            {{--<hr />--}}
                            {{--<% _.each(data, function(v, i){%>--}}
                            {{--<a href="/rate/view/<%- v.seq %>">--}}
                                {{--<img src="<%- v.photo %>" />--}}
                                {{--<span><%- v.nick_name %></span>--}}
                            {{--</a>--}}
                            {{--<hr />--}}
                            {{--<%})}else{%>--}}
                            {{--<p class="text-center">No data</p>--}}
                            {{--<%}%>--}}
                        {{--</script>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}
@endsection
@section('scripts')
    <script src="/scripts/views/home.js?"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5cttHt1JC55QdJH7Ki41zIOXIF0I5lR8&signed_in=true&libraries=places&callback=initMap">
    </script>

    @if($authCheck != '')
    <script>
        modal({
            type: 'alert',
            title: 'WWTL',
            text: 'Your account is not registered. Sign up please.'
        })
    </script>
    @endif
@endsection