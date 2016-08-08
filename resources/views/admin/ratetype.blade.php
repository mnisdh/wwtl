@extends('layouts.app')
@section('css')
    <link href="/css/views/admin.css" rel="stylesheet">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Admin</div>

        <div class="panel-body">
            <ul class="nav nav-pills">
                <li role="presentation" class="active"><a href="/admin/ratetype">Rate Type</a></li>
                <li role="presentation"><a href="/admin/rateitem">Rate Item</a></li>
            </ul>
            <div class="form-inline" id="add-item">
                <input type="text" class="form-control" id="txt-name">
                <a class="btn btn-success disabled" id="btn-submit">submit</a>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table" id="tbl-ratetype">
                <colgroup>
                    <col width="5%" />
                    <col width="70%" />
                    <col width="10%" />
                    <col width="15%" />
                </colgroup>
                <thead>
                    <tr>
                        <th>CODE</th>
                        <th>NAME</th>
                        <th>USE_YN</th>
                        <th>INDEX</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <script type="text/template" id="tmpl-ratetype">
            <% _.each(data, function(v, i){  %>
                <tr>
                    <td class="rate_type text-center"><%- v.rate_type %></td>
                    <td class="form-inline">
                        <input type="text" class="txt-name form-control" value="<%- v.name %>" />
                        <a class="btn btn-sm btn-success update-name"><i class="glyphicon glyphicon-ok"></i></a>
                    </td>
                    <td class="text-center"><input type="checkbox" class="chk-use" <%- v.use_yn=='Y'? 'checked':'' %> /></td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-default btn-up"><i class="glyphicon glyphicon-arrow-up"></i></a>
                        <a class="btn btn-sm btn-default btn-down"><i class="glyphicon glyphicon-arrow-down"></i></a>
                    </td>
                </tr>
            <%}) %>
            </script>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/scripts/views/admin.ratetype.js"></script>
@endsection