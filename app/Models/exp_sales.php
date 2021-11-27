<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class exp_sales extends Model
{
    use HasFactory;
    public function category(){
        return $this->hasOne(exp_categories::class, 'id', 'category_id');
    }
    public function getEntryDateAttribute($value){
        return Carbon::parse($value)->format('M d, Y');
    }
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('M d, Y');
    }
}
