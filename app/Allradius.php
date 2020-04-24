<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allradius extends Model
{
    //
    protected $table = 'allradius';
    protected $fillable = [
        'tag_id','radius','reader_ip',
    ];
}
