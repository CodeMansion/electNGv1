@extends('partials.app_auth')

@section('login_content')
<div class="content">
    <div class="row">
        <div class="section"></div>
            <div class="col s10 offset-s1">
                <form method="POST" action="{{ route('login') }}"> {{ csrf_field() }}
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s6 offset-s1"></div>
                                <div class="col s4">
                                    <div id="logo-hold">
                                        <center>
                                            <a href="https://codemansion.org">
                                                <img style="height: 150px;width:150px;" src="{{ asset('images/elect-ng-logo.png') }}" alt="ElectNG Logo">
                                            </a>
                                        </center>
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

                                    <div class="input-field{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <i class="material-icons prefix">account_circle</i>
                                        <input id="email" type="email"  class="validate" name="email" value="{{ old('email') }}" required autofocus>
                                        <label for="icon_prefix">Email</label>
                                    </div>

                                    <div class="input-field{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="password" type="password" class="validate" name="password" required>
                                        <label for="icon_prefix">Password</label>
                                    </div>
                                    <div class="section"></div>
                                    <div class="section"></div>
                                    <button type="submit" class="btn btn-fill btn-wd btn-block">Login</button> 
                                </div>
                            </div><br/>
                            <center><p><b>Powered By: <a href="https://codemansion.org" target="_blank">CodeMansion Technology</a></b> | All Rights Reserved.</p></center>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
@endsection
