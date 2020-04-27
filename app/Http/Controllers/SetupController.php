<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;

class SetupController extends Controller
{
    
    public function store(Request $request)
    {
        //return dd($request->readerA_ip);
        $count = Setting::count();

        if($count == 0){
            Setting::create([           
                'ReaderA_ip'=> $request->readerA_ip,
                'ReaderB_ip'=> $request->readerB_ip,
                'ReaderC_ip'=> $request->readerC_ip,
                'ReaderD_ip'=> $request->readerD_ip,
                'distance_A'=> $request->distance_a,
                'distance_B'=> $request->distance_b,
                'p'=> $request->p,
                'n'=> $request->n,
            ]);
        }
        $check=Setting::find(1);
        $check->ReaderA_ip = $request->readerA_ip;
        $check->ReaderB_ip = $request->readerB_ip;
        $check->ReaderC_ip = $request->readerC_ip;
        $check->ReaderD_ip = $request->readerD_ip;
        $check->distance_A = $request->distance_a;
        $check->distance_B = $request->distance_b;
        $check->p = $request->p;
        $check->n = $request->n;
        $check->save();

        $rfids= DB::table('all_tag_record')->get();
        $count =DB::table('all_tag_record')->count();
        $record = Setting::find(1);

        Session::flash('message', 'RFID setting has been updated.');   
       
        return view('rfid.rfidSetting')
                ->with('rfids',$rfids)
                ->with('count',$count)
                ->with('record',$record);   
                  
    }
    public function showall(){ 
        $check_count = Setting::count();
        
        if($check_count == 0){           
            Setting::create([           
                'ReaderA_ip'=> '192.168.1.140',
                'ReaderB_ip'=> '192.168.1.141',
                'ReaderC_ip'=> '192.168.1.142',
                'ReaderD_ip'=> '192.168.1.143',
                'distance_A'=> 50,
                'distance_B'=> 50, 
                'p' => -64,
                'n' => 2,               
            ]);
        }

        $rfids= DB::table('all_tag_record')->get();
        $count =DB::table('all_tag_record')->count();
        $record = Setting::find(1);
        
        return view('rfid.rfidSetting')
                ->with('rfids',$rfids)
                ->with('count',$count)
                ->with('record',$record);
    }
}