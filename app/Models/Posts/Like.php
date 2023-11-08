<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    // likesテーブルの該当の投稿の数
    public function likeCounts($post_id){
        return $this->where('like_post_id', $post_id)->get()->count();
    }


}
