<?php
namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Rfid;
use App\Setting;
use App\Allradius;
use DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use DateTime;

class chartController extends Controller
{

    //let user input id
    public function LineChart(Request $request)
    {
        //DB::table('migrations')->where('id','=','16')->delete();
        $tag_id = $request->search_content;
        $field = $request->search_field;

        $get_setting= Setting::find(1); 
        // $date = new DateTime;
        // $date->modify('-1 minutes');
        // $formatted_date = $date->format('Y-m-d H:i:s');
        
        $readerA_IP = $get_setting->ReaderA_ip;
        $readerB_IP = $get_setting->ReaderB_ip;
        $readerC_IP = $get_setting->ReaderC_ip;
        $readerD_IP = $get_setting->ReaderD_ip;

        $timeTracking = new DateTime;
        $timeTracking->modify('-59 second');
        $timeformatted = $timeTracking->format('Y-m-d H:i:s');

        $recordRadiusA = Allradius::select(                                                 
            DB::raw("second(created_at) as Second"),                                      
            DB::raw("radius as Radius")
            )->where('tag_id','like', '%'.$tag_id.'%')
            ->where('reader_ip','=',$readerA_IP)
            ->orderBy("created_at")                                             
            ->get(); 

        $recordRadiusB = Allradius::select(                                                 
                        DB::raw("second(created_at) as Second"),                                      
                        DB::raw("radius as Radius")
                        )->where('tag_id','like', '%'.$tag_id.'%')
                        ->where('reader_ip','=',$readerB_IP)
                        ->orderBy("created_at")                                             
                        ->get(); 

        $recordRadiusC = Allradius::select(                                                 
                        DB::raw("second(created_at) as Second"),                                      
                        DB::raw("radius as Radius")
                        )->where('tag_id','like', '%'.$tag_id.'%')
                        ->where('reader_ip','=',$readerC_IP)
                        ->orderBy("created_at")                                             
                        ->get(); 

        $recordRadiusD = Allradius::select(                                                 
                        DB::raw("second(created_at) as Second"),                                      
                        DB::raw("radius as Radius")
                        )->where('tag_id','like', '%'.$tag_id.'%')
                        ->where('reader_ip','=',$readerD_IP)
                        ->orderBy("created_at")                                             
                        ->get(); 
       
        $resultRadiusA[] = ['Second','Radius'];
        foreach ($recordRadiusA as $key => $value) {
        $resultRadiusA[++$key] = [(int)$value->Second, (float)$value->Radius];
        }
        //return response()->json($resultRadiusA);
        $resultRadiusB[] = ['Second','Radius'];
        foreach ($recordRadiusB as $key => $value) {
        $resultRadiusB[++$key] = [(int)$value->Second, (float)$value->Radius];
        }

        $resultRadiusC[] = ['Second','Radius'];
        foreach ($recordRadiusC as $key => $value) {
        $resultRadiusC[++$key] = [(int)$value->Second, (float)$value->Radius];
        }

        $resultRadiusD[] = ['Second','Radius'];
        foreach ($recordRadiusD as $key => $value) {
        $resultRadiusD[++$key] = [(int)$value->Second, (float)$value->Radius];
        }

        
        $recordA = DB::table('store_all_tag_record')
                    ->select(                                                 
                        DB::raw("second(created_at) as Second"),
                        DB::raw("tag_rssi as Rssi")
                        )                 
                        ->where('tag_id','like', '%'.$tag_id.'%')                                                            
                        ->where('reader_ip','=',$readerA_IP)     
                        // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                        ->orderBy("created_at")                                             
                        ->get();
                     //  return   $recordA;
        $recordB = DB::table('store_all_tag_record')
                    ->select(                                                 
                        DB::raw("second(created_at) as Second"),
                        DB::raw("tag_rssi as Rssi")
                        )               
                        ->where('tag_id','like', '%'.$tag_id.'%')                                          
                        ->where('reader_ip','=',$readerB_IP)                                                                                                                          
                        ->orderBy("created_at")                                             
                        ->get();

        $recordC = DB::table('store_all_tag_record')
                    ->select(                                                 
                        DB::raw("second(created_at) as Second"),
                        DB::raw("tag_rssi as Rssi")
                        )               
                        ->where('tag_id','like', '%'.$tag_id.'%')                                          
                        ->where('reader_ip','=',$readerC_IP)                                                                                                                          
                        ->orderBy("created_at")                                             
                        ->get();

        $recordD = DB::table('store_all_tag_record')
                    ->select(                                                 
                        DB::raw("second(created_at) as Second"),
                        DB::raw("tag_rssi as Rssi")
                        )               
                        ->where('tag_id','like', '%'.$tag_id.'%')                                          
                        ->where('reader_ip','=',$readerD_IP)                                                                                                                          
                        ->orderBy("created_at")                                             
                        ->get();
                        
        $resultA[] = ['Second','Rssi'];
        foreach ($recordA as $key => $value) {
            $resultA[++$key] = [(int)$value->Second, (int)$value->Rssi];
        }
        $resultB[] = ['Second','Rssi'];
        foreach ($recordB as $key => $value) {
            $resultB[++$key] = [(int)$value->Second, (int)$value->Rssi];
        }
        $resultC[] = ['Second','Rssi'];
        foreach ($recordC as $key => $value) {
            $resultC[++$key] = [(int)$value->Second, (int)$value->Rssi];
        }
        $resultD[] = ['Second','Rssi'];
        foreach ($recordD as $key => $value) {
            $resultD[++$key] = [(int)$value->Second, (int)$value->Rssi];
        }
        
        if($tag_id != null && $field == 'all'){          
            $flag = "all";
            $showEmptyChart=false; 
            $showRadiusChartA=false;
            $showRadiusChartB=false;           
            $showRadiusChartC=false;
            $showRadiusChartD=false;                      
        }
        else if($tag_id != null && $field == "reader_a"){
             
            $resultB = null;
            $resultC = null;
            $resultD = null;      
            $resultRadiusB = null;
            $resultRadiusC = null;
            $resultRadiusD = null;
            $flag = null;
            $showEmptyChart=false;
            $showRadiusChartA="showRadiusChartA";
            $showRadiusChartB=false;
            $showRadiusChartC=false;
            $showRadiusChartD=false;
        }    
        else if($tag_id != null && $field == "reader_b"){
           
            $resultA = null;
            $resultC = null;
            $resultD = null;
            $resultRadiusA = null;           
            $resultRadiusC = null;
            $resultRadiusD = null;
            $flag = null;
            $showEmptyChart=false;
            $showRadiusChartA=false;
            $showRadiusChartB=true;
            $showRadiusChartC=false;
            $showRadiusChartD=false;
        }   
        else if($tag_id != null && $field == "reader_c"){
           
            $resultA = null;
            $resultB = null;
            $resultD = null;
            $flag = null;
            $resultRadiusA = null;
            $resultRadiusB = null;            
            $resultRadiusD = null;
            $showEmptyChart=false;
            $showRadiusChartA=false;
            $showRadiusChartB=false;           
            $showRadiusChartC=true;
            $showRadiusChartD=false;
        }
        else if($tag_id != null && $field == "reader_d"){
           
            $resultA = null;
            $resultB = null;
            $resultC = null;
            $flag = null;
            $resultRadiusA = null;
            $resultRadiusB = null;
            $resultRadiusC = null;           
            $showEmptyChart=false;
            $showRadiusChartA=false;
            $showRadiusChartB=false;           
            $showRadiusChartC=false;
            $showRadiusChartD=true;
        }
        else{ //Line-chart page
           
            $resultA = null;
            $resultB = null;
            $resultC = null;
            $resultD = null;
            $flag = null;
            $showEmptyChart=true;

            $check_count = Setting::count();
            $rfids= DB::table('all_tag_record')->get();
            $count= DB::table('all_tag_record')->count();
            
            return view('/rfid/line-chart')
                    ->with('recordA',$resultA)
                    ->with('recordB',$resultB)
                    ->with('recordC',$resultC)
                    ->with('recordD',$resultD)
                    ->with('flag',$flag)
                    ->with('rfids',$rfids)
                    ->with('count',$count)
                    ->with('showEmptyChart',$showEmptyChart);                                             
        }
      
        return view('/rfid/line-chart')
                ->with('recordA',$resultA)
                ->with('recordB',$resultB)
                ->with('recordC',$resultC)
                ->with('recordD',$resultD)
                ->with('flag',$flag)
                ->with('resultRadiusA',$resultRadiusA)
                ->with('resultRadiusB',$resultRadiusB)
                ->with('resultRadiusC',$resultRadiusC)
                ->with('resultRadiusD',$resultRadiusD) 
                ->with('showEmptyChart',$showEmptyChart)  
                ->with('showRadiusChartA',$showRadiusChartA)
                ->with('showRadiusChartA',$showRadiusChartB) 
                ->with('showRadiusChartA',$showRadiusChartC)
                ->with('showRadiusChartA',$showRadiusChartD);        
    }
}