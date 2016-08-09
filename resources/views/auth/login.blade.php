@extends('layouts.app')

@section('css')
    <link href="/css/views/auth.login.css" rel="stylesheet">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <div class="col-md-8">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-7">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-7">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <a href="{{ url('/register') }}" class="btn btn-default">
                                Register
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-sign-in"></i> Login
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <a class="btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <a class="btn-auth" id="btn-google" data-href="{!!URL::to('/auth/google')!!}">Sign in with Google</a>
                <br />
                <a class="btn-auth" id="btn-facebook" data-href="{!!URL::to('/auth/facebook')!!}">Sign in with Facebook</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.btn-auth').click(function () {
            var url = $(this).data('href');
            modal({
                type: 'confirm',
                title: 'Confirm',
                text: 'Provision Message',
                buttonText: {
                    ok: 'OK',
                    yes: 'Allow',
                    cancel: 'Deny'
                },
                callback: function(result) {
                    if(result)
                    {
                        location.href = url;
                    }
                }
            })
        })
    </script>
@endsection
