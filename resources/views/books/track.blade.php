@extends('layouts.app')

@section('content')
<script type="application/javascript">
  var records = @json($records);
  var width = {{json_encode($width)}};
  var height = {{json_encode($height)}};  
</script>


<div class="container">
    <div class="row">
        <div class="col-8">
            <div id="spinner" class="spinner-border" style="height:100px;width:100px"></div>
            <div id="div_svg" style="display:none">
            <!-- <img src="/img/map.png" class="border" height="600px" weight="600px"> -->
            <svg width="600px" height="600px" onload="load()"
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
              <pattern id="background_pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="20" height="20" style="fill:transparent;stroke:gray; stroke-width:1;"/>
                <!-- <g>
                  <line x1="0" y1="20" x2="40" y2="20" style="stroke:gray;stroke-width:1" />
                  <line x1="20" y1="0" x2="20" y2="40" style="stroke:gray;stroke-width:1" />
                </g> -->
              </pattern>
            </defs>
              <rect width="100%" height="100%" style="fill:url(#background_pattern);stroke:orange;stroke-width:4" />
              <rect id="reader_a" x="110" y="110" width="100" height="50"
                style="fill:red;stroke:black;stroke-width:2;opacity:0.5" />
              <rect id="reader_b" width="100" height="50"
                  style="fill:red;stroke:black;stroke-width:2;opacity:0.5" />
              <rect id="reader_c" width="100" height="50"
                style="fill:red;stroke:black;stroke-width:2;opacity:0.5" />
              <rect id="reader_d" width="100" height="50"
                style="fill:red;stroke:black;stroke-width:2;opacity:0.5" />
              <circle id="circle_a" style="stroke-width:2;stroke:red;fill:red;fill-opacity:0.1"/>
              <circle id="circle_b" style="stroke-width:2;stroke:blue;fill:blue;fill-opacity:0.1"/>
              <circle id="circle_c" style="stroke-width:2;stroke:green;fill:green;fill-opacity:0.1"/>
              <circle id="circle_d" style="stroke-width:2;stroke:yellow;fill:yellow;fill-opacity:0.1"/>
              <line id="line_ab" style="stroke:black;stroke-width:2" />
              <line id="line_bc" style="stroke:black;stroke-width:2" />
              <line id="line_cd" style="stroke:black;stroke-width:2" />
              <line id="line_ad" style="stroke:black;stroke-width:2" />
              <text id="label_ab" style="font-size:16px;text-anchor:middle">m</text>
              <text id="label_bc" style="font-size:16px;text-anchor:middle">m</text>
              <text id="label_cd" style="font-size:16px;text-anchor:middle">m</text>
              <text id="label_ad" style="font-size:16px;text-anchor:middle">m</text>
            </svg>
            </div>            
        </div>
        <div id="book_list" class="col-4">
            <div class="border table-responsive" style="height:600px;overflow-y:scroll;">

                <h1 align="center">Books List</h1>                
                <table class="table table-hover">
                    <tbody id="trackTable">
                        @foreach ($books as $book)
                
                        <tr onclick=" trackTableChangeColor(this,'{{$book->id}}')">
                            <td width="30%">
                                @if($book->image)
                                <img src="/storage/{{ $book->image }}" weight="40" height="65" class="rounded mx-auto d-block border">
                                @else
                                <img src="/storage/uploads/default.png" weight="40" height="65" class="rounded mx-auto d-block border">
                                @endif
                            </td>
                            <td width="60%">
                                <h3 class="text-success"><strong>{{ $book->title }}</strong></h3>
                                <h5 style="color:#444444">Author: @if($book->author) {{ $book->author }} @else N/A @endif</h5>
                                <h5 style="color:#444444">Language: @if($book->language) {{$book->language }} @else N/A @endif</h5>
                            </td>
                            <td width="10%" class="align-middle">
                                <a href="{{ url('/b/detail/' . $book->id) }}" class="book-show-modal btn btn-info btn-lg">
                                <i class="glyphicon glyphicon-eye-open" style="backgroud-color:#FFFFFF"></i></a>
                            </td>
                        </tr>                        
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
