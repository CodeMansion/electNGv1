<html>
    <head>
        <style>
            body {
                background-color: #c6c6ca;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .container {
                margin-left: 20%;
                margin-right: 20%;
            }

            .inner {
                background-color: white;
            }

            .inner .body {
                padding: 30px;
                font-size: 13px;
            }

            .inner .body p {
                font-size: 14px;
            }

            .inner .bottom {
                background-color: #0D5076;
                padding-left: 20px;
                padding-top: 5px;
                padding-bottom: 5px;
                border-bottom: 1px solid grey;
                font-size: 13px;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="inner">
                <div class="body">
                    <div style="padding:20px;border-radius:15px;border:2px solid #1DBBBD;font-size:17px;">
                        <center><img src="{{ asset('images/logo.png') }}" style="width:100px;height:100px;"></center>
                        <p>
                            Dear {{strtoupper($user->profile->first_name.' '.$user->profile->last_name)}}, <br/><br/>

                            You have been assigned to a polling station has a polling station official. Find below your ONE-TIME PASSCODE to 
                            submit your polling station result.
                        
                        </p><hr/>
                        <center>
                            <button style="width:150px;height:50px;border-radius:10px;background-color:#1DBBBD;color:white;" type="button">
                                {{$passcode}}
                            </button>
                        </center>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>