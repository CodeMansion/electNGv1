@extends('partials.app_auth')

@section('login_content')
<div class="content" style="padding:60px;">
    <div class="container">
        <div class="row ">
            <div class="col-4 col-xl-4"></div>
            <div class="col-4 col-xl-4">
                <div id="logo-hold">
                    <center><img class="img-avatar" src="{{ asset('images/elect-ng-logo.png') }}" alt=""></center>
                </div>
                @if ($errors->has('email'))
                    <div class="danger-well-login">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
                @if ($errors->has('password'))
                    <div class="danger-well-login">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
                <div class="block block-content" style="background-color: #ffffff70;">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"><label for="email" class="control-label">E-Mail Address</label>
                            <div class="">
                                <input id="email" type="email" class="input-box form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class=" control-label">Password</label>
                            <div class="">
                                <input id="password" type="password" class="input-box form-control" name="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="input-box form-control create-hover btn btn-alt-primary">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
            <div class="col-4 col-xl-4"></div>
        </div>
        <div style="bottom:0;color: white;font-size: 15px;padding: 5px;margin-top:50px;">
        <center>Powered By: <a href="https://codemansion.org" target="_blank" style="color: white;">CodeMansion Technology</a></center>
    </div>
    </div>
</div>
@endsection
