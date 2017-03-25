@extends('layouts.app')

@section('css')
    <style>
        a.mail {margin-left:50px;}
        .i_mail {
            font-size:150px; color:#f3f2f2; }
    </style>
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Contact</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-9">
                    <p>To have your information removed from this site email:  <br />
                        <a class="mail" href="mailto:remove@whatweretheylike.com">remove@whatweretheylike.com</a></p>
                    <p>To close your account email:  <br />
                        <a class="mail" href="mailto:account@whatweretheylike.com">account@whatweretheylike.com</a></p>
                    <p>To inquire about anything else email : <br />
                        <a class="mail" href="mailto:info@whatweretheylike.com">info@whatweretheylike.com</a></p>
                    <hr />
                    <p>
                        remove data<br />
                        make it so you redirect to login page before you can start rating someone<br />
                        I will get you terms of service tomorrow<br />
                    </p>
                </div>
                <div>
                    <i class="glyphicon glyphicon-envelope i_mail"></i>
                </div>
            </div>
        </div>
    </div>
@endsection


