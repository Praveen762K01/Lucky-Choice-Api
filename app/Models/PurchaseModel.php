<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    use HasFactory;
    protected $table = "purcahse";
    protected $fillable = [
        "user_id",
        "lot_number",
        "ticket_id",
        "serial_no",
        "is_paid",
        "ticket_price",
        "prize",
        "name",
        "user_name",
        "number"
    ];
}
