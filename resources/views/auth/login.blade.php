@extends('partials.app_auth')

@section('login_content')
<div class="content" style="padding:60px;">
    <div class="container">
        <div class="row ">
        <div class="col-4 col-xl-4"></div>
            <div class="col-4 col-xl-4">
                <div id="logo-hold">
                    <center><img class="img-avatar" src="{{ asset('images/logo.png') }}" alt=""></center>
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
                <div class="block block-content">
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
                <center>
                    <p><a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a> </p>
                </center>
            </div>
        </div>
        <div class="col-4 col-xl-4"></div>
    </div>
</div>
@endsection
