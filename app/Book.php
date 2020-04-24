<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function rfid()
    {
        return $this->hasOne(Rfid::class);
    }
}
