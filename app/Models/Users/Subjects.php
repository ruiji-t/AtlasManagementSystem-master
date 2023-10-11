<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    // subjectsテーブル-usersテーブル（多対多）のリレーション
    public function users(){
        return $this->belongsToMany('App\Models\Users\User','subject_users','subject_id','user_id')-> withTimestamps();// リレーションの定義
    }
}
