<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerSelectionModel extends Model
{
    use HasFactory;
    protected $table = "winner_selection";
    protected $fillable = [
        "user_id",
        "ticket_id",
        "purchase_id",
        "winner",
        "serial_no",
        "name",
        "number",
        "price",
        "prize"
    ];
}
