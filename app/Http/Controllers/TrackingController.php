<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Book;
use App\Rfid;
use App\Onemins;
use App\Fivemins;
use App\Fifteenmins;
use App\Allradius;
use Illuminate\Support\Facades\Session;
use DB;
use DateTime;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function track($id)
    {               
        $b = Book::find($id);
        $books = Book::all();

      if($id != 0){
        $check = Book::find($id)->tag_id;
      }
      if($id == 0 || $check == null || $check == ""){
          $records = null;
          $width  = Setting::find(1)->distance_A;
          $height = Setting::find(1)->distance_B;                           
      }
      else{
            $records = $this->calculate($id);
            $width  = Setting::find(1)->distance_A;
            $height = Setting::find(1)->distance_B;                        
      }
      //return $records;
      return view('books.track')
                ->with('books', $books)
                ->with('b', $b)
                ->with('records',$records)
                ->with('width',$width)
                ->with('height',$height);     
    }
   
    public function calculate($id) {        
        return $this->getfinalresult($id);
    }

    public function getfinalresult($id){

        $tag_id = Book::find($id)->tag_id;
        $get_setting = Setting::find(1); 

        $readerA_IP = $get_setting->ReaderA_ip;
        $readerB_IP = $get_setting->ReaderB_ip;
        $readerC_IP = $get_setting->ReaderC_ip;
        $readerD_IP = $get_setting->ReaderD_ip;

        $RadiusofLinearRegressionValueA = null;
        $RadiusofLinearRegressionValueB = null;
        $RadiusofLinearRegressionValueC = null;
        $RadiusofLinearRegressionValueD = null;

        $recordA = Fivemins::select(                                                 
            DB::raw("Second(created_at) as Second"),
            DB::raw("tag_rssi as Rssi")
            )                 
            ->where('tag_id','like', '%'.$tag_id.'%')                                                            
            ->where('reader_ip','=',$readerA_IP)                                                                                                                                                                   
            ->orderBy("created_at")            
            ->get();

        $recordB = Fivemins::select(                                                 
                DB::raw("second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )               
                ->where('tag_id','like', '%'.$tag_id.'%')                                          
                ->where('reader_ip','=',$readerB_IP)                                                                                                                                     
                ->orderBy("created_at")                                             
                ->get();

        $recordC = Fivemins::select(                                                 
                DB::raw("second(created_at) as Second"),
                DB::raw("tag_rssi as Rssi")
                )               
                ->where('tag_id','like', '%'.$tag_id.'%')                                          
                ->where('reader_ip','=',$readerC_IP)                                                                                                                                                           
                ->orderBy("created_at")                                             
                ->get();

        $recordD = Fivemins::select(                                                 
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

            if(count($resultA)> 10){
                $LinearRegressionAValueA = $this->getLinearRegressionIntercept($resultA);//linearRegression Value
                $RadiusofLinearRegressionValueA = $this->rssi_to_distance($LinearRegressionAValueA);
            }
            if(count($resultB)> 10){
                $LinearRegressionAValueB = $this->getLinearRegressionIntercept($resultB);//linearRegression Value
                $RadiusofLinearRegressionValueB = $this->rssi_to_distance($LinearRegressionAValueB);
            }
            if(count($resultC)> 10){
                $LinearRegressionAValueC = $this->getLinearRegressionIntercept($resultC);//linearRegression Value
                $RadiusofLinearRegressionValueC = $this->rssi_to_distance($LinearRegressionAValueC);
            }
            if(count($resultD)> 10){
                $LinearRegressionAValueD = $this->getLinearRegressionIntercept($resultD);//linearRegression Value
                $RadiusofLinearRegressionValueD = $this->rssi_to_distance($LinearRegressionAValueD);
            }

            $finalresult = array(
                [$readerA_IP, $RadiusofLinearRegressionValueA],
                [$readerB_IP, $RadiusofLinearRegressionValueB],
                [$readerC_IP, $RadiusofLinearRegressionValueC],
                [$readerD_IP, $RadiusofLinearRegressionValueD],                                
            );
            
        return $finalresult;
    }

    public function rssi_to_distance($rssi) {
        $p = Setting::find(1)->p;
        $n = Setting::find(1)->n;
        $x = ($p - $rssi) / (10 * $n);
        return pow(10, $x);
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

     // public function calculate($id) { //old version
    //     $timeTracking = new DateTime;
    //     $timeTracking->modify('-3 second');
    //     $timeformatted = $timeTracking->format('Y-m-d H:i:s');
        

    //     $tag_id = Book::find($id)->tag_id;
    //     $rfid_list = Fivemins:: where('tag_id','like','%'.$tag_id.'%')
    //                         // ->where('updated_at','>=',$timeformatted) //get the most recent 3s record
    //                         ->orderby('reader_ip')
    //                         ->get();                                      
            
    //     $records = array();
    //     $count = 0;
    //     foreach($rfid_list as $oneRfid) {            
    //         $records[$count++] = [
    //             "ip"=>$oneRfid->reader_ip,
    //             "radius"=>$this->rssi_to_distance($oneRfid->tag_rssi),                
    //         ];                         
    //     }        
    //     return $records;               
    // }

    
}