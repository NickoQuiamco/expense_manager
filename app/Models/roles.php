<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class roles extends Model
{
    use HasFactory;
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('M d, Y');
    }
}
