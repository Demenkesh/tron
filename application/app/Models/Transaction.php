<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_id',
        'crypto_amount',
        'amount',
        'address',
        'pkey',
        'success'
    ];
    public function token(){
        return $this->belongsTo(Token::class);
    }

}
