<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
        'km', 'km_post_code', 'city', 'postcode', 'state', 'region', 'country', 'valid_from', 'valid_to'
    ];//
}
