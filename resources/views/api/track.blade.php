<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Book Tracking System</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>
<body>
  <div id="app">
    <main id="main">
    <script type="application/javascript">
      var result = @json($result);
      var widthData = {{json_encode($width)}};
      var heightData = {{json_encode($height)}};  
    </script>
      <h2 class="text-success"><strong>{{$b->title}}</strong></h2>
      <h3 style="color:#8a8a8a">Tag ID: {{$b->tag_id}}</h3>
      <h2 id="message" class="text-info"></h2>
      <div id="spinner" class="spinner-border" style="height:100px;width:100px"></div>
     
      <h1 id="message"></h1>
      <canvas id="can" width="600px" height="600px" style="display:none"></canvas>
      <img id="circImg" style="display:none"></img>
      <img id="display_img"></img>
      <div id="div_svg" style="display:none">
        <!-- <img src="/img/map.png" class="border" height="600px" weight="600px"> -->
        <svg id="svg_data" onload="draw()"
             xmlns="http://www.w3.org/2000/svg"
             xmlns:xhtml="http://www.w3.org/1999/xhtml"
             xmlns:xlink="http://www.w3.org/1999/xlink"
             xmlns:dc="http://purl.org/dc/elements/1.1/"
             xmlns:cc="http://creativecommons.org/ns#"
             xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
             xmlns:svg="http://www.w3.org/2000/svg"
             xmlns="http://www.w3.org/2000/svg"
             xmlns:a="http://www.adobe.com/svg10-extensions" a:timeline="independent">
        <defs>
          <pattern id="background_pattern" x="0" y="0" patternUnits="userSpaceOnUse">
            <rect id="pattern_rect" x="0" y="0" style="fill:transparent;stroke:blue; stroke-width:1;"/>
          </pattern>
        </defs>
          <rect width="100%" height="100%" style="fill:url(#background_pattern);stroke:orange;stroke-width:4" />

          <circle id="reader_a" r="5" style="fill:red"/>
          <circle id="reader_b" r="5" style="fill:red"/>
          <circle id="reader_c" r="5" style="fill:red"/>
          <circle id="reader_d" r="5" style="fill:red"/>

          <circle id="circle_a" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="circle_b" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="circle_c" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="circle_d" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>

          <!-- <line id="line_ab" style="stroke:black;stroke-width:2" />
          <line id="line_bc" style="stroke:black;stroke-width:2" />
          <line id="line_cd" style="stroke:black;stroke-width:2" />
          <line id="line_ad" style="stroke:black;stroke-width:2" />
          <text id="label_ab" style="font-size:16px;text-anchor:middle">m</text>
          <text id="label_bc" style="font-size:16px;text-anchor:middle">m</text>
          <text id="label_cd" style="font-size:16px;text-anchor:middle">m</text>
          <text id="label_ad" style="font-size:16px;text-anchor:middle">m</text> -->
        </svg>
      </div>
      <div id="display_svg" style="display:none">
        <!-- <img src="/img/map.png" class="border" height="600px" weight="600px"> -->
        <svg id="show_svg"
             xmlns="http://www.w3.org/2000/svg"
             xmlns:xhtml="http://www.w3.org/1999/xhtml"
             xmlns:xlink="http://www.w3.org/1999/xlink"
             xmlns:dc="http://purl.org/dc/elements/1.1/"
             xmlns:cc="http://creativecommons.org/ns#"
             xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
             xmlns:svg="http://www.w3.org/2000/svg"
             xmlns="http://www.w3.org/2000/svg"
             xmlns:a="http://www.adobe.com/svg10-extensions" a:timeline="independent">
          <defs>
            <pattern id="show_background_pattern" x="0" y="0" patternUnits="userSpaceOnUse">
              <rect id="show_pattern_rect" x="0" y="0" style="fill:white;stroke:blue; stroke-width:1;"/>
            </pattern>
          </defs>
          <rect width="100%" height="100%" style="fill:url(#show_background_pattern);stroke:orange;stroke-width:4" />

          <rect id="show_reader_a" width="40" height="40" style="stroke:gray;stroke-width:2;fill:red;fill-opacity:0.5" />
          <rect id="show_reader_b" width="40" height="40" style="stroke:gray;stroke-width:2;fill:red;fill-opacity:0.5" />
          <rect id="show_reader_c" width="40" height="40" style="stroke:gray;stroke-width:2;fill:red;fill-opacity:0.5" />
          <rect id="show_reader_d" width="40" height="40" style="stroke:gray;stroke-width:2;fill:red;fill-opacity:0.5" />

          <circle id="show_circle_a" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="show_circle_b" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="show_circle_c" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>
          <circle id="show_circle_d" style="stroke:black;stroke-width:50;fill:transparent;stroke-opacity:0.5"/>

          <line id="line_width" style="stroke:red;stroke-width:2" />
          <line id="line_height" style="stroke:red;stroke-width:2" />
          <g id="arrow_up" transform="translate(0,0)" height="10" width="10" >
            <path d="m 5 0 L 0 10 h 10 z" style="fill:red"/>
          </g>
          <g id="arrow_down" transform="translate(0,0)" height="10" width="10" >
            <path d="m 5 10 L 0 0 h 10 z" style="fill:red"/>
          </g>
          <g id="arrow_left" transform="translate(0,0)" height="10" width="10" >
            <path d="m 0 5 L 10 0 v 10 z" style="fill:red"/>
          </g>
          <g id="arrow_right" transform="translate(0,0)" height="10" width="10" >
            <path d="m 10 5 L 0 0 v 10 z" style="fill:red"/>
          </g>
          <text id="label_width" style="font-size:16px;text-anchor:middle">m</text>
          <text id="label_height" style="font-size:16px;text-anchor:middle">m</text>

          <text id="label_reader_a" style="font-size:16px;text-anchor:middle">A</text>
          <text id="label_reader_b" style="font-size:16px;text-anchor:middle">B</text>
          <text id="label_reader_c" style="font-size:16px;text-anchor:middle">C</text>
          <text id="label_reader_d" style="font-size:16px;text-anchor:middle">D</text>

          <text id="label_a" x="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">A</text>
          <text id="label_b" x="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">B</text>
          <text id="label_c" x="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">C</text>
          <text id="label_d" x="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">D</text>
          <text id="label_1" y="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">1</text>
          <text id="label_2" y="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">2</text>
          <text id="label_3" y="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">3</text>
          <text id="label_4" y="25" style="stroke:blue;stroke-width:1;fill:white;font-size:30px;text-anchor:middle">4</text>

          <rect id="target_area" style="fill:yellow;fill-opacity:0.5"/>
          <text id="label_target" style="stroke:black;stroke-width:1;fill:white;font-size:50px;text-anchor:middle">?</text>
        </svg>
      </div>
    </div>
    </main>
  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/api_book_track.js') }}"></script>
</body>
</html>


