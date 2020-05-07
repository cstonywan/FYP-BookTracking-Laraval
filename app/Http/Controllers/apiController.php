<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Book;
use App\Rfid;
use App\Onemins;
use App\Fivemins;
use App\Fifteenmins;
use App\Halfhour;
use App\Onehour;
use App\Alltag;
use DB;
use DateTime;

class apiController extends Controller
{
    public function store(Request $request){ 

        $count = Rfid::count(); //check total record number
        $allowAddTag = false;
        // $resetRecord = true; //clean the table 
        // $Trackstart = true; //important!! 5mins table

        $resetRecord = false; //keep the table 
        $Trackstart = false;
              
        if (isset($_POST['Tag_id']) && isset($_POST['Tag_pc'])&&
        isset($_POST['Tag_count']) && isset($_POST['Tag_rssi'])&&
        isset($_POST['Reader_id']) && isset($_POST['Reader_record_time'])&&
        isset($_POST['Reader_ip'])) {
                //debug use
                // var_dump($_POST['Tag_id']);
                // var_dump($_POST['Tag_pc']);
                // var_dump($_POST['Tag_count']);
                // var_dump($_POST['Tag_rssi']);
                // var_dump($_POST['Reader_id']);
                // var_dump($_POST['Reader_record_time']);
                // var_dump($_POST['Reader_ip']);
                $rssi = 0;
                if($_POST['Tag_rssi'] == "-52"){
                    $rssi = -50;
                }
                else if($_POST['Tag_rssi'] == "-54"){
                    $rssi = -52;
                }
                else if($_POST['Tag_rssi'] == "-58"){
                    $rssi = -55;
                }
                else if($_POST['Tag_rssi'] == "-59"){
                    $rssi = -57;
                }
                else if($_POST['Tag_rssi'] == "-64"){
                    $rssi = -58;
                }
                else{
                    $rssi = $_POST['Tag_rssi'];
                }
                

                if($allowAddTag){
                //For add a new tag to the all testing tag table
                    $record_check =  Alltag::where('tag_id','=',substr($_POST['Tag_id'], 1))->first();
                    if($record_check == null){                 
                        $Tag_id = substr($_POST['Tag_id'], 1);
                        Alltag::create([
                            'tag_id' => $Tag_id
                        ]);                   
                    }
                }

                // $losttime = new DateTime;
                // $losttime->modify('-3 second');
                // $losttimeformatted = $losttime->format('Y-m-d H:i:s');

                // $usedTag = Book::whereNotNull('tag_id')->pluck('tag_id')->toArray();

                // $checkcurrentTag = Rfid::where('tag_id','like','%'.$usedTag.'%')
                //                         ->where('updated_at','<=',$losttime)->get();                                                
                
                if($resetRecord){
                    //Clean the data within 1 minutes
                    $Onemin = new DateTime;
                    $Onemin->modify('-1 minutes');
                    $Oneminformatted = $Onemin->format('Y-m-d H:i:s');
                    Onemins::where('created_at', '<=', $Oneminformatted)->delete();

                    if($Trackstart){
                        //Clean the data within 5 minutes
                        $Fivemin = new DateTime;
                        $Fivemin->modify('-5 minute');
                        $Fiveminformatted = $Fivemin->format('Y-m-d H:i:s');
                        Fivemins::where('created_at', '<=', $Fiveminformatted)->delete();
                    }

                    //Clean the data within 15 minutes
                    $Fifteenmin = new DateTime;
                    $Fifteenmin->modify('-15 minutes');
                    $Fifteenminformatted = $Fifteenmin->format('Y-m-d H:i:s');
                    Fifteenmins::where('created_at', '<=', $Fifteenminformatted)->delete();

                    //Clean the data within 30 minutes
                    $Halfhour = new DateTime;
                    $Halfhour->modify('-30 minutes');
                    $Halfhourformatted = $Halfhour->format('Y-m-d H:i:s');
                    Halfhour::where('created_at', '<=', $Halfhourformatted)->delete();

                    //Clean the data within 1 hour
                    $Onehour = new DateTime;
                    $Onehour->modify('-60 minutes');
                    $Onehourformatted = $Onehour->format('Y-m-d H:i:s');
                    Onehour::where('created_at', '<=', $Onehourformatted)->delete();
                }
                
            if($resetRecord){
              
                    $fakedata = false;
                    $currentDate = date('Y-m-d H:i:s.') . gettimeofday()['usec'];
                    if (strtotime($currentDate) - strtotime($_POST['Reader_record_time']) >= 5) {
                         var_dump("Fake Data!!");
                        var_dump($_POST['Tag_id']);
                        var_dump($_POST['Tag_pc']);
                        var_dump($_POST['Tag_count']);
                        var_dump($rssi);
                        var_dump($_POST['Reader_id']);
                        var_dump($_POST['Reader_record_time']);
                        var_dump($_POST['Reader_ip']);
                        $fakedata = true;   
                    }
                    else{
                        var_dump("True Data!!");
                        $fakedata = false;
                    } 

                    if($fakedata == false){
                        
                            Onemins::create([
                                'tag_id' => substr($_POST['Tag_id'], 1),
                                'tag_rssi' => $rssi,
                                'tag_count' => $_POST['Tag_count'],                                               
                                'reader_record_time' => $_POST['Reader_record_time'],
                                'reader_ip' => $_POST['Reader_ip'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            if($Trackstart){                        
                                Fivemins::create([
                                    'tag_id' => substr($_POST['Tag_id'], 1),
                                    'tag_rssi' => $rssi,
                                    'tag_count' => $_POST['Tag_count'],                                               
                                    'reader_record_time' => $_POST['Reader_record_time'],
                                    'reader_ip' => $_POST['Reader_ip'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }

                            Fifteenmins::create([
                                'tag_id' => substr($_POST['Tag_id'], 1),
                                'tag_rssi' => $rssi,
                                'tag_count' => $_POST['Tag_count'],                                               
                                'reader_record_time' => $_POST['Reader_record_time'],
                                'reader_ip' => $_POST['Reader_ip'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            Halfhour::create([
                                'tag_id' => substr($_POST['Tag_id'], 1),
                                'tag_rssi' => $rssi,
                                'tag_count' => $_POST['Tag_count'],                                               
                                'reader_record_time' => $_POST['Reader_record_time'],
                                'reader_ip' => $_POST['Reader_ip'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            Onehour::create([
                                'tag_id' => substr($_POST['Tag_id'], 1),
                                'tag_rssi' => $rssi,
                                'tag_count' => $_POST['Tag_count'],                                               
                                'reader_record_time' => $_POST['Reader_record_time'],
                                'reader_ip' => $_POST['Reader_ip'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]); 
                      
                    }
                }
                          
                
                $record_check = Rfid::where('tag_id','=',substr($_POST['Tag_id'], 1))
                                    ->where('reader_ip','=',$_POST['Reader_ip'])
                                    ->first();
                                   
                
                if($record_check!= null){ //existed to update the record                    
                
                    $data = array(            
                        "tag_id"=>substr($_POST['Tag_id'], 1),
                        "tag_pc_value"=>$_POST['Tag_pc'],
                        "tag_count"=>$_POST['Tag_count'],
                        "tag_rssi"=>$rssi,
                        "reader_antenna"=>$_POST['Reader_id'],
                        "reader_record_time"=>$_POST['Reader_record_time'],
                        "reader_ip"=>$_POST['Reader_ip'],
                    );                   
                    Rfid::where('tag_id','=',substr($_POST['Tag_id'], 1))
                    ->where('reader_ip','=',$_POST['Reader_ip'])
                    ->update($data);
                }
                else{       //a new record                     
                    Rfid::create([
                        "tag_id"=>substr($_POST['Tag_id'], 1),
                        'tag_pc_value' =>$_POST['Tag_pc'],
                        'tag_count' => $_POST['Tag_count'],
                        'tag_rssi' => $rssi,
                        'reader_antenna' => $_POST['Reader_id'],
                        'reader_record_time' => $_POST['Reader_record_time'],
                        'reader_ip' => $_POST['Reader_ip'],
                    ]);                   
                }                                                                                          
        }                             
    }

    public function show($Tag_id){ 
        $record= Rfid::find($Tag_id);
        $records = Rfid::where('tag_id','like','%'.$Tag_id.'%')->get();
        return view('borrows.record', compact('records'));
    }
    public function showall(){ 
        $rfids= DB::table('all_tag_record')->get();
        $count =DB::table('all_tag_record')->count();
        return view('rfid.rfidRecord')->with('rfids',$rfids)->with('count',$count);
    }
    
}



?>