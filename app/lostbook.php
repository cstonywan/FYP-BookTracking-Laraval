<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lostbook extends Model
{
    //
    protected $fillable = [
        'book_id',
        'tag_id', 
        'title'
    ];
}
