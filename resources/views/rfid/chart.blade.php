@extends('layouts.app')

@section('content')

<style>
    div.hidden {
        display: none;
    }
</style>
        <!-- Search field -->
        <form action="" method="get">
                    @csrf
                <div class="form-group row justify-content-center pt-3">
                        <!-- @if($flag==null && $recordA==null && $recordB==null && $recordC==null && $recordD==null)
                        <button type="button" class="btn btn-link"  style="padding-left:20px"onclick="hideTagTable()">
                               <h3>All Rfid Tags</h3>
                        </button>
                        @endif -->
                        
                    

                        <div class="col-md-2">  
                            <h3 style="color:#3A74A1; padding-left:20px;"><strong>Total Tag Number: {{$count ?? ''}}</strong></h3>   
                        </div>       
                       
                        <strong style="color:#0062AF">Reader:</strong>               
                        <div class="col-md-1 col-sm-8">
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
                                <option value="onehour">60 mins</option>                                                   
                            </select>
                        </div>                                      
                        <strong style="color:#0062AF">Tag ID:</strong> 
                        <div class="col-md-4 col-sm-8">                       
                            <select id="search_tag" style="height:28px;" class="form-control custom-select custom-select-lg mb-3" name="search_tag">                      
                                @if($count ?? '' != null)
                                    @foreach ($rfids ?? '' as $key)
                                        <option value="{{$key->tag_id}}">{{$key->tag_id}}: {{$key->title}}</option>
                                    @endforeach
                                @endif                                                
                            </select>
                            <!-- <input id="search_content" type="text" class="form-control" name="search_content" value="{{ old('search_content') }}" placeholder="Search" required autocomplete="search_content" autofocus> -->
                        </div>
                        <div class="col-md-2 col-sm-8 text-md-left text-right">
                            <button type="submit" class="btn btn-info btn-lg">
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
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="color:#7d7c7c;" align="center"><strong>{{$BookName ?? ''}}</strong></h2>
                    </div> 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>{{$curTagID ?? ''}}</strong></h3>
                    </div> 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>Timeframe: {{$timeframeSimple ?? ''}}<strong></h3> 
                    </div>
                </div>      
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
                <div class="row">
                    <h1 class="col-md-12" align="center" style="color:#0062AF"><strong>The Result of Radius</strong></h1>
                    <div class="col-md-12">
                        <h2 style="color:#7d7c7c;" align="center"><strong>{{$BookName ?? ''}}</strong></h2>
                    </div>                 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>{{$curTagID ?? ''}}</strong></h3>
                    </div> 
                    <div class="col-md-12">
                        <h3 style="color:#7d7c7c;" align="center"><strong>Timeframe: {{$timeframeSimple ?? ''}}</strong></h3> 
                    </div>
                </div>              
                <div  id="linechartRadius"></div>
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
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Most: {{$FrequentofResultA}}</p></tr>                                                                                                                 
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
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Most: {{$FrequentofResultB}}</p></tr>                                                                                                                 
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
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Most: {{$FrequentofResultC}}</p></tr>                                                                                                                 
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
                                    <tr class="col"><p style="color:#8a8a8a;" align=center>Most: {{$FrequentofResultD}}</p></tr>                                                                                                                 
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
        var RadiusofMeanA = @json($RadiusofMeanA ?? '');
        var RadiusofMedianA = @json($RadiusofMedianA ?? '');
        var RadiusofMostA = @json($RadiusofMostA ?? '');
        var RadiusofLinearRegressionValueA = @json($RadiusofLinearRegressionValueA ?? '');

        var RadiusofMeanB = @json($RadiusofMeanB ?? '');
        var RadiusofMedianB = @json($RadiusofMedianB ?? '');
        var RadiusofMostB = @json($RadiusofMostB ?? '');
        var RadiusofLinearRegressionValueB = @json($RadiusofLinearRegressionValueB ?? '');

        var RadiusofMeanC = @json($RadiusofMeanC ?? '');
        var RadiusofMedianC = @json($RadiusofMedianC ?? '');
        var RadiusofMostC = @json($RadiusofMostC ?? '');
        var RadiusofLinearRegressionValueC = @json($RadiusofLinearRegressionValueC ?? '');

        var RadiusofMeanD = @json($RadiusofMeanD ?? '');
        var RadiusofMedianD = @json($RadiusofMedianD ?? '');
        var RadiusofMostD = @json($RadiusofMostD ?? '');
        var RadiusofLinearRegressionValueD = @json($RadiusofLinearRegressionValueD ?? '');
       
        // for(var i = 1; i < resultRadiusA.length; i++) {
        //     var resultRadiusa = resultRadiusA[i];
        //     for(var j = 0; j < resultRadiusa.length; j++) {
        //         //alert("resultRadiusa[" + i + "][" + j + "] = " + resultRadiusa[0]);
        //         //document.write(resultRadiusa[0]+"\n"); //second
        //         document.write(resultRadiusa[1]+"\n"); //radius
        //     }
        // }

        // console.log(resultRadiusA);
        // console.log(resultRadiusB);
        // console.log(resultRadiusC);
        // console.log(resultRadiusD);

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChartRadius);
        google.charts.setOnLoadCallback(tmp);
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChartB);
        google.charts.setOnLoadCallback(drawChartD);
        google.charts.setOnLoadCallback(drawChartC);
        google.charts.setOnLoadCallback(drawChartRadiusA);
        google.charts.setOnLoadCallback(drawChartRadiusB);
        google.charts.setOnLoadCallback(drawChartRadiusC);
        google.charts.setOnLoadCallback(drawChartRadiusD);


        function drawChartRadius() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                // if(count(resultRadiusC) == 1){
                //     // var dataArray = [['Second','Reader A','Reader B','Reader C','Reader D']];
                //     var dataArray = [['Second','Reader A','Reader B','Reader D']];
                //     for(var i = 1; i < resultRadiusA.length; i++) {
                //         var resultRadiusa = resultRadiusA[i];
                //         var resultRadiusb = resultRadiusB[i];                    
                //         var resultRadiusd = resultRadiusD[i];
                //         for(var j = 0; j < resultRadiusa.length; j++) {
                //             dataArray.push([resultRadiusa[0],resultRadiusa[1],resultRadiusb[1],resultRadiusd[1]]);
                //         }
                //     }                   
                // }

                // var dataArray = [['Second','Reader A','Reader B','Reader C','Reader D']];
                // for(var i = 1; i < resultRadiusA.length; i++) {
                //     dataArray.push([resultRadiusA[i][0],resultRadiusA[i][1],resultRadiusB[i][1],resultRadiusC[i][1],resultRadiusD[i][1]]);
                // }

                // var data = new google.visualization.arrayToDataTable(dataArray);

                var data = google.visualization.arrayToDataTable([                   
                    ['Radius','Mean','Median','Most','Linear Regression'],
                    ['Reader A', RadiusofMeanA, RadiusofMedianA, RadiusofMostA, RadiusofLinearRegressionValueA],            // RGB value
                    ['Reader B', RadiusofMeanB, RadiusofMedianB, RadiusofMostB, RadiusofLinearRegressionValueB],            // English color name
                    ['Reader C', RadiusofMeanC, RadiusofMedianC, RadiusofMostC, RadiusofLinearRegressionValueC],
                    ['Reader D', RadiusofMeanD, RadiusofMedianD, RadiusofMostD, RadiusofLinearRegressionValueD], 
                ]);
        
                var options = {        
                    vAxis: {
                        title: 'Radius (m)'
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                    },
                    titleTextStyle: {
                        color: '#3A74A1'
                    },              
                title: 'Radius Result',
                'height':300,
                               
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right',
                        textStyle: {
                            color: 'silver',
                        } 
                    }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('linechartRadius'));
                chart.draw(data, options);        
        }
        //ReaderA Radius Result

        function drawChartRadiusA() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                //var dataArray = [['Second','Reader A']];
                // for(var i = 1; i < resultRadiusA.length; i++) {                     
                //     dataArray.push([resultRadiusA[i][0],resultRadiusA[i][1]]);                  
                // }
                var data = google.visualization.arrayToDataTable([
                    ['Reader A', 'Radius', { role: 'style' }],
                    ['Mean',RadiusofMeanA, '#b87333'],            // RGB value
                    ['Median',RadiusofMedianA, 'silver'],            // English color name
                    ['Most',RadiusofMostA, 'gold'],
                    ['Linear Regression',RadiusofLinearRegressionValueA, 'color: #e5e4e2' ], // CSS-style declaration
                ]);

                //var data = new google.visualization.arrayToDataTable(dataArray);
        
                var options = {        
                    vAxis: {
                        title: 'Radius (m)'
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                    },
                    titleTextStyle: {
                        color: '#3A74A1'
                    },              
                title: 'Reader A Radius Result',
                'height':250,
                               
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('ColumnChartRadiusA'));
                chart.draw(data, options);        
        }

        function drawChartRadiusB() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                // var dataArray = [['Second','Reader B']];
                // for(var i = 1; i < resultRadiusB.length; i++) {                    
                //     dataArray.push([resultRadiusB[i][0],resultRadiusB[i][1]]);                        
                // }
                // var data = new google.visualization.arrayToDataTable(dataArray);
                var data = google.visualization.arrayToDataTable([
                    ['Reader B', 'Radius', { role: 'style' }],
                    ['Mean',RadiusofMeanB, '#b87333'],            // RGB value
                    ['Median',RadiusofMedianB, 'silver'],            // English color name
                    ['Most',RadiusofMostB, 'gold'],
                    ['Linear Regression',RadiusofLinearRegressionValueB, 'color: #e5e4e2' ], // CSS-style declaration
                ]);
        
                var options = {        
                    vAxis: {
                        title: 'Radius (m)'
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                    },
                    titleTextStyle: {
                        color: 'red'
                    },              
                title: 'Reader B Radius Result',
                'height':250,
                colors: ['red'],                               
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('ColumnChartRadiusB'));
                chart.draw(data, options);        
        }

        function drawChartRadiusC() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                // var dataArray = [['Second','Reader C']];
                // for(var i = 1; i < resultRadiusC.length; i++) {                   
                //     dataArray.push([resultRadiusC[i][0],resultRadiusC[i][1]]);
                // }
                // var data = new google.visualization.arrayToDataTable(dataArray);

                var data = google.visualization.arrayToDataTable([
                    ['Reader C', 'Radius', { role: 'style' }],
                    ['Mean',RadiusofMeanC, '#b87333'],            // RGB value
                    ['Median',RadiusofMedianC, 'silver'],            // English color name
                    ['Most',RadiusofMostC, 'gold'],
                    ['Linear Regression',RadiusofLinearRegressionValueC, 'color: #e5e4e2' ], // CSS-style declaration
                ]);
        
                var options = {        
                    vAxis: {
                        title: 'Radius (m)'
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                    },
                    titleTextStyle: {
                        color: '#FF903F'
                    },              
                title: 'Reader C Radius Result',
                'height':250,
                colors: ['#FF903F'],                               
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('ColumnChartRadiusC'));
                chart.draw(data, options);        
        }

        function drawChartRadiusD() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                // var dataArray = [['Second','Reader D']];
                // for(var i = 1; i < resultRadiusD.length; i++) {
                //     dataArray.push([resultRadiusD[i][0],resultRadiusD[i][1]]);                   
                // }
                // var data = new google.visualization.arrayToDataTable(dataArray);

                var data = google.visualization.arrayToDataTable([
                    ['Reader D', 'Radius', { role: 'style' }],
                    ['Mean',RadiusofMeanD, '#b87333'],            // RGB value
                    ['Median',RadiusofMedianD, 'silver'],            // English color name
                    ['Most',RadiusofMostD, 'gold'],
                    ['Linear Regression',RadiusofLinearRegressionValueD, 'color: #e5e4e2' ], // CSS-style declaration
                ]);
        
                var options = {        
                    vAxis: {
                        title: 'Radius (m)'
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                    },
                    titleTextStyle: {
                        color: '#00DB42'
                    },              
                title: 'Reader D Radius Result',
                'height':250,
                colors: ['#00DB42'],                               
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('ColumnChartRadiusD'));
                chart.draw(data, options);        
        }
        
        //This is blank chart      
        function tmp() {               
                
                var dataArray = [['Second','Reader A','Reader B','Reader C','Reader D']];
                for(var i = 1; i <=60; i++) {                   
                    dataArray.push([i,0,0,0,0]);
                }
                data = google.visualization.arrayToDataTable(dataArray);
                var options = {        
                    vAxis: {
                        title: 'Radius (m)',
                        maxValue: -40,
                    }, 
                    hAxis: {
                        title: 'Time (second)',
                        maxValue: 60,
                        viewWindow: {
                        min:0
                        },
                    },
                    titleTextStyle: {
                        color: '#048FFB'
                    },              
                title: 'Radius Result',
                'height':300,                
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('tmp'));
                chart.draw(data, options);        
        }

    //   document.write(record[i][0]+":"+record[i][1]+","+"\n"); //radius
      var record = @json($recordA); 
      console.log(record);
      function drawChart() {
            // var jsonData = $.ajax({
            // url: "/rfid/line-chart"+$('#search_content').val(),
            // dataType:"POST",
            // data:$recordA;
            // async: false
            // }).responseText;
            
            var data = google.visualization.arrayToDataTable(record);
           
            var options = {        
                vAxis: {
                    title: 'Rssi (dbm)',
                    maxValue: -64,
                    minValue:-50,
                    viewWindow: {
                        max:-50,
                        min:-65
                    },
                }, 
                hAxis: {
                    title: 'Time (second)',
                    // maxValue: 60,
                    minValue: 0,
                    viewWindow: {
                        min:0
                    },
                }, 
            titleTextStyle: {
                color: 'blue'
            },           
            title: 'Reader A',
            'width':'auto',
            'height':300,            
            colors: ['blue'],
            
            // backgroundColor: '#949494',
            curveType: 'function',
            trendlines: { 0: {
                type: 'linear',
                showR2: true,
                visibleInLegend: true,
            } },    // Draw a trendline for data series 0.
            legend: { position: 'right' }
            };
            var chart = new google.visualization.ScatterChart(document.getElementById('linechartA'));
            chart.draw(data, options);        
      }

    //   $(document).ready(function(){
    //     setInterval("drawChartB()", 1000);
    //   });


      var recordB = @json($recordB); 
      console.log(recordB);   

       
      function drawChartB() {
            var data = google.visualization.arrayToDataTable(recordB);
            var options = {        
                vAxis: {
                    title: 'Rssi (dbm)',
                    maxValue: -64,
                    viewWindow: {
                        max:-50,
                        min:-65
                    },
                },
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                    viewWindow: {
                        min:0
                    },
                }, 
            titleTextStyle: {
                color: 'red'
            },         
            title: 'Reader B',
            'height':300,
            colors: ['red'],
            curveType: 'function',
            trendlines: { 0: {
                //labelInLegend: 'Test line',

                type: 'linear',
                showR2: true,
                visibleInLegend: true,
            } },    // Draw a trendline for data series 0.
            legend: { position: 'right' }
            };
            var chart = new google.visualization.ScatterChart(document.getElementById('linechartB'));
            chart.draw(data, options);
      }     

      var recordC = @json($recordC); 
      console.log(recordC);
      function drawChartC() {
            var data = google.visualization.arrayToDataTable(recordC);
            var options = {        
                vAxis: {
                    title: 'Rssi (dbm)',
                    maxValue: -64,
                    viewWindow: {
                        max:-50,
                        min:-65
                    },
                },
                hAxis: {
                    title: 'Time (second)',
                    viewWindow: {
                        min:0
                    },
                    maxValue: 60,
                }, 
            titleTextStyle: {
                color: '#FF903F'
            }, 
            title: 'Reader C',
            'height':300,
            colors: ['#FF903F'],
            curveType: 'function',
            trendlines: { 0: {
                type: 'linear',
                showR2: true,
                visibleInLegend: true,
            } },    // Draw a trendline for data series 0.
            legend: { position: 'right' }
            };
            var chart = new google.visualization.ScatterChart(document.getElementById('linechartC'));
            chart.draw(data, options);
      }
      
      var recordD = @json($recordD); 
      console.log(recordD);
      function drawChartD() {
            var data = google.visualization.arrayToDataTable(recordD);
            var options = {        
                vAxis: {
                    title: 'Rssi (dbm)',
                    maxValue: -64,
                    viewWindow: {
                        max:-50,
                        min:-65
                    },
                },
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                    viewWindow: {
                        min:0
                    },
                }, 
            titleTextStyle: {
                color: '#00DB42'
            },     
            title: 'Reader D',
            'height':300,
            colors: ['#00DB42'],
            
            curveType: 'function',
            trendlines: { 0: {
                type: 'linear',
                showR2: true,
                visibleInLegend: true,
            } },    // Draw a trendline for data series 0.
            legend: { position: 'right' }
            };
            var chart = new google.visualization.ScatterChart(document.getElementById('linechartD'));
            chart.draw(data, options);
      }
      
      function hideTagTable() {       
            var x = document.getElementById("RfidTagTable");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
      } 
      
      function copyToClipboard(element) {       
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            var successful = document.execCommand("copy");
            if(successful) {
                $('.res').html("Coppied");           
            }
            setTimeout(function () {
                $('.res').hide();
            }, 1000);     
            $temp.remove();        
      }

      function count() {
             var record = @json($recordD); 
             var RssiList = [];
             var sum = 0;
             var mean = 0;
             for(var i = 1 ; i<record.length; i++){               
                RssiList[i]=record[i][1].toString(); 
                sum += record[i][1];                     
             }
            mean = sum/record.length;
            RssiList.sort();
            var current = null;
            var count = 0;
            for (var i = 0; i < RssiList.length; i++) {
                if (RssiList[i] != current) {
                    if (count > 0) {
                        // document.write(current + ': ' + count + ' times<br>');
                        document.getElementById('countResult').innerHTML += current+': '+ count + ' times<br>';
                    }
                    current = RssiList[i];
                    count = 1;
                } 
                else {
                    count++;
                }
            }
            document.getElementById('countResult').innerHTML += 'Sum of Rssi: '+ sum + ' dbm<br>';
            document.getElementById('countResult').innerHTML += 'Mean of Rssi:'+ mean + ' dbm<br>';
    }

</script>           

@endsection

