@extends('layouts.app')
@section('css')
    <link href="/css/views/home.css?20160907" rel="stylesheet">
@endsection
@section('main')
    <div class="row">
        <div class="col-md-7" id="target-board">
            <div class="row" id="show-map">
                <div class="col-xs-9">
                    <div id="map"></div>
                    <label class="checkbox-inline"><input id="chk-country" type="checkbox" />Search only in</label>
                    <select id="country" disabled>
                        @foreach($country as $data)
                            <option value="{{$data->country_code}}">{{$data->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-3" id="search-board"></div>
            </div>
        </div>
        <script type="text/template" id="tmpl-search">
        <% _.each(data, function(v, i){%>
                <a class="target" href="/rate/view/<%- v.seq %>">
                    <span class="loc"><%- i+1 %></span>
                    <img class="img-rounded" src="<%- v.photo %>" />
                    <span><%- v.nick_name %></span>
                </a>
        <%})%>
        </script>
        <div class="col-md-5 search">
            <div class="row">
                <div class="col-xs-12 disc">
                    <b>You can find anyone.</b> If you search by name, nick name, birthday, city, state or country.
                </div>
                <div class="col-xs-12 disc">
                    <b>You can rate anyone.</b> Rate your girlfriend, boyfriend, boss, ex-wife, ex-husband, the mail man, your plumber, teachers, parents.  ANYONE!
                </div>
                <div class="col-xs-12 txt">
                    <i class="glyphicon glyphicon-user"></i>
                    <input type="text" id="target" placeholder="name, nick name or year of birth">
                </div>
                <div class="col-xs-12 txt">
                    <i class="glyphicon glyphicon glyphicon-map-marker"></i>
                    <input type="text" id="locale" placeholder="city or state" />
                    <input type="hidden" id="locale_cd" value="" />
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
                    <div class="panel-heading">Who rated me?</div>
                    <div class="panel-body rate">
                        @foreach($rateme as $data)
                            <a href="/rate/view/{{ $data->target_seq }}">
                                <img src="{{ $data->photo }}" />
                                <span>{{ $data->nick_name }}</span>
                                <p>{{ $data->name }} / score: <b>{{ substr($data->rate_score, 0, 4) }}</b></p>
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
                                <p>{{ $data->name }} / score: <b>{{ substr($data->rate_score, 0, 4)}}</b></p>
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
                            <%if(data.length> 0){%>
                            <hr />
                            <% if(data[0].length > 0 ){%>
                            <b>Person who has been rated</b>
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
                            <b>Person's Job</b>
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
                            <b>Who first rated the person</b>
                            <% _.each(data[2], function(v, i){%>
                            <a>
                                <img src="<%- v.photo %>" />
                                <span><%- v.nick_name %></span>
                            </a>
                            <%})%>
                            <hr />
                            <%} if(data[3].length > 0){%>
                            <b>Who first rated the person</b>
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
                            <b>All comment about the person</b>
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
                            <%}else{%>
                            <p class="text-center">No data</p>
                            <%}%>
                        </script>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Find someone.</div>
                    <div class="panel-body">
                        <div class="search-detail">
                            <div class="form-inline text-right condition">
                                <a class="condi-del"><i class="glyphicon glyphicon-remove"></i></a>
                                <select class="form-control sel-condition">
                                    <option value="c-name">Name</option>
                                    <option value="c-featured">Rate featured</option>
                                    <option value="c-job">Job</option>
                                    <option value="c-birth">Year of Birth</option>
                                </select>
                                <input type="text" class="form-control val-condition c-name on" />
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
                        </div>
                        <script type="text/template" id="tmpl-condition">
                            <div class="form-inline text-right condition">
                                <a class="condi-del"><i class="glyphicon glyphicon-remove"></i></a>
                                <select class="form-control sel-condition">
                                    <option value="c-name">Name</option>
                                    <option value="c-featured">Rate featured</option>
                                    <option value="c-job">Job</option>
                                    <option value="c-birth">Year of Birth</option>
                                </select>
                                <input type="text" class="form-control val-condition c-name on" />
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
                        </script>
                        <div class="text-right">
                            <a id="btn-condi-add" class="btn btn-default btn-sm">Add condition</a>
                            <a id="btn-condi-remove" class="btn btn-default btn-sm">Remove all</a>
                            <a id="btn-condi-search" class="btn btn-default btn-sm" id="search-detail">Search</a>
                        </div>
                        <div id="result-detail" class="rate"></div>
                        <script type="text/template" id="tmpl-result-detail">
                            <%if(data.length> 0){%>
                            <hr />
                            <% _.each(data, function(v, i){%>
                            <a href="/rate/view/<%- v.seq %>">
                                <img src="<%- v.photo %>" />
                                <span><%- v.nick_name %></span>
                            </a>
                            <hr />
                            <%})}else{%>
                            <p class="text-center">No data</p>
                            <%}%>
                        </script>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script src="/scripts/views/home.js"></script>
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