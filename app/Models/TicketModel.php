<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    use HasFactory;
    protected $table = "tickets";
    protected $fillable = [
        "ticket_name",
        "ticket_price",
        "lot_number",
        "prize_amount",
        "winner_count",
        "max_purchase_limit",
        "color",
        "purchase_count",
        "algo_winner",
        "manual_winner",
        "is_visible",
        "disable",
    ];
}
