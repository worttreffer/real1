<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'admission', 'begin', 'valid_from', 'valid_to'
    ];//
}
