@extends('layouts.app')

@section('css')
    <link href="/css/cropbox.css" rel="stylesheet">
    <link href="/css/fileinput.css" rel="stylesheet">
    <link href="/css/slider.css" rel="stylesheet">
    <link href="/css/views/user.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
@endsection
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="intro">
            <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 text-center">
                <div class="row-fluid step on" data-step="1">
                    <div class="alert alert-info" role="alert">What is your nick name?</div>
                    <input type="text" class="form-control" id="nick_name" name="nick_name" />
                </div>
                <div class="row-fluid step" data-step="2">
                    <div class="alert alert-info" role="alert">What is your birthday?</div>
                    <input type="hidden" id="birth" name="birth" />
                </div>
                <div class="row-fluid step" data-step="3">
                    <div class="alert alert-info" role="alert">What is your gender?</div>
                    <div class="btn-group" id="gender" data-toggle="buttons">
                        <label class="btn btn-default active">
                            <input type="radio" name="gender" value="0" autocomplete="off">Male
                        </label>
                        <label class="btn btn-default">
                            <input type="radio" name="gender" value="1" autocomplete="off">Female
                        </label>
                    </div>
                </div>
                <div class="row-fluid step Cropbox" data-step="4">
                    <div class="alert alert-info" role="alert">Can you give your photo?</div>
                    <div class="container">
                        <div class="action">
                            <input type="file" id="file" class="filestyle" data-badge="false" />
                            <input type="hidden" id="photo" />

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

                </div>
                <div class="row-fluid step" data-step="5">
                    <div class="alert alert-info" role="alert">What is your job?</div>
                    <input type="text" class="form-control" id="job" name="job" />
                </div>
                <div class="row-fluid step" data-step="6" style="position:relative">
                    <div class="alert alert-info" role="alert">Where do you live?</div>
                    <input id="locale" name="locale" class="form-control" type="text" />
                </div>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 text-center">
                <a id="btn-prev" class="btn btn-default">
                    <i class="glyphicon glyphicon-chevron-left"></i> <span>Prev</span>
                </a>
                <a id="btn-next" class="btn btn-primary">
                    <span>Next</span> <i class="glyphicon glyphicon-chevron-right"></i>
                </a>
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
    <script src="/scripts/views/user.intro.js"></script>

@endsection