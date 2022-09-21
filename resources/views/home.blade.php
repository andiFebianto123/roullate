@extends('index')


@section('style')
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <style>
            #loader {
                position: absolute;
                left: 0%;
                top: 0%;
                z-index: 999;
                width:100%;
                height: 100%;
                display: flex;
                background-color: #EDEDED;
                justify-content: center;
                align-items: center;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div id="loader">
        <img src="{{ URL::asset('media/loader.gif') }}" />
    </div>
    <div id="container" class="main-content">
        <button class="spinBtn">CLICK TO SPIN!</button>
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
@endsection

@section('script')
    <script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>
    <script src="{{ URL::asset('js/Draggable.min.js') }}"></script>
    <script src="{{ URL::asset('js/InertiaPlugin.min.js') }}"></script>
    <script src="{{ URL::asset('js/TextPlugin.min.js') }}"></script>
    <script src="{{ URL::asset('js/Spin2WinWheel.min.js') }}"></script>
    <script>
        function loadJSON(callback) {
            var xobj = new XMLHttpRequest();
                // xobj.overrideMimeType("application/json");
                xobj.open('GET', "{{ route('showdata') }}", true);
                xobj.onreadystatechange = function() {
                if (xobj.readyState == 4 && xobj.status == "200") {
                    //Call the anonymous function (callback) passing in the response
                    setTimeout(function(){
                        $('#loader').fadeOut();
                    }, 2000);
                    callback(xobj.responseText);
                }
            };
            xobj.send(null);
        }
    </script>
    <script src="{{ URL::asset('js/index.js') }}"></script>
@endsection
