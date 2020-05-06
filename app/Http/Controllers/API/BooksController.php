<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\User;
use App\Borrow;
use App\Setting;
use App\Fivemins;
use DB;

class BooksController extends Controller
{
    public function list() {
        $content = request("content");
        $field = request("field");

        if ($content == null or $content == '')
            $books = Book::all();
        else
            $books = Book::where($field, 'like', '%'.$content.'%')->get();

        return response()->json($books);
    }

    public function detail($id) {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function record($id) {
        // return dd(request('show_all'));

        $user = User::find($id);
        $code = 200;
        if ($user->role == 0)
            $records = Borrow::where('user_id', '=', $id);
        else {
            $records = Borrow::where('staff_id', '=', $id);
            $code = 201;
        }
        if (request('show_all') == "false") {
            // return response()->json($records);
            $records = $records->whereNull('return_at');
        }
        $records = $records->get();
        foreach($records as $record) {
            $record['title'] = Book::find($record->book_id)->title;
        }
        return response()->json($records, $code);
    }

    public function track($id) {
        $width  = Setting::find(1)->distance_A;
        $height = Setting::find(1)->distance_B;         
        $b = Book::find($id);
        $result = $this->calculate($id);

        return view('api.track')                
                ->with('width',$width)                
                ->with('height',$height)
                ->with('b', $b)
                ->with('result',$result);     
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

            if(count($resultA) != 1){
                $LinearRegressionAValueA = $this->getLinearRegressionIntercept($resultA);//linearRegression Value
                $RadiusofLinearRegressionValueA = $this->rssi_to_distance($LinearRegressionAValueA);
            }
            if(count($resultB) != 1){
                $LinearRegressionAValueB = $this->getLinearRegressionIntercept($resultB);//linearRegression Value
                $RadiusofLinearRegressionValueB = $this->rssi_to_distance($LinearRegressionAValueB);
            }
            if(count($resultC) != 1){
                $LinearRegressionAValueC = $this->getLinearRegressionIntercept($resultC);//linearRegression Value
                $RadiusofLinearRegressionValueC = $this->rssi_to_distance($LinearRegressionAValueC);
            }
            if(count($resultD) != 1){
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

}
