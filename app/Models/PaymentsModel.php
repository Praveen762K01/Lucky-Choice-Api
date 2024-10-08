<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsModel extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $fillable = [
        "user_id",
        "amount",
        "transaction_id",
        "message",
    ];
}
