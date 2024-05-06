<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = "user";
    protected $fillable = [
        "user_name",
        "mobile",
        "wallet",
        "user_id",
        "refered_by",
        "is_active",
        "ref_paid"
    ];
}
