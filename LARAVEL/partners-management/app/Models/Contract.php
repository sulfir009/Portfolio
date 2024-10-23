<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'contract_date',
        'amount',
    ];

    // ����� � ����������
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // ����� � ������ ����������
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }
}
