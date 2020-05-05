@extends('layouts.app')

@section('content')


        <!-- Search field -->
        <form action="" method="get">
                    @csrf
                <div class="form-group row justify-content-center pt-3">
                        <!-- @if($flag==null && $recordA==null && $recordB==null && $recordC==null && $recordD==null)
                        <button type="button" class="btn btn-link"  style="padding-left:20px"onclick="hideTagTable()">
                               <h3>All Rfid Tags</h3>
                        </button>
                        @endif -->                        

                        <div class="col-md-1">  
                            <h3 style="color:#3A74A1; padding-left:20px;"><strong>Tag: {{$count ?? ''}}</strong></h3>   
                        </div>       
                       
                        <strong style="color:#0062AF">Reader:</strong>               
                        <div class="col-md-1">
                            <select id="search_field" style="height:28px;" class="form-control custom-select custom-select-lg mb-3" name="search_field">
                                <option value="all">All</option>
                                <option value="reader_a">A</option>
                                <option value="reader_b">B</option>     
                                <option value="reader_c">C</option>     
                                <option value="reader_d">D</option>                                                   
                            </select>
                        </div>
                        <strong style="color:#0062AF">Timeframes:</strong> 
                        <div class="col-md-1 col-sm-8">
                           <select id="time_field" style="height:28px;" class="form-control custom-select custom-select-lg mb-3" name="time_field">
                                <option value="oneMins">1 mins</option>
                                <option value="fiveMins">5 mins</option>
                                <option value="fifteenMins">15 mins</option>     
                                <option value="halfhour">30 mins</option>     
                                <!-- <option value="onehour">60 mins</option>                                                    -->
                            </select>
                        </div>                                      
                        <strong style="color:#0062AF">Tag ID:</strong> 
                        <div class="col-md-5 col-sm-8">                       
                            <select id="search_tag" style="height:28px;" class="form-control custom-select custom-select-lg mb-3" name="search_tag">                      
                                @if($count ?? '' != null)
                                    @foreach ($rfids ?? '' as $key)
                                        <option value="{{$key->tag_id}}">{{$key->tag_id}}({{$key->id}}): {{$key->title}}</option>
                                    @endforeach
                                @endif                                                
                            </select>
                            <!-- <input id="search_content" type="text" class="form-control" name="search_content" value="{{ old('search_content') }}" placeholder="Search" required autocomplete="search_content" autofocus> -->
                        </div>
                        <div class="col-md-2 col-sm-8 text-md-left text-right">
                            <button id="start" type="submit" class="btn btn-primary btn-lg" style="border-radius: 15px;">
                            <span style="color:#FFFFFF" class="glyphicon glyphicon-search"></span><strong style="color:#FFFFFF"> Search</strong>
                            </button>
                        </div>
                        
                </div>
        </form>
        
        <!-- The all tags Number -->
        <!-- <div id="RfidTagTable" class="hidden col-md-4 col-sm-5" style="display: none;">
             curTagID
