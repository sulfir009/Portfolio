<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;
    protected $fillable = [
        'binom_click_id',
        'affise_click_id',
        'user_agent',
        'operator',
        'aff_click_id',
        'aff_id',
        'subid1',
        'subid2',
        'subid3',
        'subid4',
        'subid5',
        'is_charged',
        'id_main',
        'external_id'
    ];
}
