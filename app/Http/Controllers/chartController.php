<?php
namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Rfid;
use App\Book;
use App\Setting;
use App\Allradius;
use App\Onemins;
use App\Fivemins;
use App\Fifteenmins;
use App\Halfhour;
use App\Onehour;
use DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use DateTime;

class chartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //let user input id
    public function Chart(Request $request)
    {
        //DB::table('migrations')->where('id','=','16')->delete();
        $ArrayLength = 10;
        $check_count = Setting::count();
        // $rfids = DB::table('all_tag_record')->get()->toArray();
        // $count = DB::table('all_tag_record')->count();
        $rfids = Book::where('tag_id','!=','')->get();
        $count = Book::where('tag_id','!=','')->count();

        $width  = Setting::find(1)->distance_A;
        $height = Setting::find(1)->distance_B;             
       
       
        $tag_id = $request->search_tag;
        $field = $request->search_field;
        $timeframe = $request->time_field;
        $BookName = Book::where('tag_id','like','%'.$tag_id.'%')->value('title');
        $BookID = Book::where('tag_id','like','%'.$tag_id.'%')->value('id');
        $get_setting = Setting::find(1); 
        // $date = new DateTime;
        // $date->modify('-3 minute');
        // $formatted_date = $date->format('Y-m-d H:i:s');
        
        $readerA_IP = $get_setting->ReaderA_ip;
        $readerB_IP = $get_setting->ReaderB_ip;
        $readerC_IP = $get_setting->ReaderC_ip;
        $readerD_IP = $get_setting->ReaderD_ip;

        // $timeTracking = new DateTime;
        // $timeTracking->modify('-59 second');
        // $timeformatted = $timeTracking->format('Y-m-d H:i:s');
        
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

        // 

        if($timeframe == 'oneMins'){
            $timeframeSimple = '1 mins';
            $recordA = Onemins::select(                                                 
                DB::raw("Second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )                 
                ->where('tag_id','=', $tag_id)  
                ->where('reader_ip','=',$readerA_IP)
                ->where('tag_rssi','!=','-64')     
                // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                ->orderBy("created_at")                                             
                ->get();
            //  return   $recordA;
            $recordB = Onemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerB_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                            
                    ->orderBy("created_at")                                             
                    ->get();

            $recordC = Onemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerC_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                            
                    ->orderBy("created_at")                                             
                    ->get();

            $recordD = Onemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerD_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                            
                    ->orderBy("created_at")                                             
                    ->get();       
        }
        elseif($timeframe == 'fiveMins'){
            $timeframeSimple = '5 mins';
            $recordA = Fivemins::select(                                                 
                DB::raw("Second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )                 
                ->where('tag_id','=', $tag_id)                                                              
                ->where('reader_ip','=',$readerA_IP)
                    
                // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                ->orderBy("created_at")
                // ->groupby( DB::raw("Minute(created_at)"))                                            
                ->get();

            $recordB = Fivemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerB_IP)                      
                    // ->where('created_at','>=', $formatted_date)                                                                                                                             
                    ->orderBy("created_at")                                             
                    ->get();

            $recordC = Fivemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerC_IP)                     
                    // ->where('created_at','>=', $formatted_date)                                                                                                                            
                    ->orderBy("created_at")                                             
                    ->get();

            $recordD = Fivemins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerD_IP)                      
                    // ->where('created_at','>=', $formatted_date)                                                                                                                              
                    ->orderBy("created_at")                                             
                    ->get();       

        }
        elseif($timeframe == 'fifteenMins'){
            $timeframeSimple = '15 mins';
            $recordA = Fifteenmins::select(                                                 
                DB::raw("Second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )                 
                ->where('tag_id','=', $tag_id)                                                              
                ->where('reader_ip','=',$readerA_IP)
                // ->where('tag_rssi','!=','-64')          
                // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                ->orderBy("created_at")                                             
                ->get();
            
            $recordB = Fifteenmins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerB_IP) 
                    // ->where('tag_rssi','!=','-64')                                                                                                                              
                    ->orderBy("created_at")                                             
                    ->get();

            $recordC = Fifteenmins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerC_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();

            $recordD = Fifteenmins::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerD_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();       

        }elseif($timeframe == 'halfhour'){
            $timeframeSimple = '30 mins';
            $recordA = Halfhour::select(                                                 
                DB::raw("Second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )                 
                ->where('tag_id','=', $tag_id)                                                              
                ->where('reader_ip','=',$readerA_IP) 
                // ->where('tag_rssi','!=','-64')         
                // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                ->orderBy("created_at")                                             
                ->get();
            
            $recordB = Halfhour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerB_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();

            $recordC = Halfhour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerC_IP)
                    // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();

            $recordD = Halfhour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerD_IP) 
                    // ->where('tag_rssi','!=','-64')                                                                                                                              
                    ->orderBy("created_at")                                             
                    ->get();       

        }
        else{
            $timeframeSimple = '1 hours';
            $recordA = Onehour::select(                                                 
                DB::raw("Second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )                 
                ->where('tag_id','=', $tag_id)                                                              
                ->where('reader_ip','=',$readerA_IP)
                // ->where('tag_rssi','!=','-64')          
                // ->where('created_at','>=', $formatted_date)                                                                                                                                              
                ->orderBy("created_at")                                             
                ->get();
          
            $recordB = Onehour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerB_IP)
                   // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();

            $recordC = Onehour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerC_IP) 
                    //->where('tag_rssi','!=','-64')                                                                                                                              
                    ->orderBy("created_at")                                             
                    ->get();

            $recordD = Onehour::select(                                                 
                    DB::raw("second(created_at) as Second"),
                    DB::raw("tag_rssi as Rssi")
                    )               
                    ->where('tag_id','=', $tag_id)                                            
                    ->where('reader_ip','=',$readerD_IP)
                   // ->where('tag_rssi','!=','-64')                                                                                                                               
                    ->orderBy("created_at")                                             
                    ->get();       
        }
                            
        $resultA[] = ['Second','Rssi'];
        foreach ($recordA as $key => $value) {               
            $resultA[++$key] = [(int)$value->Second, (int)$value->Rssi];
            //$resultA[++$key] = [(int) $key, (int)$value->Rssi];
        }  
        
        $resultB[] = ['Second','Rssi'];
        foreach ($recordB as $key => $value) {
            $resultB[++$key] = [(int)$value->Second, (int)$value->Rssi];
            //$resultB[++$key] = [(int)$key, (int)$value->Rssi];
        }
        $resultC[] = ['Second','Rssi'];
        foreach ($recordC as $key => $value) {
            $resultC[++$key] = [(int)$value->Second, (int)$value->Rssi];
            //$resultC[++$key] = [(int)$key, (int)$value->Rssi];
        }
        $resultD[] = ['Second','Rssi'];
        foreach ($recordD as $key => $value) {
            $resultD[++$key] = [(int)$value->Second, (int)$value->Rssi];
           //$resultD[++$key] = [(int)$key, (int)$value->Rssi];
        }
        $CountofResultA = null;
        $MeanofResultA = null;
        $medianA = null;
        $FrequentofResultA = null;
        $LinearRegressionA = null;
        $RadiusofMeanA = null;
        $RadiusofMedianA = null;
        $RadiusofMostA = null;
        $RadiusofLinearRegressionValueA = null;
        $CountofResultB = null;
        $MeanofResultB = null;
        $medianB = null;
        $FrequentofResultB = null;
        $LinearRegressionB = null;
        $RadiusofMeanB = null;
        $RadiusofMedianB = null;
        $RadiusofMostB = null;
        $RadiusofLinearRegressionValueB = null;
        $CountofResultC = null;
        $MeanofResultC = null;
        $medianC = null;
        $FrequentofResultC = null;
        $LinearRegressionC = null;
        $RadiusofMeanC = null;
        $RadiusofMedianC = null;
        $RadiusofMostC = null;
        $RadiusofLinearRegressionValueC = null;
        $CountofResultD = null;
        $MeanofResultD = null;
        $medianD = null;
        $FrequentofResultD = null;
        $LinearRegressionD = null;
        $RadiusofMeanD = null;
        $RadiusofMedianD = null;
        $RadiusofMostD = null;
        $RadiusofLinearRegressionValueD = null;
       
       
       
        //Result A for Reader A
        if(count($resultA)> $ArrayLength){
            $CountofResultA = $this->countDuplicatesRssi($resultA);
            $LinearRegressionA = $this->get_linear_regressionArray($resultA);
            $MeanofResultA = $this->getMeanRssi($resultA); //Mean
            $medianA = $this->getMedium($resultA);//Median
            $FrequentofResultA = $this->getMostFrequentRssi($resultA); //Most        
            $LinearRegressionAValueA = $this->getLinearRegressionIntercept($resultA);//linearRegression Value
            $RadiusofMeanA = $this->RssiToRadius($MeanofResultA);
            $RadiusofMedianA = $this->RssiToRadius($medianA);
            $RadiusofMostA = $this->RssiToRadius($FrequentofResultA);
            $RadiusofLinearRegressionValueA = $this->RssiToRadius($LinearRegressionAValueA);
         }
        
        //Result B for Reader B
        if(count($resultB)> $ArrayLength){
            $CountofResultB = $this->countDuplicatesRssi($resultB);
            $LinearRegressionB = $this->get_linear_regressionArray($resultB);
            $MeanofResultB = $this->getMeanRssi($resultB);
            $medianB = $this->getMedium($resultB);
            $FrequentofResultB = $this->getMostFrequentRssi($resultB);
            $LinearRegressionAValueB = $this->getLinearRegressionIntercept($resultB);//linearRegression Value
            $RadiusofMeanB = $this->RssiToRadius($MeanofResultB);
            $RadiusofMedianB = $this->RssiToRadius($medianB);
            $RadiusofMostB = $this->RssiToRadius($FrequentofResultB);
            $RadiusofLinearRegressionValueB = $this->RssiToRadius($LinearRegressionAValueB);
        }
       

        //Result C for Reader C
        if(count($resultC)> $ArrayLength){
            $CountofResultC = $this->countDuplicatesRssi($resultC);
            $LinearRegressionC = $this->get_linear_regressionArray($resultC);
            $MeanofResultC = $this->getMeanRssi($resultC);
            $medianC = $this->getMedium($resultC);
            $FrequentofResultC = $this->getMostFrequentRssi($resultC);
            $LinearRegressionAValueC = $this->getLinearRegressionIntercept($resultC);//linearRegression Value
            $RadiusofMeanC = $this->RssiToRadius($MeanofResultC);
            $RadiusofMedianC = $this->RssiToRadius($medianC);
            $RadiusofMostC = $this->RssiToRadius($FrequentofResultC);
            $RadiusofLinearRegressionValueC = $this->RssiToRadius($LinearRegressionAValueC);
        }
        

        //Result D for Reader D
        if(count($resultD)> $ArrayLength){
            $CountofResultD = $this->countDuplicatesRssi($resultD);
            $LinearRegressionD = $this->get_linear_regressionArray($resultD);
            $MeanofResultD = $this->getMeanRssi($resultD);
            $medianD = $this->getMedium($resultD);
            $FrequentofResultD = $this->getMostFrequentRssi($resultD);
            $LinearRegressionAValueD = $this->getLinearRegressionIntercept($resultD);//linearRegression Value
            $RadiusofMeanD = $this->RssiToRadius($MeanofResultD);
            $RadiusofMedianD = $this->RssiToRadius($medianD);
            $RadiusofMostD = $this->RssiToRadius($FrequentofResultD);
            $RadiusofLinearRegressionValueD = $this->RssiToRadius($LinearRegressionAValueD);
        }
        

        
        if($tag_id != null && $field == 'all'){          
            $flag = "all";
            $showEmptyChart = false; 
            $showRadiusChartA = false;
            $showRadiusChartB = false;           
            $showRadiusChartC = false;
            $showRadiusChartD = false;                      
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

            $CountofResultB = null;
            $MeanofResultB = null;
            $medianB = null;
            $FrequentofResultB = null;
            $LinearRegressionB = null;

            $CountofResultC = null;
            $MeanofResultC = null;
            $medianC = null;
            $FrequentofResultC = null;
            $LinearRegressionC = null;

            $CountofResultD = null;
            $MeanofResultD = null;
            $medianD = null;
            $FrequentofResultD = null;
            $LinearRegressionD = null;
           
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

            $CountofResultA = null;
            $MeanofResultA = null;
            $medianA = null;
            $FrequentofResultA = null;
            $LinearRegressionA = null;

            $CountofResultC = null;
            $MeanofResultC = null;
            $medianC = null;
            $FrequentofResultC = null;
            $LinearRegressionC = null;
            
            $CountofResultD = null;
            $MeanofResultD = null;
            $medianD = null;
            $FrequentofResultD = null;
            $LinearRegressionD = null;
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

            $CountofResultA = null;
            $MeanofResultA = null;
            $medianA = null;
            $FrequentofResultA = null;
            $LinearRegressionA = null;

            $CountofResultB = null;
            $MeanofResultB = null;
            $medianB = null;
            $FrequentofResultB = null;
            $LinearRegressionB = null;                                                            
            
            $CountofResultD = null;
            $MeanofResultD = null;
            $medianD = null;
            $FrequentofResultD = null;
            $LinearRegressionD = null;
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

            $CountofResultA = null;
            $MeanofResultA = null;
            $medianA = null;
            $FrequentofResultA = null;
            $LinearRegressionA = null;

            $CountofResultB = null;
            $MeanofResultB = null;
            $medianB = null;
            $FrequentofResultB = null;
            $LinearRegressionB = null;                                                            
            
            $CountofResultC = null;
            $MeanofResultC = null;
            $medianC = null;
            $FrequentofResultC = null;
            $LinearRegressionC = null;
           
        }
        else{ //Line-chart page
           
            $resultA = null;
            $resultB = null;
            $resultC = null;
            $resultD = null;
            $flag = null;
            $showEmptyChart=true;          
            
            return view('/rfid/chart')
                    ->with('recordA',$resultA)
                    ->with('recordB',$resultB)
                    ->with('recordC',$resultC)
                    ->with('recordD',$resultD)
                    ->with('flag',$flag)
                    ->with('rfids',$rfids)
                    ->with('count',$count)
                    ->with('showEmptyChart',$showEmptyChart)
                    ->with('width',$width)
                    ->with('height',$height);                                             
        }            
       
        $RssiList = $this->rssiToradiusSample();
    
        
        return view('/rfid/chart')
                ->with('recordA',$resultA)
                ->with('recordB',$resultB)
                ->with('recordC',$resultC)
                ->with('recordD',$resultD)
                ->with('flag',$flag)
                ->with('field',$field)
                ->with('resultRadiusA',$resultRadiusA)
                ->with('resultRadiusB',$resultRadiusB)
                ->with('resultRadiusC',$resultRadiusC)
                ->with('resultRadiusD',$resultRadiusD) 
                ->with('showEmptyChart',$showEmptyChart)  
                ->with('showRadiusChartA',$showRadiusChartA)
                ->with('showRadiusChartA',$showRadiusChartB) 
                ->with('showRadiusChartA',$showRadiusChartC)
                ->with('showRadiusChartA',$showRadiusChartD)
                ->with('rfids',$rfids)
                ->with('count',$count)
                ->with('curTagID',$tag_id)
                ->with('timeframeSimple',$timeframeSimple)
                ->with('BookName',$BookName)
                ->with('BookID',$BookID)
                ->with('RssiList',$RssiList)
                ->with('width',$width)
                ->with('height',$height)

                ->with('CountofResultA',$CountofResultA)
                ->with('MeanofResultA',$MeanofResultA)
                ->with('medianA',$medianA)
                ->with('FrequentofResultA',$FrequentofResultA)
                ->with('LinearRegressionA',$LinearRegressionA)
                ->with('RadiusofMeanA',$RadiusofMeanA)
                ->with('RadiusofMedianA',$RadiusofMedianA)
                ->with('RadiusofMostA',$RadiusofMostA)
                ->with('RadiusofLinearRegressionValueA',$RadiusofLinearRegressionValueA)

                ->with('CountofResultB',$CountofResultB)
                ->with('MeanofResultB',$MeanofResultB)
                ->with('medianB',$medianB)
                ->with('FrequentofResultB',$FrequentofResultB)
                ->with('LinearRegressionB',$LinearRegressionB)
                ->with('RadiusofMeanB',$RadiusofMeanB)
                ->with('RadiusofMedianB',$RadiusofMedianB)
                ->with('RadiusofMostB',$RadiusofMostB)
                ->with('RadiusofLinearRegressionValueB',$RadiusofLinearRegressionValueB)

                ->with('CountofResultC',$CountofResultC)
                ->with('MeanofResultC',$MeanofResultC)
                ->with('medianC',$medianC)
                ->with('FrequentofResultC',$FrequentofResultC)
                ->with('LinearRegressionC',$LinearRegressionC)
                ->with('RadiusofMeanC',$RadiusofMeanC)
                ->with('RadiusofMedianC',$RadiusofMedianC)
                ->with('RadiusofMostC',$RadiusofMostC)
                ->with('RadiusofLinearRegressionValueC',$RadiusofLinearRegressionValueC)

                ->with('CountofResultD',$CountofResultD)
                ->with('MeanofResultD',$MeanofResultD)
                ->with('medianD',$medianD)
                ->with('FrequentofResultD',$FrequentofResultD)
                ->with('LinearRegressionD',$LinearRegressionD)
                ->with('RadiusofMeanD',$RadiusofMeanD)
                ->with('RadiusofMedianD',$RadiusofMedianD)
                ->with('RadiusofMostD',$RadiusofMostD)
                ->with('RadiusofLinearRegressionValueD',$RadiusofLinearRegressionValueD);
    }

    public function postAjax(Request $request){
            $tag_id = $request->input;

            $get_setting = Setting::find(1);                      
            $readerA_IP = $get_setting->ReaderA_ip;
            $readerB_IP = $get_setting->ReaderB_ip;
            $readerC_IP = $get_setting->ReaderC_ip;
            $readerD_IP = $get_setting->ReaderD_ip;

            $readerIP = array($readerA_IP, $readerB_IP, $readerC_IP, $readerD_IP);

            // $Onesecond = new DateTime;
            // $Onesecond->modify('-1 second');
            // $formatted = $Onesecond->format('Y-m-d H:i:s');
           
            
            $rssia = Rfid::where('tag_id','=', $tag_id)                                                            
                            ->where('reader_ip','=',$readerIP[0])                            
                            ->value('tag_rssi');
                           
                            
            if($rssia != null){                            
                $radiusa = $this->RssiToRadius($rssia);
            }
            else{
                // $rssia = "null";
                // $radiusa = "null";
                $rssia = null;
                $radiusa = null;
            }

            $rssib = Rfid::where('tag_id','=', $tag_id)                                                            
                            ->where('reader_ip','=',$readerIP[1])
                            //->where('reader_record_time', '>=', $formatted)                                                                                                                                                           
                            ->value('tag_rssi');
                           
            if($rssib != null){  
                $radiusb = $this->RssiToRadius($rssib);
            }
            else{
                // $rssib = "null";
                // $radiusb = "null";
                $rssib = null;
                $radiusb = null;
            }

            $rssic = Rfid::where('tag_id','=', $tag_id)                                                            
                            ->where('reader_ip','=',$readerIP[2])
                            //->where('reader_record_time', '>=', $formatted)                                                                                                                                                           
                            ->value('tag_rssi');
                            
            if($rssic != null){  
                $radiusc = $this->RssiToRadius($rssic); 
            }
            else{
                // $rssic = "null";
                // $radiusc = "null";
                $rssic = null;
                $radiusc = null;
            }        
            $rssid = Rfid::where('tag_id','=', $tag_id)                                                            
                            ->where('reader_ip','=',$readerIP[3]) 
                            //->where('reader_record_time', '>=', $formatted)                                                                                                                                                          
                            ->value('tag_rssi'); 
                           
            if($rssid != null){                         
                $radiusd = $this->RssiToRadius($rssid);
            }
            else{
                // $rssid = "null";
                // $radiusd = "null";
                $rssid = null;       
                $radiusd = null;
            }           
                       
            $allresult = array(
                $rssia,$radiusa,
                $rssib,$radiusb,
                $rssic,$radiusc,
                $rssid,$radiusd,
            );
                                 
            return response()->json($allresult);         
            
    }

    // public function getAjax(){  //pass to sucesss ajax
           
    //         $get_setting = Setting::find(1);                      
    //         $readerA_IP = $get_setting->ReaderA_ip;
    //         $readerB_IP = $get_setting->ReaderB_ip;
    //         $readerC_IP = $get_setting->ReaderC_ip;
    //         $readerD_IP = $get_setting->ReaderD_ip;

    //         $readerIP = array($readerA_IP, $readerB_IP, $readerC_IP, $readerD_IP);

            
    //         $rssia = Rfid::where('tag_id','=', $tag_id)                                                            
    //                         ->where('reader_ip','=',$readerIP[0])                                                                                                                                                        
    //                         ->value('tag_rssi');
    //         $radiusa = $this->RssiToRadius($rssia);

    //         $rssib = Rfid::where('tag_id','=', $tag_id)                                                            
    //                         ->where('reader_ip','=',$readerIP[1])                                                                                                                                                        
    //                         ->value('tag_rssi'); 
    //         $radiusb = $this->RssiToRadius($rssib);

    //         $rssic = Rfid::where('tag_id','=', $tag_id)                                                            
    //                         ->where('reader_ip','=',$readerIP[2])                                                                                                                                                        
    //                         ->value('tag_rssi');
    //         $radiusc = $this->RssiToRadius($rssic); 

    //         $rssid = Rfid::where('tag_id','=', $tag_id)                                                            
    //                         ->where('reader_ip','=',$readerIP[3])                                                                                                                                                        
    //                         ->value('tag_rssi');  
    //         $radiusd = $this->RssiToRadius($rssid); 
            
            
    //         $allresult = array(
    //             $rssia,$radiusa,
    //             $rssib,$radiusb,
    //             $rssic,$radiusc,
    //             $rssid,$radiusd,
    //         );
                                 
    //         return response()->json($allresult);                   
    // }

    public function RssiToRadius($rssi) {
        $p = Setting::find(1)->p;
        $n = Setting::find(1)->n;
        $x = ($p - $rssi) / (10 * $n);
        return pow(10, $x);
    }

    public function rssiToradiusSample(){
        
        $RssiVar = -50;       
        $rssiArr = [];
        $radiusArr = []; 
        for($a = 1; $a < 16; $a++){           
            $rssiArr[$a] = (int) $RssiVar;
            $radiusArr[$a]= (float) $this->RssiToRadius($RssiVar);
            $RssiVar--;           
        }     
     
        return array(
            'rssi'=>$rssiArr,
            'radius'=>$radiusArr
        );
    }

    public function countDuplicatesRssi($resultArray){
        $RssiList = [];
        $ResultList = [];
        $arr1 = [];
        $arr2 = [];
    
        for($i = 1 ; $i < count($resultArray); $i++){               
           $RssiList[$i] = strval($resultArray[$i][1]);                               
        }
        $ResultList = array_count_values($RssiList); 
        arsort($ResultList);

        for($i = 0 ; $i < count($ResultList); $i++){ 
            $arr1[$i] = array_keys($ResultList)[$i];
            $arr2[$i] = array_values($ResultList)[$i]; //the value
        }

        return array(
            'rssi'=>$arr1,
            'num'=>$arr2,
        );
        
    }

    public function getMeanRssi($resultArray){
        $sum = 0;
        for($i = 1 ; $i < count($resultArray); $i++){                          
            $sum += $resultArray[$i][1];                             
        }
        return $sum/count($resultArray);
    }

    public function getMedium($resultArray){
        $RssiList = [];
        $ResultList = [];
    
        for($i = 1 ; $i < count($resultArray); $i++){               
           $RssiList[$i] = $resultArray[$i][1];                               
        }
        sort($RssiList);          
        $mid = floor((count($RssiList)-1)/2); 
        if(count($RssiList) % 2) { 
            $median = $RssiList[$mid];
        } 
        else { 
            $low = $RssiList[$mid];
            $high = $RssiList[$mid+1];
            $median = (($low+$high)/2);
        }

        return $median;       
    }

    public function getMostFrequentRssi($resultArray){
        $RssiList = [];
        $ResultList = [];
        $arr1 = [];
        $arr2 = [];
    
        for($i = 1 ; $i < count($resultArray); $i++){               
           $RssiList[$i] = strval($resultArray[$i][1]);                               
        }
       
        $ResultList = array_count_values($RssiList);
        arsort($ResultList);       

        for($i = 0 ; $i < count($ResultList); $i++){ 
            $arr1[$i] = array_keys($ResultList)[$i];
            $arr2[$i] = array_values($ResultList)[$i]; //the value
        }
       
        $MaxList = [];
        for ($i = 0; $i<count($arr1); $i++) {
            if (max($arr2) == array_values($ResultList)[$i]) {
                array_push($MaxList, $arr1[$i]);
            }
        }

        $mode = array_sum($MaxList)/count($MaxList);         
        // $popular = array_slice(array_keys($ResultList),0,true);

        // return $popular;
        return $mode;        
    }

    public function get_linear_regressionArray($resultArray){
        $x = [];
        $y = [];

        for($i = 1 ; $i < count($resultArray); $i++){               
            $x[$i]=$resultArray[$i][0];
            $y[$i]=$resultArray[$i][1];
        }
        array_multisort($x, $y);
       
        $ans = $this->linear_regression($x,$y);          

        return $ans;
    }

    public function getLinearRegressionSlope($resultArray){
        $x = [];
        $y = [];
       

        for($i = 1 ; $i < count($resultArray); $i++){               
            $x[$i]=$resultArray[$i][0];
            $y[$i]=$resultArray[$i][1];
        }
        array_multisort($x, $y);
       
        $ans = $this->linear_regression($x,$y);          

        return $ans['slope'];
    }

    public function getLinearRegressionIntercept($resultArray){
        $x = [];
        $y = [];       

        for($i = 1 ; $i < count($resultArray); $i++){               
            $x[$i]=$resultArray[$i][0];
            $y[$i]=$resultArray[$i][1];
        }
        array_multisort($x, $y);
       
        $ans = $this->linear_regression($x,$y);          

        return $ans['intercept'];
    }

    public function linear_regression( $x, $y ) {
 
        $SumofX = array_sum($x); // sum of all X values
        $SumofY = array_sum($y); // sum of all Y values
     
        $xx_sum = 0;
        $xy_sum = 0;
     
        for($i = 0; $i < count($x); $i++) {
            $xy_sum += ( $x[$i] * $y[$i] );
            $xx_sum += ( $x[$i] * $x[$i] );
        }
     
        // Slope
        $slope = ( ( count($x) * $xy_sum ) - ( $SumofX * $SumofY ) ) /
         ( ( count($x) * $xx_sum ) - ( $SumofX * $SumofX ) );
        
        // intercept
        $intercept = ( $SumofY - ( $slope * $SumofX ) ) / count($x);
     
        return array( 
            'slope'     => $slope,
            'intercept' => $intercept,
        );
    }

    public function getArrayX($resultArray){
        $x = [];
        // $y = [];
        for($i = 1 ; $i < count($resultArray); $i++){               
            $x[$i]=$resultArray[$i][0];
            //$y[$i]=$resultArray[$i][1];
        }
        array_multisort($x);
        return $x;
    }

    public function getArrayYSortedByTime($resultArray){
         $y = [];
        for($i = 1 ; $i < count($resultArray); $i++){                          
            $y[$i]=$resultArray[$i][1];
        }
        array_multisort($y);
        return $y;
    }

    public function getSortedArrayY($resultArray){
        $y = [];
       for($i = 1 ; $i < count($resultArray); $i++){                          
           $y[$i]=$resultArray[$i][1];
       }
       sort($y);
       return $y;
   }

}