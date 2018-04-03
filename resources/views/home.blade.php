@extends('web.partials.app')

@section('content')
<div class="masthead z-depth-5">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="row">
                        <div class="col s3">
                            <img src="{{asset('images/elect-ng-logo.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                            <div class="card-title" style="font-size: 40px;">Elect-NG Official <small>Version 1.0</small></div>
                            <div class="">
                                <div class="">
                                    <p class="flow-text">ElectNG is an election result management and collation system that provides qualitative and accurate result analysis at real time. 
                                    Getting result from different polling units in different wards in different local government from different states has been made easy. </p>
                                    <a class="waves-effect waves-light btn-large"><i class="material-icons left">cloud_download</i>iOS Store</a>
                                    <a class="waves-effect waves-light btn-large"><i class="material-icons left">cloud_download</i>Android Store</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col s12" style="padding: 20px;">
                <center>
                    <p class="flow-text" style="font-size: 30px;">Get election result of any level at realtime. <br/>
                        infographical result analysis on at your finger tips.</p>
                </center>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col s6">
                <p>&copy;Copyright <?php echo date('Y', time()); ?>. All Rights Reserved.</p>
            </div>
            <div class="col s6" align="right">
                <p>Powered By: <a href="https://codemansion.org" target="_blank">CodeMansion Technology</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
