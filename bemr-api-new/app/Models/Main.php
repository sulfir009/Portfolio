<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{
    use SoftDeletes;

    protected $table = 'main';

    protected $fillable = [
        'hash',
        'campaigns_key_binom',
        'aff_company_id',
        'pid',
        'id_services',
        'campaign_hash',
    ];
}
