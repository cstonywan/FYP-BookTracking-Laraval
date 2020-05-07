
var showtmp;
var AllorOne;
var readerChoice;
var ArrayLength = 10;


google.charts.load('current', {'packages':['corechart']});

if(showtmp){
        google.charts.setOnLoadCallback(tmp);
}
else{
    if(AllorOne == 'all'){
       
        google.charts.setOnLoadCallback(drawChartRadius); 
        
        if(recordA.length > ArrayLength){
            google.charts.setOnLoadCallback(drawChart);
        }      
        if(recordB.length > ArrayLength){
            google.charts.setOnLoadCallback(drawChartB);
        }
        if(recordC.length > ArrayLength){
            google.charts.setOnLoadCallback(drawChartC);
        }
        if(recordD.length > ArrayLength){
            google.charts.setOnLoadCallback(drawChartD);                
        }
    }
    else{
        if(readerChoice=='reader_a'){            
            if(recordA.length > ArrayLength){
                google.charts.setOnLoadCallback(drawChartRadiusA);
                google.charts.setOnLoadCallback(drawChart);
            } 
        }
        if(readerChoice=='reader_b'){            
            if(recordB.length > ArrayLength){
                google.charts.setOnLoadCallback(drawChartRadiusB);
                google.charts.setOnLoadCallback(drawChartB);
            }
        }
        if(readerChoice=='reader_c'){            
            if(recordC.length > ArrayLength){
                google.charts.setOnLoadCallback(drawChartRadiusC);
                google.charts.setOnLoadCallback(drawChartC);
            }
        }
        if(readerChoice=='reader_d'){           
            if(recordD.length > ArrayLength){
                google.charts.setOnLoadCallback(drawChartRadiusD);
                google.charts.setOnLoadCallback(drawChartD);
            }
        }           
    }                     
}

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
            ['Radius','Mean','Median','Mode','Linear Regression'],                   
            ['Reader A', RadiusofMeanA, RadiusofMedianA, RadiusofMostA, RadiusofLinearRegressionValueA],                               
            ['Reader B', RadiusofMeanB, RadiusofMedianB, RadiusofMostB, RadiusofLinearRegressionValueB],               
            ['Reader C', RadiusofMeanC, RadiusofMedianC, RadiusofMostC, RadiusofLinearRegressionValueC],
            ['Reader D', RadiusofMeanD, RadiusofMedianD, RadiusofMostD, RadiusofLinearRegressionValueD], 
        ]);
       

        var options = {        
            vAxis: {
                title: 'Radius (m)'
            }, 
            hAxis: {
                // title: 'Methonds',
                maxValue: 60,
            },
            titleTextStyle: {
                color: '#3A74A1'
            }, 
            // explorer: {
            //     maxZoomOut:1,
            //     keepInBounds: true
            // },             
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


function drawChart() {
   

    // var dataArray = [['Minute','Second','Reader A']];
    //     for(var i = 1; i < record.length; i++) {                   
    //        dataArray.push([record[i][0],record[i][1],record[i][2]]);
    //     }
    //     var data = new google.visualization.arrayToDataTable(dataArray);
  
   var data = google.visualization.arrayToDataTable(recordA);
   
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
            title: 'Record (count)',
            // title: 'Time (second)',
            maxValue: 60,
            minValue: 0,
            viewWindow: {
                min:0
            },                    
        },
        explorer: {                    
            axis: 'horizontal',
            maxZoomOut:1,
            keepInBounds: true
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


//   var recordB = @json($recordB); 
//   console.log(recordB);   


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
            title: 'Record (count)',
            // title: 'Time (second)',
            maxValue: 60,
            viewWindow: {
                min:0
            },
        }, 
    titleTextStyle: {
        color: 'red'
    },   
    explorer: {                   
            axis: 'horizontal',
            maxZoomOut:1,
            keepInBounds: true
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

//   var recordC = @json($recordC); 
//   console.log(recordC);
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
            title: 'Record (count)',
            // title: 'Time (second)',
            viewWindow: {
                min:0
            },
            maxValue: 60,
        }, 
    titleTextStyle: {
        color: '#FF903F'
    }, 
    explorer: {
            axis: 'horizontal',
            maxZoomOut:1,
            keepInBounds: true
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

//   var recordD = @json($recordD); 
//   console.log(recordD);
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
            title: 'Record (count)',
            // title: 'Time (second)',
            maxValue: 60,
            viewWindow: {
                min:0,                      
            },
        }, 
    explorer: {
        axis: 'horizontal',
        maxZoomOut:1,
        keepInBounds: true
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

// function count() {
//      var record = @json($recordD); 
//      var RssiList = [];
//      var sum = 0;
//      var mean = 0;
//      for(var i = 1 ; i<record.length; i++){               
//         RssiList[i]=record[i][1].toString(); 
//         sum += record[i][1];                     
//      }
//     mean = sum/record.length;
//     RssiList.sort();
//     var current = null;
//     var count = 0;
//     for (var i = 0; i < RssiList.length; i++) {
//         if (RssiList[i] != current) {
//             if (count > 0) {
//                 // document.write(current + ': ' + count + ' times<br>');
//                 document.getElementById('countResult').innerHTML += current+': '+ count + ' times<br>';
//             }
//             current = RssiList[i];
//             count = 1;
//         } 
//         else {
//             count++;
//         }
//     }
//     document.getElementById('countResult').innerHTML += 'Sum of Rssi: '+ sum + ' dbm<br>';
//     document.getElementById('countResult').innerHTML += 'Mean of Rssi:'+ mean + ' dbm<br>';
// }
$(window).on("load", onPageLoad);

function onPageLoad() {
    storeOption();
    restoreOption();
}

function storeOption() {

    $("#search_field").on("change", function() {
        var Readervalue = $(this).val();
        localStorage.setItem("search_field", Readervalue);
    });
    $("#time_field").on("change", function() {
        var Timeframe = $(this).val();
        localStorage.setItem("time_field", Timeframe);
    });
    $("#search_tag").on("change", function() {
        var TagIDvalue = $(this).val();
        localStorage.setItem("search_tag", TagIDvalue);
    });	

}

function restoreOption() {

    var storedReader = localStorage.getItem("search_field");
    var storedTimeframe = localStorage.getItem("time_field");
    var storedTagID = localStorage.getItem("search_tag");   

    $("#search_field").val(storedReader);
    $("#time_field").val(storedTimeframe);
    $("#search_tag").val(storedTagID);
}

$(document).ready(function() {
    $("#start").on('click', function() {       
        realTimePost();
        document.getElementById('start').style.display = 'none'; 
        document.getElementById('misstable').style.display = 'block';  
        document.getElementById('misshead').style.display = 'block';                      
    });
})

function realTimePost(){
    setTimeout(function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/rfid/postajax',
            type: 'POST',
            data: { input: localStorage.getItem("search_tag") },
            success: function (result) { 
                         
                realtimeChartRadius(result);                
                document.getElementById('rssia').innerHTML = result[0];
                document.getElementById('radiusa').innerHTML = result[1]; 
                document.getElementById('rssib').innerHTML = result[2];
                document.getElementById('radiusb').innerHTML = result[3]; 
                document.getElementById('rssic').innerHTML = result[4];
                document.getElementById('radiusc').innerHTML = result[5]; 
                document.getElementById('rssid').innerHTML = result[6];
                document.getElementById('radiusd').innerHTML = result[7];       
            },
            // error: function () {
            //     alert("error");
            // }
        });
        realTimePost();
    }, 500);
}


