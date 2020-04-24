<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rfid extends Model
{
    //
    protected $fillable = [
        'tag_id','tag_pc_value','tag_count','tag_rssi','reader_antenna','reader_record_time','reader_ip',
    ];
}
