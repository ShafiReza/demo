<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [

        'from_provider',
        'to_provider',
        'transfer_amount',
        'note',
    ];

    public function fromProvider()
    {
        return $this->belongsTo(Provider::class, 'from_provider');
    }

    public function toProvider()
    {
        return $this->belongsTo(Provider::class, 'to_provider');
    }
}
