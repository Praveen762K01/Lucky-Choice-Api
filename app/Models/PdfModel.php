<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfModel extends Model
{
    use HasFactory;
    protected $table = "pdf";
    protected $fillable = [
        "privacy",
        "tc",
        "faq",
        "about",
        "contact"
    ];
}
