<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpiDetailsModel extends Model
{
    use HasFactory;
    protected $table = "upi_details";
    protected $fillable = [
        "user_id",
        "name",
        "upi_number",
        "upi_id",
    ];
}
