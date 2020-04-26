<?php
namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Rfid;
use App\Book;
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
        $check_count = Setting::count();
        $rfids = DB::table('all_tag_record')->get()->toArray();
        $count = DB::table('all_tag_record')->count();
          
        //$BookName = Book::where('tag_id','like','%'.$key->tag_id.'%')->value('title');
       
        $tag_id = $request->search_tag;
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

        $CountofResultA = $this->countDuplicatesRssi($resultA);
        $MeanofResultA = $this->getMeanRssi($resultA);
        $medianA = $this->getMedium($resultA);
        $FrequentofResultA = $this->getMostFrequentRssi($resultA);
        $LinearRegressionA = $this->get_linear_regressionArray($resultA);

        $CountofResultB = $this->countDuplicatesRssi($resultB);
        $MeanofResultB = $this->getMeanRssi($resultB);
        $medianB = $this->getMedium($resultB);
        $FrequentofResultB = $this->getMostFrequentRssi($resultB);
        $LinearRegressionB = $this->get_linear_regressionArray($resultB);

        $CountofResultC = $this->countDuplicatesRssi($resultC);
        $MeanofResultC = $this->getMeanRssi($resultC);
        $medianC = $this->getMedium($resultC);
        $FrequentofResultC = $this->getMostFrequentRssi($resultC);
        $LinearRegressionC = $this->get_linear_regressionArray($resultC);

        $CountofResultD = $this->countDuplicatesRssi($resultD);
        $MeanofResultD = $this->getMeanRssi($resultD);
        $medianD = $this->getMedium($resultD);
        $FrequentofResultD = $this->getMostFrequentRssi($resultD);
        $LinearRegressionD = $this->get_linear_regressionArray($resultD);

        
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
       
         //return $CountofResultA;
        // return $meanofResultD;
        // return $FrequentofResultD;
        // return dd($this->getSortedArrayY($resultD));
        // $tmp = $this->get_linear_regressionArray($resultD);
        // $t=$this->getMostFrequentRssi($resultC);
        // return $t;
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
                ->with('showRadiusChartA',$showRadiusChartD)
                ->with('rfids',$rfids)
                ->with('count',$count)
                ->with('curTagID',$tag_id)

                ->with('CountofResultA',$CountofResultA)
                ->with('MeanofResultA',$MeanofResultA)
                ->with('medianA',$medianA)
                ->with('FrequentofResultA',$FrequentofResultA)
                ->with('LinearRegressionA',$LinearRegressionA)

                ->with('CountofResultB',$CountofResultB)
                ->with('MeanofResultB',$MeanofResultB)
                ->with('medianB',$medianB)
                ->with('FrequentofResultB',$FrequentofResultB)
                ->with('LinearRegressionB',$LinearRegressionB)

                ->with('CountofResultC',$CountofResultC)
                ->with('MeanofResultC',$MeanofResultC)
                ->with('medianC',$medianC)
                ->with('FrequentofResultC',$FrequentofResultC)
                ->with('LinearRegressionC',$LinearRegressionC)

                ->with('CountofResultD',$CountofResultD)
                ->with('MeanofResultD',$MeanofResultD)
                ->with('medianD',$medianD)
                ->with('FrequentofResultD',$FrequentofResultD)
                ->with('LinearRegressionD',$LinearRegressionD);
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
        $slope = ( ( count($x) * $xy_sum ) - ( $SumofX * $SumofY ) ) / ( ( count($x) * $xx_sum ) - ( $SumofX * $SumofX ) );
        
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

    // public function getslope() {
       
    // }

    // public function getintercept() {
       
    // }


}