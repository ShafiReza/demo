<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'provider_name',
        'provider_type',
        'opening_balance',
        'receive',
        'note',
        'active',
    ];
    public function payments(){
        return $this->hasMany(ProviderPayment::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
