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
use DB;
use DateTime;

class apiController extends Controller
{
    public function store(Request $request){ 

        $count = Rfid::count(); //check total record number
              
        if (isset($_POST['Tag_id']) && isset($_POST['Tag_pc'])&&
        isset($_POST['Tag_count']) && isset($_POST['Tag_rssi'])&&
        isset($_POST['Reader_id']) && isset($_POST['Reader_record_time'])&&
        isset($_POST['Reader_ip'])) {
                //debug use
                var_dump($_POST['Tag_id']);
                var_dump($_POST['Tag_pc']);
                var_dump($_POST['Tag_count']);
                var_dump($_POST['Tag_rssi']);
                var_dump($_POST['Reader_id']);
                var_dump($_POST['Reader_record_time']);
                var_dump($_POST['Reader_ip']);

                //For add a new tag to the all testing tag table
                $record_check =  DB::table('all_tag_record')->where('tag_id','=',$_POST['Tag_id'])->first();
                if($record_check == null){
                    $data = array(
                        'tag_id' => $_POST['Tag_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    DB::table('all_tag_record')->insert($data);
                }
                
                
                //DB::table('store_all_tag_record')->truncate(); //clean the table 
                
                //Clean the data within 1 minutes
                $Onemin = new DateTime;
                $Onemin->modify('-1 minutes');
                $Oneminformatted = $Onemin->format('Y-m-d H:i:s');
                Onemins::where('created_at', '<=', $Oneminformatted)->delete();
                
                Onemins::create([
                    'tag_id' => $_POST['Tag_id'],
                    'tag_rssi' => $_POST['Tag_rssi'],
                    'tag_count' => $_POST['Tag_count'],                                               
                    'reader_record_time' => $_POST['Reader_record_time'],
                    'reader_ip' => $_POST['Reader_ip'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                //Clean the data within 5 minutes
                $Fivemin = new DateTime;
                $Fivemin->modify('-5 minute');
                $Fiveminformatted = $Fivemin->format('Y-m-d H:i:s');
                Fivemins::where('created_at', '<=', $Fiveminformatted)->delete();
                
                Fivemins::create([
                    'tag_id' => $_POST['Tag_id'],
                    'tag_rssi' => $_POST['Tag_rssi'],
                    'tag_count' => $_POST['Tag_count'],                                               
                    'reader_record_time' => $_POST['Reader_record_time'],
                    'reader_ip' => $_POST['Reader_ip'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                //Clean the data within 15 minutes
                $Fifteenmin = new DateTime;
                $Fifteenmin->modify('-15 minutes');
                $Fifteenminformatted = $Fifteenmin->format('Y-m-d H:i:s');
                Fifteenmins::where('created_at', '<=', $Fifteenminformatted)->delete();
                
                Fifteenmins::create([
                    'tag_id' => $_POST['Tag_id'],
                    'tag_rssi' => $_POST['Tag_rssi'],
                    'tag_count' => $_POST['Tag_count'],                                               
                    'reader_record_time' => $_POST['Reader_record_time'],
                    'reader_ip' => $_POST['Reader_ip'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                 //Clean the data within 30 minutes
                 $Halfhour = new DateTime;
                 $Halfhour->modify('-30 minutes');
                 $Halfhourformatted = $Halfhour->format('Y-m-d H:i:s');
                 Halfhour::where('created_at', '<=', $Halfhourformatted)->delete();
                 
                 Halfhour::create([
                     'tag_id' => $_POST['Tag_id'],
                     'tag_rssi' => $_POST['Tag_rssi'],
                     'tag_count' => $_POST['Tag_count'],                                               
                     'reader_record_time' => $_POST['Reader_record_time'],
                     'reader_ip' => $_POST['Reader_ip'],
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
                 
                  //Clean the data within 1 hour
                  $Onehour = new DateTime;
                  $Onehour->modify('-60 minutes');
                  $Onehourformatted = $Onehour->format('Y-m-d H:i:s');
                  Onehour::where('created_at', '<=', $Onehourformatted)->delete();
                  
                  Onehour::create([
                      'tag_id' => $_POST['Tag_id'],
                      'tag_rssi' => $_POST['Tag_rssi'],
                      'tag_count' => $_POST['Tag_count'],                                               
                      'reader_record_time' => $_POST['Reader_record_time'],
                      'reader_ip' => $_POST['Reader_ip'],
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s')
                  ]);          
                
                //For save all tag data (line graph use)        
                // $data = array(
                //     'tag_id' => $_POST['Tag_id'],
                //     'tag_rssi' => $_POST['Tag_rssi'],
                //     'tag_count' => $_POST['Tag_count'],                                               
                //     'reader_record_time' => $_POST['Reader_record_time'],
                //     'reader_ip' => $_POST['Reader_ip'],
                //     'created_at' => date('Y-m-d H:i:s'),
                //     'updated_at' => date('Y-m-d H:i:s')
                // );
                // DB::table('store_all_tag_record')->insert($data);                              

                // $Tag_id = $_POST['Tag_id'];
                // $Tag_pc = $_POST['Tag_pc'];
                // $Tag_count = $_POST['Tag_count'];
                // $Tag_rssi = $_POST['Tag_rssi'];
                // $Reader_id = $_POST['Reader_id'];
                // $Reader_record_time =$_POST['Reader_record_time'];
                // $Reader_ip =$_POST['Reader_ip'];
                
                $record_check = Rfid::where('tag_id','=',$_POST['Tag_id'])
                                    ->where('reader_ip','=',$_POST['Reader_ip'])
                                    ->first();
                                   
                
                if($record_check!= null){ //existed to update the record 
                    $data = array(
                        "tag_id"=>$_POST['Tag_id'],
                        "tag_pc_value"=>$_POST['Tag_pc'],
                        "tag_count"=>$_POST['Tag_count'],
                        "tag_rssi"=>$_POST['Tag_rssi'],
                        "reader_antenna"=>$_POST['Reader_id'],
                        "reader_record_time"=>$_POST['Reader_record_time'],
                        "reader_ip"=>$_POST['Reader_ip'],
                    );                   

                    Rfid::where('tag_id','=',$_POST['Tag_id'])
                    ->where('reader_ip','=',$_POST['Reader_ip'])
                    ->update($data);
                }
                else{       //a new record              
                    Rfid::create([
                        'tag_id' => $_POST['Tag_id'],
                        'tag_pc_value' => $_POST['Tag_pc'],
                        'tag_count' => $_POST['Tag_count'],
                        'tag_rssi' => $_POST['Tag_rssi'],
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