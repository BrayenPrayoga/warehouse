<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SewaGudang extends Model
{
    use HasFactory;

    protected $table = 'sewa_gudang';
    
    protected $guarded = [];
}
