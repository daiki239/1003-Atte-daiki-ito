<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
   use HasFactory;
    protected $fillable = ['user_id', 'worktaime_id', 'break_in', 'break_out'];


 public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}