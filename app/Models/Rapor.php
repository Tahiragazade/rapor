<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    use HasFactory;
    protected $fillable = [
        'wo',
        'user',
        'parts_cost',
        'payment_type',
        'work_date',
    ];
}
