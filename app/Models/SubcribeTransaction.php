<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcribeTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_amount',
        'is_paid',
        'subcription_start_date',
        'proof',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
