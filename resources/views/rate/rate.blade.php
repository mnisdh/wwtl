@extends('layouts.app')

@section('css')
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/rate.rate.css" rel="stylesheet">
@endsection
@section('content')
    <input id="target-seq" type="hidden" value="{{$target->seq}}" />
    <div class="panel panel-default">
        <div class="panel-heading">
            Rate <a href="/rate/view/{{ $target->seq }}">{{ $target->nick_name }}</a>
            <select id="sel-type">
                @foreach(\App\Ratetype::all() as $data )
                    <option value="{{$data->rate_type}}">{{$data->name}}</option>
                @endforeach
            </select>
            <a id="btn-update" class="btn btn-primary btn-sm" href="#" role="button">Rate</a></div>
        <div class="panel-body">
            <p class="text-right">What year that did you know this person?
                <select id="knew-year">
                    @for($i=date('Y')+1; $i--; $i>1700)
                    <option>{{$i}}</option>
                    @endfor
                </select>
            </p>
            <table id="tbl-item"></table>
            <script type="text/template" id="tmpl-item">
            <% _.each(data, function(v, i){%>
            <tr>
                <th class="col-md-4 text-right">
                    <%- v.name %>
                    <a class="btn btn-default btn-na" data-item="<%- v.rate_item%>">N/A</a>
                </th>
                <td class="col-md-8">
                    <input class="slider-item" data-item="<%- v.rate_item %>" id="item<%- v.rate_item%>"
                           data-slider-ticks="[0,1,2,3,4,5,6,7,8,9,10]"
                           data-slider-ticks-labels='[0,1,2,3,4,5,6,7,8,9,10]'
                           type="text" data-slider-min="0" data-slider-max="10" data-slider-step="0.1" data-slider-value="5" />
                </td>
            </tr>
            <%})%>
            <tr>
                <th class="col-md-4 text-right">Comment</th>
                <td class="col-md-8"><textarea class="form-control txt-comment"></textarea></td>
            </tr>
            </script>
        </div>
    </div>
@endsection


@section('plugin')
    <script src="/scripts/plugin/bootstrap-slider.js"></script>
@endsection
@section('scripts')
    <script src="/scripts/views/rate.rate.js"></script>

@endsection
