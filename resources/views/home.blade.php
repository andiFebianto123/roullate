@extends('index')


@section('style')
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <style>
            #loader {
                position: absolute;
                left: 0%;
                top: 0%;
                z-index: 9;
                width:100%;
                height: 100%;
            }
            body {
                background-image: url("{{ URL::asset('media/crumbled paper.png') }}") !important;

                /* Full height */
                height: 100% !important;

                background-position: center !important;
                background-repeat: fixed !important;
                background-size: cover !important;
            }
            .build {
                overflow: hidden;
                position: relative;
                top: -100px;
                z-index: 21;
                opacity: 0;
            }
            .build .sidebar {
                float: left;
                width: 400px;
                margin-right: 200px;
                margin-left: 30px;
            }
            .build .right-panel {
                float:left;
                width: 600px;
            }
            #container {
                width:100% !important;
            }
            .top {
                z-index: 20;
                position: relative;
                height: 160px;
                width: 100%;
                background-image: url("{{ URL::asset('media/top red.png') }}") !important;
                overflow:hidden;
                padding-top:12px;
            }
            .footer{
                z-index: 20;
                clear: both;
                position: relative;
                margin-top: -300px;
                height: 100px;
            }
            #loader .logo {
                padding-top: 150px;
            }
            .top .lazone {
                z-index: 90;
                float:right;
                margin-right:12px;
            }
            .wheelText {
                /* fill: black !important; */
                font-weight: 800;
            }

            .progress {
                width:400px;
                margin-top: 10px;
            }
            
            @media only screen and (max-width: 500px) {
                #loader .logo img{
                    width:100%;
                    height: 200px;
                }
                .progress {
                    width: 50%;
                }
                .img-price {
                    width:100%;
                    height: 400px;
                }
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="top">
        <img class="lazone" src="{{ URL::asset('media/logo lazone.png') }}" height="40"/>
    </div>
    <div id="loader">
        <div class="logo">
            <img src="{{ URL::asset('media/logo roullate.png') }}" height="230" />
        </div>
        <div>
            <center>
            <h2 class="loader-text" style="margin-top:10px;">50%</h2>
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" aria-label="Success example" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            </center>
        </div>
    </div>
    <div class="container-fluid build">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-4">
                <center>
                    <img class="img-price" src="{{ URL::asset('media/roullate giveaway.png') }}" height="550" />
                </center>
            </div>
            <div class="col-md-6 col-sm-4">
                <div id="container">
                    <center><button class="spinBtn">CLICK TO SPIN!</button></center>
                    <div class="wheelContainer">
                        <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" text-rendering="optimizeSpeed" preserveAspectRatio="xMidYMin meet">
                            <defs>
                                <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%">
                                    <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset>
                                    <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop" />
                                    <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0   0
                        0 0 0 0   0 
                        0 0 0 0   0 
                        0 0 0 .3 0" />
                                    <feBlend in="SourceGraphic" in2="color-out" mode="normal" />
                                </filter>
                            </defs>
                            <g class="mainContainer">
                                <g class="wheel">
                                </g>
                            </g>
                            <g class="centerCircle" />
                            <g class="wheelOutline" />
                            <g class="pegContainer" opacity="1">
                                <path class="peg" fill="#EEEEEE" d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232 s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z" />
                            </g>
                            <g class="valueContainer" />
                            <g class="centerCircleImageContainer" />
                        </svg>
                        <div class="toast" style="display:none !important;">
                            <p></p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <img src="{{ URL::asset('media/bottom red.png') }}" height="200" style="width:100%;"/>
    </div>
@endsection

@section('script')
    <script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>
    <script src="{{ URL::asset('js/Draggable.min.js') }}"></script>
    <script src="{{ URL::asset('js/InertiaPlugin.min.js') }}"></script>
    <script src="{{ URL::asset('js/TextPlugin.min.js') }}"></script>
    <script src="{{ URL::asset('js/Spin2WinWheel.min.js') }}"></script>
    <script>
        $(".spinBtn").prop("disabled", true);
        function loadJSON(callback) {

            var percent = 0;

            var loader = setInterval(function(){
                percent+=2;
                $('.progress-bar').css('width', `${percent}%`);
                $('.loader-text').html(`${percent} %`);
                if(percent >= 96){
                    clearInterval(loader);
                    var xobj = new XMLHttpRequest();
                    // xobj.overrideMimeType("application/json");
                    xobj.open('GET', "{{ route('showdata') }}", true);
                    xobj.onreadystatechange = function() {
                    if (xobj.readyState == 4 && xobj.status == "200") {
                        //Call the anonymous function (callback) passing in the response
                        $('.progress-bar').css('width', `100%`);
                        $('.loader-text').html(`100 %`);
                        setTimeout(function(){
                            $('#loader').fadeOut();
                            $('.build').animate({
                                opacity: 1,
                            }, 1000, function(){
                                $(".spinBtn").prop("disabled", false);
                            });
                        }, 2000);
                        callback(xobj.responseText);
                    }
                };
                xobj.send(null);
                }
            }, 90);
        }
    </script>
    <script src="{{ URL::asset('js/index.js') }}"></script>
@endsection
