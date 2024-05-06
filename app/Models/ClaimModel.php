<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimModel extends Model
{
    use HasFactory;

    protected $table = "claim";
    protected $fillable = [
        "user_id",
        "ticket_id",
        "serial_no",
        "amount",
        "is_paid",
        "paid_amount",
        "name",
    ];
}
