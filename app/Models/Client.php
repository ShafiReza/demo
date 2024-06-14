<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'client';
    protected $fillable = [
        'id',
        'provider_name',
        'provider_type',
        'commission_rate',
        'opening_balance',
        'receive',
        'sales' ,
        'note',
        'active',
    ];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

}
