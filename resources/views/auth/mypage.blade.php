@extends('layouts.app')

@section('css')
    <link href="/css/cropbox.css" rel="stylesheet">
    <link href="/css/fileinput.css" rel="stylesheet">
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/auth.mypage.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">My Page
            <a id="btn-update" class="btn btn-primary btn-sm" href="#" role="button">Update</a>
            @if(\Auth::user()->auth_key = '')
            <a href="/password/reset" class="btn btn-default btn-sm" href="#" role="button">Reset password</a></div>
            @endif
        <div class="panel-body">
            <div class="row">
                <div class="col-md-5">
                        <div class="action">
                            <input type="file" id="file" class="filestyle" data-badge="false" />
                            <input type="hidden" id="photo" value="{{ Auth::user()->photo }}" />

                            <input id="slider-zoom" type="text"
                                   data-slider-min="0"
                                   data-slider-max="2"
                                   data-slider-step="0.1"
                                   data-slider-value="1"
                                   data-slider-tooltip="hide"
                                   data-slider-enabled="false" />

                            <input type="button" id="btnCrop" value="ok" style="display:none;">
                        </div>
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="display: none">Loading...</div>
                        </div>
                        <div class="cropped">

                        </div>
                </div>
                <div class="col-md-7">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <label>Nick Name</label>
                            <input type="text" value="{{Auth::user()->nick_name}}" class="form-control" id="nick_name" name="nick_name" />
                        </li>
                        <li class="list-group-item">
                            <label>Date of birth</label>
                            <input type="hidden" value="{{Auth::user()->birth}}" id="birth" name="birth" />
                        </li>
                        <li class="list-group-item">
                            <label style="margin-right:20px;">Gender</label>
                            <div class="btn-group" id="gender" data-toggle="buttons">
                                <label class="btn btn-default {{ Auth::user()->gender == 0 ? 'active':'' }}">
                                    <input type="radio" name="gender" value="0" autocomplete="off">Male
                                </label>
                                <label class="btn btn-default {{ Auth::user()->gender == 1 ? 'active':'' }}">
                                    <input type="radio" name="gender" value="1" autocomplete="off">Female
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <label>Job</label>
                            <input type="text" value="{{Auth::user()->job}}" class="form-control" id="job" name="job" />
                        </li>
                        <li class="list-group-item">
                            <label>State, Country</label>
                            <input type="text"  value="{{Auth::user()->locale}}" id="locale" name="locale" class="form-control" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('plugin')
    <script src="/scripts/plugin/jquery.date-dropdowns.min.js"></script>
    <script src="/scripts/plugin/moment.js"></script>
    <script src="/scripts/plugin/bootstrap-slider.js"></script>
    <script src="/scripts/plugin/cropbox.js"></script>
    <script src="/scripts/plugin/bootstrap-filestyle.min.js"></script>
@endsection
@section('scripts')
    <script src="/scripts/views/auth.mypage.js"></script>

@endsection
