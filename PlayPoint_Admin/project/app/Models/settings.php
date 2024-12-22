<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    use HasFactory;

    protected $fillable = ['package_name','refer_points','refer_bonus','daily_spin','daily_scratch','scratch_coins','vpn','vpn_ban','one_device'];
}
