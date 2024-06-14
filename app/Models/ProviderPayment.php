<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderPayment extends Model
{
    use HasFactory;
    protected $fillable = ['provider_id', 'amount', 'description', 'type'];

    // Define a relationship with the Provider model
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