timeframe
        </div>        -->
       
            </div>                
            <!-- Each Reader Radius Testing -->
            @if($flag == null)
                <h1 align="center" style="color:#0062AF"><strong>The Result of Radius</strong></h1>          
                @if($showEmptyChart)
                <h3 align="center" style="color:#3A74A1">Note: Input the Tag ID for Testing</h3> 
                <div  id="tmp"></div>               
                @endif  
                @if($showEmptyChart==false) 
                <div class="row">                    
                    <div class="col-md-12">
                        <h2 style="color:#7d7c7c;" align="center"><strong>{{$BookID ?? ''}}: {{$BookName ?? ''}}</strong></h2>
                    </div>                    
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>{{$curTagID ?? ''}}</strong></h3>
                    </div> 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>Timeframe: {{$timeframeSimple ?? ''}}<strong></h3> 
                    </div>
                </div>  
                @endif      
                @if($recordA ?? '' != null)
                    @if(count($recordA ?? '') != 1)                       
                        <div  id="ColumnChartRadiusA"></div>
                        @else
                        <div  id="tmp"></div> 
                    @endif
                @endif
                @if($recordB ?? '' != null)
                    @if(count($recordB ?? '') != 1)                     
                        <div  id="ColumnChartRadiusB"></div>
                    @endif
                @endif
                @if($recordC ?? '' != null)
                    @if(count($recordC ?? '') != 1)       
                        <div  id="ColumnChartRadiusC"></div>
                    @endif
                @endif
                @if($recordD ?? '' != null)
                    @if(count($recordD ?? '') != 1)    
                        <div  id="ColumnChartRadiusD"></div>
                    @endif
                @endif
            @endif
           
            <!-- The All Radius Testing -->
            @if($flag != null)
                @if($showEmptyChart == false)    
               
                <div class="row">
                    <h1 class="col-md-12" align="center" style="color:#0062AF"><strong>The Result of Radius</strong></h1>                     
                    <div class="col-md-12">
                        <h2 style="color:#7d7c7c;" align="center"><strong>{{$BookID ?? ''}}: {{$BookName ?? ''}}</strong></h2>
                    </div>                 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>{{$curTagID ?? ''}}</strong></h3>
                    </div> 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>Timeframe: {{$timeframeSimple ?? ''}}</strong></h3> 
                    </div>
                </div> 
                @endif
                  
        <div class="col-md-12" id="linechartRadius"></div>
        <!--hidqwdqw-->

        <div class="col-md-12" align="center">
          <div id="status"></div>
          <div id="spinner" class="spinner-border" style="height:100px;width:100px"></div>
          <p id="color"></p>
          <p id="raw_data"></p>
          <p id="result"></p>
          <p id="area"></p>
          <canvas id="can" width="600px" height="600px"></canvas>
          <img id="circImg" style="display:none"></img>
          <img id="display_img"></img>
          <div id="div_svg" style="display:none">
            <!-- <img src="/img/map.png" class="border" height="600px" weight="600px"> -->
            <svg id="svg_data" onload="onedraw()"
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

              <circle id="circle_a" style="stroke:black;stroke-width:40;fill:transparent;stroke-opacity:0.5"/>
              <circle id="circle_b" style="stroke:black;stroke-width:40;fill:transparent;stroke-opacity:0.5"/>
              <circle id="circle_c" style="stroke:black;stroke-width:40;fill:transparent;stroke-opacity:0.5"/>
              <circle id="circle_d" style="stroke:black;stroke-width:40;fill:transparent;stroke-opacity:0.5"/>

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
          </div>
               
              
                <table class="table table-bordered col-md-6" align="center" style="color:#7d7c7c">
                  
                    <tr>
                        
                        <td><strong>Reader</strong></td>
                        <td><strong>A</strong></td>
                        <td><strong>B</strong></td>
                        <td><strong>C</strong></td>
                        <td><strong>D</strong></td>
                        
                    </tr>
                    
                    <tr>
                        <td><strong>Mean (m)</strong></td>
                        @if($RadiusofMeanA == null)
                            <td>null</td>
                            @else
                            <td>{{$RadiusofMeanA}}</td>
                        @endif
                        <td>{{$RadiusofMeanB}}</td>
                        <td>{{$RadiusofMeanC}}</td>
                        <td>{{$RadiusofMeanD}}</td>
                    </tr>
                   
                    <tr>
                        <td><strong>Median (m)</strong></td>
                        @if($RadiusofMedianA == null)
                            <td>null</td>
                        @else
                            <td>{{$RadiusofMedianA}}</td>
                        @endif
                        <td>{{$RadiusofMedianB}}</td>
                        <td>{{$RadiusofMedianC}}</td>
                        <td>{{$RadiusofMedianD}}</td>
                    </tr>
                    <tr>
                        <td><strong>Mode (m)</strong></td>
                        @if($RadiusofMedianA == null)
                             <td>null</td>
                        @else
                            <td>{{$RadiusofMostA}}</td>
                        @endif
                        <td>{{$RadiusofMostB}}</td>
                        <td>{{$RadiusofMostC}}</td>
                        <td>{{$RadiusofMostD}}</td>
                    </tr>
                    <tr>
                        <td><strong>LinearRegression (m)</strong></td>
                        @if($RadiusofMedianA == null)
                        <td>null</td>
                        @else
                        <td>{{$RadiusofLinearRegressionValueA}}</td>
                        @endif
                        <td>{{$RadiusofLinearRegressionValueB}}</td>
                        <td>{{$RadiusofLinearRegressionValueC}}</td>
                        <td>{{$RadiusofLinearRegressionValueD}}</td>                                                                     
                    </tr>                    
                </table>
               
                <div class="col-md-12" align="center">               
                    <button  style="background: transparent;border: none;" title="show rssi to distance example" onclick="hideTagTable()">                   
                          <img src="/icon/example.png" height="30px">                          
                    </button>
                </div>
               
                <div id="RfidTagTable" class="hidden" style="display: none;">
                    <table class="table table-bordered col-md-2" align="center" style="color:#7d7c7c"> 
                        <td align="center"><strong>Rssi (dbm)</strong></td>     
                        <td align="center"><strong>Radius (m)</strong></td>              
                        @foreach(array_combine($RssiList['rssi'], $RssiList['radius']) as $k=>$a)
                        <tr>                         
                            <td align="center" style="color:#8a8a8a;">{{$k}}</td>                                                                                                                                    
                            <td align="center" style="color:#8a8a8a;">{{$a}}</td>            
                        </tr>
                        @endforeach                   
                    </table>
                </div>
               
              
                <!-- <h1 align="center" style="color:#0062AF"><strong>The Rssi Testing</strong></h1> -->
            @endif
             <!-- The Rssi Testing -->
            @if($showEmptyChart==false)            
                <h1 align="center" style="color:#0062AF"><strong>The Rssi Testing</strong></h1>
            @endif
             <!-- The alert message of rssi chart -->
             <div class="row justify-content-center">
             @if($recordA != null)
                @if(count($recordA) == 1)
                    <div class="alert col-md-6 alert-warning alert-dismissible">
                    <strong>Warning!</strong> The ReaderA cannot found the record.
                    </div>    
                @endif
            @endif
            @if($recordB != null)
                @if(count($recordB) == 1)
                    <div class="alert col-md-6 alert-warning alert-dismissible">
                    <strong>Warning!</strong> The ReaderB cannot found the record.
                    </div>
                @endif
            @endif
            @if($recordC != null)
                @if(count($recordC) == 1)
                    <div class="alert col-md-6 alert-warning alert-dismissible">
                    <strong>Warning!</strong> The ReaderC cannot found the record.
                    </div>
                @endif
            @endif
            @if($recordD != null)
                @if(count($recordD) == 1)
                    <div class="alert col-md-6 alert-warning alert-dismissible">
                    <strong>Warning!</strong> The ReaderD cannot found the record.
                    </div>
                @endif
            @endif    
            </div> 
            
            

            <div class="row justify-content-center">                
                @if($recordA != null)
                    @if(count($recordA) != 1)
                        @if($flag == null)                           
                            <div class="col-md-12" id="linechartA"></div>
                            <!-- Show Statistic of Reader A -->
                            <div class="col-md-12">
                                <h1 align=center style="color:#0062AF">Testing result of RSSI</h1>
                                <h3 align=center style="color:#8a8a8a;" ><strong>Duplicates Rssi:</strong></h3>  
                                <table>
                                    <tr class="col">                         
                                    @foreach(array_combine($CountofResultA['rssi'], $CountofResultA['num']) as $k=>$a)                                                                                                    
                                        <p style="color:#8a8a8a;" align=center>{{$k}}: {{$a}} times</p>                                                                                               
                                    @endforeach
                                    </tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mean: {{$MeanofResultA}}</p></tr>               
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Median: {{$medianA}}</p></tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mode: {{$FrequentofResultA}}</p></tr>                                                                                                                 
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Slope: {{$LinearRegressionA['slope']}}</p></tr>   
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Linear-Regression: {{$LinearRegressionA['intercept']}}</p></tr>                                                                                                                                                                                                                           
                                </table>                    
                            </div>                                                      
                            @else
                            <div class="col-md-6" id="linechartA"></div>
                        @endif                       
                    @endif
                @endif

                @if($recordB != null)  
                    @if(count($recordB) != 1)
                        @if($flag == null)                            
                            <div id="linechartB" class="col-md-12"></div>
                            <!-- Show Statistic of Reader B -->
                            <div class="col-md-12">
                                <h1 align=center style="color:#0062AF">Testing result of RSSI</h1>
                                <h3 align=center style="color:#8a8a8a;" ><strong>Duplicates Rssi:</strong></h3>  
                                <table>
                                    <tr class="col">                         
                                    @foreach(array_combine($CountofResultB['rssi'], $CountofResultB['num']) as $k=>$a)                                                                                                    
                                        <p style="color:#8a8a8a;" align=center>{{$k}}: {{$a}} times</p>                                                                                               
                                    @endforeach
                                    </tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mean: {{$MeanofResultB}}</p></tr>               
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Median: {{$medianB}}</p></tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mode: {{$FrequentofResultB}}</p></tr>                                                                                                                 
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Slope: {{$LinearRegressionB['slope']}}</p></tr>   
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Linear-Regression: {{$LinearRegressionB['intercept']}}</p></tr>                                                                                                                                                                                                                           
                                </table>                    
                            </div>             
                        @else
                            <div class="col-md-6" id="linechartB"></div>
                        @endif
                    @endif
                @endif

                @if($recordC != null)  
                    @if(count($recordC) != 1)        
                        @if($flag == null)                            
                            <div id="linechartC" class="col-md-12"></div>
                             <!-- Show Statistic of Reader C -->
                             <div class="col-md-12">
                                <h1 align=center style="color:#0062AF">Testing result of RSSI</h1>
                                <h3 align=center style="color:#8a8a8a;" ><strong>Duplicates Rssi:</strong></h3>  
                                <table>
                                    <tr class="col">                         
                                    @foreach(array_combine($CountofResultC['rssi'], $CountofResultC['num']) as $k=>$a)                                                                                                    
                                        <p style="color:#8a8a8a;" align=center>{{$k}}: {{$a}} times</p>                                                                                               
                                    @endforeach
                                    </tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mean: {{$MeanofResultC}}</p></tr>               
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Median: {{$medianC}}</p></tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mode: {{$FrequentofResultC}}</p></tr>                                                                                                                 
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Slope: {{$LinearRegressionC['slope']}}</p></tr>   
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Linear-Regression: {{$LinearRegressionC['intercept']}}</p></tr>                                                                                                                                                                                                                           
                                </table>                    
                            </div>       
                        @else
                            <div class="col-md-6" id="linechartC" ></div>
                        @endif
                    @endif
                @endif

                @if($recordD != null)  
                    @if(count($recordD) != 1)
                        @if($flag == null)                                                    
                            <div id="linechartD" class="col-md-12"></div>
                            <!-- Show Statistic of Reader D -->
                            <div class="col-md-12">
                                <h1 align=center style="color:#0062AF">Testing result of RSSI</h1>
                                <h3 align=center style="color:#8a8a8a;" ><strong>Duplicates Rssi:</strong></h3>  
                                <table>
                                    <tr class="col">                         
                                    @foreach(array_combine($CountofResultD['rssi'], $CountofResultD['num']) as $k=>$a)                                                                                                    
                                        <p style="color:#8a8a8a;" align=center>{{$k}}: {{$a}} times</p>                                                                                               
                                    @endforeach
                                    </tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mean: {{$MeanofResultD}}</p></tr>               
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Median: {{$medianD}}</p></tr>
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Mode: {{$FrequentofResultD}}</p></tr>                                                                                                                 
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Slope: {{$LinearRegressionD['slope']}}</p></tr>   
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Linear-Regression: {{$LinearRegressionD['intercept']}}</p></tr>                                                                                                                                                                                                                           
                                </table>                    
                            </div>       
                            
                        @else
                            <div class="col-md-6" id="linechartD"></div>
                        @endif
                    @endif
                @endif
            </div>
            
            
                      
                     
            <!-- <div align="right">
                <button class="btn btn-info btn-lg"  onclick="count()">
                    <strong style="color:#FFFFFF"> count</strong>
                </button>
            </div>
            <div align="center" id="countResult"></div> -->
