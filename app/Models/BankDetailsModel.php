<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetailsModel extends Model
{
    use HasFactory;
    protected $table = "bank_details";
    protected $fillable = [
        "user_id",
        "bank_name",
        "name",
        "acc_no",
        "ifsc",
    ];
}
