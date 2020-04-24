<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allrecord extends Model
{
    // protected $guarded = [];
    public $timestamps = true;
    
    protected $fillable = [
        'tag_id','tag_rssi','tag_count','reader_record_time','reader_ip',
    ];
    
}

?>