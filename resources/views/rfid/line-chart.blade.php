@extends('layouts.app')

@section('content')


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
<script type="text/javascript">
        var resultRadiusA = @json($resultRadiusA ?? '');   
        var resultRadiusB = @json($resultRadiusB ?? ''); 
        var resultRadiusC = @json($resultRadiusC ?? ''); 
        var resultRadiusD = @json($resultRadiusD ?? ''); 
       
        //document.write(resultRadiusB+"\n"); //radius
        // for(var i = 1; i < resultRadiusA.length; i++) {
        //     var resultRadiusa = resultRadiusA[i];
        //     for(var j = 0; j < resultRadiusa.length; j++) {
        //         //alert("resultRadiusa[" + i + "][" + j + "] = " + resultRadiusa[0]);
        //         //document.write(resultRadiusa[0]+"\n"); //second
        //         document.write(resultRadiusa[1]+"\n"); //radius
        //     }
        // }

        console.log(resultRadiusA);
        console.log(resultRadiusB);
        console.log(resultRadiusC);
        console.log(resultRadiusD);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChartRadius);
        function drawChartRadius() {
                // var data = google.visualization.arrayToDataTable(resultRadiusA);
                var dataArray = [['Second','Reader A','Reader B','Reader C','Reader D']];
                for(var i = 1; i < resultRadiusA.length; i++) {
                    var resultRadiusa = resultRadiusA[i];
                    var resultRadiusb = resultRadiusB[i];
                    var resultRadiusc = resultRadiusC[i];
                    var resultRadiusd = resultRadiusD[i];
                    for(var j = 0; j < resultRadiusa.length; j++) {
                         dataArray.push([resultRadiusa[0],resultRadiusa[1],resultRadiusb[1],resultRadiusc[1],resultRadiusd[1]]);
                    }
                }
                var data = new google.visualization.arrayToDataTable(dataArray);
        
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
                'height':250,
               
                
                // backgroundColor: '#FFFFFF',
                curveType: 'function',
                legend: { position: 'right' }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('linechartRadius'));
                chart.draw(data, options);        
        }
        //This is blank chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(tmp);
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


      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChartB);
      google.charts.setOnLoadCallback(drawChartD);
      google.charts.setOnLoadCallback(drawChartC);

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
                }, 
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                    minValue: 0,
                }, 
            titleTextStyle: {
                color: 'blue'
            },           
            title: 'Reader A',
            'height':300,            
            colors: ['blue'],
            // backgroundColor: '#949494',
            curveType: 'function',
            legend: { position: 'bottom' }
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
                },
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                }, 
            titleTextStyle: {
                color: 'red'
            },         
            title: 'Reader B',
            'height':300,
            colors: ['red'],
            curveType: 'function',
            legend: { position: 'bottom' }
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
                },
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                }, 
            titleTextStyle: {
                color: '#FF903F'
            }, 
            title: 'Reader C',
            'height':300,
            colors: ['#FF903F'],
            curveType: 'function',
            legend: { position: 'bottom' }
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
                },
                hAxis: {
                    title: 'Time (second)',
                    maxValue: 60,
                }, 
            titleTextStyle: {
                color: '#00DB42'
            },     
            title: 'Reader D',
            'height':300,
            colors: ['#00DB42'],
            curveType: 'function',
            legend: { position: 'bottom' }
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

</script>
<style>
    div.hidden {
        display: none;
    }