<!-- The Radius line-chart -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
<script type="text/javascript">              
        // var resultRadiusA = @json($resultRadiusA ?? '');   
        // var resultRadiusB = @json($resultRadiusB ?? ''); 
        // var resultRadiusC = @json($resultRadiusC ?? ''); 
        // var resultRadiusD = @json($resultRadiusD ?? ''); 
        var widthData = {{json_encode($width)}};
        var heightData = {{json_encode($height)}};  
       
        var recordA = @json($recordA ?? '');
        var recordB = @json($recordB ?? '');
        var recordC = @json($recordC ?? '');
        var recordD = @json($recordD ?? '');
        var RadiusofMeanA;
        var RadiusofMedianA;
        var RadiusofMostA;
        var RadiusofLinearRegressionValueA;
       
       
        if(recordA.length == 1){           
            RadiusofMeanA = null;
            RadiusofMedianA = null;
            RadiusofMostA = null;
            RadiusofLinearRegressionValueA = null;
        }
        else{
            RadiusofMeanA = @json($RadiusofMeanA ?? '');
            RadiusofMedianA = @json($RadiusofMedianA ?? '');
            RadiusofMostA = @json($RadiusofMostA ?? '');
            RadiusofLinearRegressionValueA = @json($RadiusofLinearRegressionValueA ?? '');
        }

        var RadiusofMeanB;
        var RadiusofMedianB;
        var RadiusofMostB;
        var RadiusofLinearRegressionValueB;
       
        if(recordB.length == 1){
            RadiusofMeanB = null;
            RadiusofMedianB = null;
            RadiusofMostB = null;
            RadiusofLinearRegressionValueB = null;            
        }
        else{
            RadiusofMeanB = @json($RadiusofMeanB ?? '');
            RadiusofMedianB = @json($RadiusofMedianB ?? '');
            RadiusofMostB = @json($RadiusofMostB ?? '');
            RadiusofLinearRegressionValueB = @json($RadiusofLinearRegressionValueB ?? '');
        }   
        
        var RadiusofMeanC; 
        var RadiusofMedianC; 
        var RadiusofMostC; 
        var RadiusofLinearRegressionValueC;  
       

        if(recordC.length == 1){
             RadiusofMeanC = null; 
             RadiusofMedianC = null; 
             RadiusofMostC = null; 
             RadiusofLinearRegressionValueC = null;             
        }
        else{
             RadiusofMeanC = @json($RadiusofMeanC ?? '');
             RadiusofMedianC = @json($RadiusofMedianC ?? '');
             RadiusofMostC = @json($RadiusofMostC ?? '');
             RadiusofLinearRegressionValueC = @json($RadiusofLinearRegressionValueC ?? '');
        }     
        var RadiusofMeanD; 
        var RadiusofMedianD; 
        var RadiusofMostD; 
        var RadiusofLinearRegressionValueD;  

        if(recordD.length == 1){
            RadiusofMeanD = null;
            RadiusofMedianD = null;
            RadiusofMostD = null; 
            RadiusofLinearRegressionValueD = null;
        }
        else{
            RadiusofMeanD = @json($RadiusofMeanD ?? '');
            RadiusofMedianD = @json($RadiusofMedianD ?? '');
            RadiusofMostD = @json($RadiusofMostD ?? '');
            RadiusofLinearRegressionValueD = @json($RadiusofLinearRegressionValueD ?? '');           
        }      
       
        // for(var i = 1; i < resultRadiusA.length; i++) {
        //     var resultRadiusa = resultRadiusA[i];
        //     for(var j = 0; j < resultRadiusa.length; j++) {
        //         //alert("resultRadiusa[" + i + "][" + j + "] = " + resultRadiusa[0]);
        //         //document.write(resultRadiusa[0]+"\n"); //second
        //         document.write(resultRadiusa[1]+"\n"); //radius
        //     }
        // }      
        var showtmp = @json($showEmptyChart);
        var AllorOne = @json($flag);
        var readerChoice = @json($field ?? '');

       
           
</script>     
<style type="text/css">
    div.hidden {
        display: none;
    }
</style>      

@endsection

