<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'id_country',
        'id_business_number',
        'id_campaign_code',
        'id_keyword',
    ];
}
