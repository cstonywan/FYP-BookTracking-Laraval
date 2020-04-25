<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [        
        'ReaderA_ip',
        'ReaderB_ip',
        'ReaderC_ip',
        'ReaderD_ip',
        'distance_A',
        'distance_B',
        'p',
        'n',
    ];
}
