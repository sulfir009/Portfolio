<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'identification_number',
        'phone',
        'address',
    ];


    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