// function realTime() {
       
//     setTimeout(function () {
//         $.ajax({
//              type:"GET",
//              url:"/rfid/getajax",
//              success : function(response){
//                  alert(response);                                                                
//                 document.getElementById('rssia').innerHTML = response[0];
//                 document.getElementById('radiusa').innerHTML = response[1]; 
//                 document.getElementById('rssib').innerHTML = response[2];
//                 document.getElementById('radiusb').innerHTML = response[3]; 
//                 document.getElementById('rssic').innerHTML = response[4];
//                 document.getElementById('radiusc').innerHTML = response[5]; 
//                 document.getElementById('rssid').innerHTML = response[6];
//                 document.getElementById('radiusd').innerHTML = response[7];                               
//              }
//         });
       
//         realTime();
//     }, 1000);
// }

function realtimeChartRadius(result) {


    //document.getElementById('test').innerHTML = result;
          
    var radius = google.visualization.arrayToDataTable([                   
        ['Radius','Radius',{ role: 'style' }],                   
        ['Reader A', result[1],'blue'],                               
        ['Reader B', result[3],'red'],               
        ['Reader C', result[5],'orange'],
        ['Reader D', result[7],'green'], 
    ]);

    var options = {        
        vAxis: {
            title: 'Radius (m)',
            minValue:0,
        }, 
        hAxis: {
            //  title: 'Methonds',
           
        },
        titleTextStyle: {
            color: '#3A74A1'
        }, 
        // explorer: {
        //     maxZoomOut:1,
        //     keepInBounds: true
        // },             
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
   
    var radiuschart = new google.visualization.ColumnChart(document.getElementById('realtimeradius'));
    radiuschart.draw(radius, options);         
}




