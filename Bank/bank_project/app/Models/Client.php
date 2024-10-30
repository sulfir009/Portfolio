<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
