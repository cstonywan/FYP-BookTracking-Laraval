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
    
    public function track($id)
    {               
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
                ->with('records',$records)
                ->with('width',$width)
                ->with('height',$height);
     
    }

    public function calculate($id) {
        $timeTracking = new DateTime;
        $timeTracking->modify('-3 second');
        $timeformatted = $timeTracking->format('Y-m-d H:i:s');
        

        $tag_id = Book::find($id)->tag_id;
        $rfid_list = Fivemins:: where('tag_id','like','%'.$tag_id.'%')
                            //->where('updated_at','>=',$timeformatted) //get the most recent 3s record
                            ->orderby('reader_ip')
                            ->get();
                            
    
        //delete the radius record when pass 60s
        // $date = new DateTime;
        
        // $date->modify('-60 second');
        // $formatted = $date->format('Y-m-d H:i:s');
       
        // Allradius::where('tag_id','like','%'.$tag_id.'%')
        //            ->where('created_at', '<=', $formatted)->delete();
                
        $records = array();
        $count = 0;
        foreach($rfid_list as $oneRfid) {            
            $records[$count++] = [
                "ip"=>$oneRfid->reader_ip,
                "radius"=>$this->rssi_to_distance($oneRfid->tag_rssi),                
            ];   
            
            // Allradius::create([
            //     'tag_id'=>$tag_id,
            //     'radius'=>$this->rssi_to_distance($oneRfid->tag_rssi),
            //     'reader_ip'=>$oneRfid->reader_ip,
            // ]);
        }
        
        return $records;
    }

    public function rssi_to_distance($rssi) {
        $p = Setting::find(1)->p;
        $n = Setting::find(1)->n;
        $x = ($p - $rssi) / (10 * $n);
        return pow(10, $x);
    }
    
}