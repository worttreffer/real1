<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'name', 'admission', 'begon', 'valid_from', 'valid_to',
    ];
    //
}
