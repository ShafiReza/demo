<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','provider_id','amount', 'description', 'type', 'commission_rate', 'commission', 'updated_balance'];

    // Define a relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    // Scope for retrieving sales payments
    public function scopeSalesPayments($query)
    {
        return $query->where('type', 'sales');
    }

    // Scope for retrieving receive payments
    public function scopeReceivePayments($query)
    {
        return $query->where('type', 'receive');
    }
}

