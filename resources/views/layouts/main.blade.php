<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }} {{ isset($title) ? ' | '.$title : '' }}</title>
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    @stack('page_library')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #loading-bar {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 99999999;
            height: 3px;
            /* background-color: #007bff; */
            width: 0%;
            transition: width 0.3s;
        }
        input {
            background-color: transparent;
        }
        table.dataTable {
            width: 100% !important;
            border: 1px solid gray;
            border-radius: 10px;
            margin-top: 10px;
        }
        div.dataTables_filter label input {
            border-radius: 10px !important;
        }

        div.dataTables_length label select {
            border-radius: 10px !important;
        }

        div.dataTables_wrapper div.dataTables_length {
            margin-bottom: 15px !important;
        }
    </style>
    @stack('page_style')
</head>
    @isset($auth)
<body class="w-screen h-screen overflow-hidden" id="website-body">
    @else
<body class="h-screen w-screen flex flex-col overflow-clip" id="website-body">
    <div id="loading-bar" class="bg-primary"></div>
    <div class="absolute inset-x-0 top-0 z-50">
        @include('layouts.navbar')
    </div>
    <div class="flex h-full w-full">
        @include('layouts.sidebar')
    @endisset
        @isset($auth)
        <div class="">
        @else
        <div class="flex flex-col overflow-auto h-full absolute right-0 p-4 top-14" style="width:82.5%;">
        @endisset
            @yield('content')
        </div>
    </div>
</body>
</html>
<script>
function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;

    $('#hour').text(hours);
    $('#minute').text(minutes);
    $('#second').text(seconds);
}
updateClock();
setInterval(() => {
    updateClock();
}, 1000);

$(document).ready(function() {
    // animasi loading bar
    $(document).ajaxStart(function() {
        $('#loading-bar').css('width', '0%').show().animate({width: '70%'}, 500);
    });

    $(document).ajaxStop(function() {
        $('#loading-bar').animate({width: '100%'}, 200, function() {
            $(this).hide().css('width', '0%');
        });
    });

    $(window).on('beforeunload', function() {
        $('#loading-bar').css('width', '0%').show().animate({width: '70%'}, 50);
    });

    $(window).on('load', function() {
        $('#loading-bar').animate({width: '100%'}, 100, function() {
            $(this).hide().css('width', '0%');
        });
    });
});

var options = {
            weekday: 'long', // Show full day name
            year: 'numeric',
            month: 'long', // Show full month name
            day: 'numeric'
        };
$('#date').text(new Date().toLocaleDateString('id-ID', options));

function toggleFullScreen() {
       if (!document.fullscreenElement &&    // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
         if (document.documentElement.requestFullscreen) {
           document.documentElement.requestFullscreen();
         } else if (document.documentElement.mozRequestFullScreen) {
           document.documentElement.mozRequestFullScreen();
         } else if (document.documentElement.webkitRequestFullscreen) {
           document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
         }
         document.getElementById('icon-fullscreen').classList.remove('la-compress')
         document.getElementById('icon-fullscreen').classList.add('la-compress-arrows-alt')
       } else {
          if (document.cancelFullScreen) {
             document.cancelFullScreen();
          } else if (document.mozCancelFullScreen) {
             document.mozCancelFullScreen();
          } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
          }
          document.getElementById('icon-fullscreen').classList.remove('la-compress-arrows-alt')
         document.getElementById('icon-fullscreen').classList.add('la-compress')
       }
     }
     @isset($auth)
     @else
     document.addEventListener('DOMContentLoaded', function () {
         document.getElementById('account').addEventListener('click', function () {
             document.getElementById('accountDropdown').classList.toggle('hidden');
            });
        });
        @endisset
</script>
@stack('page_script')
