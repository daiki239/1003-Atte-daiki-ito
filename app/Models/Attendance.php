<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{


    // テーブル名の指定


 

  
    protected $fillable = [
       'id',  'user_id','date','start_time','end_time'
    ];


    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function Rest(){
        return $this->hasMany('App\Models\Attendance');
    }

    public function getUsers()
    { 
        return $this
         ->with('users')
         ->whare('id','>','1')
         ->get();

    }
}