</style>
        <!-- Search field -->
        <form action="" method="get">
                    @csrf
                <div class="form-group row justify-content-center pt-3">
                        @if($flag==null && $recordA==null && $recordB==null && $recordC==null && $recordD==null)
                        <button type="button" class="btn btn-link"  style="padding-left:20px"onclick="hideTagTable()">
                               <h3>Show All Rfid Tags</h3>
                        </button>
                        @endif
                        <div class="col-md-1 d-none d-md-block">                           
                            <img src="/icon/search.svg" height="30px" align="right">
                        </div>
                        <div class="col-md-2 col-sm-8">
                            <select id="search_field" class="form-control custom-select custom-select-lg mb-3" name="search_field">
                                <option value="all" selected>All Reader</option>
                                <option value="reader_a">Reader A</option>
                                <option value="reader_b">Reader B</option>     
                                <option value="reader_c">Reader C</option>     
                                <option value="reader_d">Reader D</option>                                                   
                            </select>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <input id="search_content" type="text" class="form-control" name="search_content" value="{{ old('search_content') }}" placeholder="Search" autocomplete="search_content" autofocus>
                        </div>
                        <div class="col-md-1 col-sm-12 mt-3 mt-md-0 text-md-left text-right">
                            <button type="submit" class="btn btn-success btn-lg">
                                <strong>Search</strong>
                            </button>
                        </div>
                </div>
        </form>

        
        
        <!-- The all tags -->
                <div id="RfidTagTable" class="hidden col-md-4 col-sm-5" style="display: none;">
                    @if($count ?? ''!=null)
                    <div class="text-center ">
                        <h1>All RFID Tags</h1>
                        <p>Total Tag Number: {{$count ?? ''}}</p>
                        <div class="table-responsive"> 
                        <div class="res" style="color:MediumSeaGreen;"></div>          
                            <table class="table table-light table-hover" style="backgroud-color:#000000">           
                                <tbody>        
                                    @foreach ($rfids as $key)
                                    <tr id= "c">            
                                        <td >{{$key->tag_id}}</td>                                                
                                        <td>                                        
                                            <button style="background: transparent;border: none;" onclick="copyToClipboard('#c')">
                                            <img src="/icon/copy.png" height="20px" align="right">
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    @endif 
                </div>
            <!-- The alert message -->
            @if($recordA != null)
                @if(count($recordA) == 1)
                    <div class="alert alert-warning alert-dismissible" style="width:30%;">
                    <strong>Warning!</strong> The ReaderA cannot found the record.
                    </div>    
                @endif
            @endif
            @if($recordB != null)
                @if(count($recordB) == 1)
                    <div class="alert alert-warning alert-dismissible" style="width:30%;">
                    <strong>Warning!</strong> The ReaderB cannot found the record.
                    </div>
                @endif
            @endif
            @if($recordC != null)
                @if(count($recordC) == 1)
                    <div class="alert alert-warning alert-dismissible" style="width:30%;">
                    <strong>Warning!</strong> The ReaderC cannot found the record.
                    </div>
                @endif
            @endif
            @if($recordD != null)
                @if(count($recordD) == 1)
                    <div class="alert alert-warning alert-dismissible" style="width:30%;">
                    <strong>Warning!</strong> The ReaderD cannot found the record.
                    </div>
                @endif
            @endif
            @if($flag == null) 
                <h1 align="center" style="color:#0062AF"><strong>The Result of Radius</strong></h1>
                <h3 align="center" style="color:#3A74A1">Note: Input the Tag ID for Testing</h3>
                <div  id="tmp"></div>
            @endif
            @if($flag != null)    
                <h1 align="center" style="color:#0062AF"><strong>The Result of Radius</strong></h1>           
                <div  id="linechartRadius"></div>
                <h1 align="center" style="color:#0062AF"><strong>The Rssi Testing</strong></h1>
            @endif
             <!-- The Rssi Testing -->
            <div class="row">
                
                @if($recordA != null)
                    @if(count($recordA) != 1)
                        @if($flag == null)
                            <div id="linechartA" style="width: 1500px; height: 1200px"></div>
                            @else
                            <div class="col-md-6" id="linechartA"></div>
                        @endif
                    @endif
                @endif

                @if($recordB != null)  
                    @if(count($recordB) != 1)
                        @if($flag == null)
                            <div id="linechartB" style="width: 1500px; height: 1200px"></div>
                        @else
                            <div class="col-md-6" id="linechartB"></div>
                        @endif
                    @endif
                @endif

                @if($recordC != null)  
                    @if(count($recordC) != 1)        
                        @if($flag == null)
                            <div id="linechartC" style="width: 1500px; height: 1200px"></div>
                        @else
                            <div class="col-md-6" id="linechartC" ></div>
                        @endif
                    @endif
                @endif

                @if($recordD != null)  
                    @if(count($recordD) != 1)
                        @if($flag == null)
                            <div id="linechartD" style="width: 1500px; height: 1200px"></div>
                        @else
                            <div class="col-md-6" id="linechartD"></div>
                        @endif
                    @endif
                @endif
            </div>

             <!-- The Radius line-chart -->
           

@endsection

