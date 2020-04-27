<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fifteenmins extends Model
{
    //
    protected $fillable = [
        'tag_id', 
        'tag_rssi', 
        'tag_count', 
        'reader_record_time', 
        'reader_ip', 
        'created_at', 
        'updated_at', 
    ];
}
