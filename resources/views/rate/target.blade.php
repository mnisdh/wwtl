@extends('layouts.app')

@section('css')
    <link href="/css/cropbox.css" rel="stylesheet">
    <link href="/css/fileinput.css" rel="stylesheet">
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/rate.target.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Who would you like to rate?
            </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-5">
                        <div class="action">
                            <input type="hidden" id="seq" value="{{$seq}}" />
                            <input type="file" id="file" class="filestyle" data-badge="false" />
                            <input type="hidden" id="photo" value="{{ $seq == -1 ? '' : \App\Target::find($seq)->photo }}" />

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
                            <label>First Name*</label>
                            <input type="text" value="{{$seq == -1 ? '' : \App\Target::find($seq)->first_name}}" class="form-control" id="first_name" name="first_name" />
                        </li>
                        <li class="list-group-item">
                            <label>Last Name*</label>
                            <input type="text" value="{{$seq == -1 ? '' : \App\Target::find($seq)->last_name}}" class="form-control" id="last_name" name="last_name" />
                        </li>
                        <li class="list-group-item">
                            <label>Nick Name*</label>
                            <input type="text" value="{{$seq == -1 ? '' : \App\Target::find($seq)->nick_name}}" class="form-control" id="nick_name" name="nick_name" />
                        </li>
                        <li class="list-group-item">
                            <label>Date of birth*</label>
                            <input type="hidden" value="{{$seq == -1 ? '' : \App\Target::find($seq)->birth}}" id="birth" name="birth" />
                        </li>
                        <li class="list-group-item">
                            <label style="margin-right:20px;">Gender*</label>
                            <div class="btn-group" id="gender" data-toggle="buttons">
                                <label class="btn btn-default {{ $seq == -1 ? 'active' : \App\Target::find($seq)->gender == 0 ? 'active':'' }}">
                                    <input type="radio" name="gender" value="0" autocomplete="off">Male
                                </label>
                                <label class="btn btn-default {{ $seq == -1 ? '' : \App\Target::find($seq)->gender == 1 ? 'active':'' }}">
                                    <input type="radio" name="gender" value="1" autocomplete="off">Female
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <label>Job</label>
                            <input type="text" value="{{$seq == -1 ? '' : \App\Target::find($seq)->job}}" class="form-control" id="job" name="job" />
                        </li>
                        <li class="list-group-item">
                            <label>State, Country*</label>
                            <input type="text"  value="{{$seq == -1 ? '' : \App\Target::find($seq)->locale}}" id="locale" name="locale" class="form-control" />
                            <input type="hidden" id="locale_cd" name="locale_cd" value="{{$seq == -1 ? '' : \App\Target::find($seq)->locale_cd}}" />
                            <input type="hidden" id="lat" name="lat" value="{{$seq == -1 ? '' : \App\Target::find($seq)->lat}}" />
                            <input type="hidden" id="lng" name="lng" value="{{$seq == -1 ? '' : \App\Target::find($seq)->lng}}" />
                        </li>
                        <li class="list-group-item">
                            <a id="btn-update" class="btn btn-primary btn-sm" href="#">Continue</a>
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
    <script src="/scripts/views/rate.target.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5cttHt1JC55QdJH7Ki41zIOXIF0I5lR8&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection
