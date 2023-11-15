<?php
namespace App\Searchs;

use App\Models\Users\User;

// SelectNameDetailsクラスで、インターフェイスDisplayUsers内で指定したresultUsersメソッドを実装
class SelectNameDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  // カテゴリー：名前で選択され、subjectsがNULLでなかったときの抽出

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }



    $users = User::with('subjects')
    ->where(function($q) use ($keyword){ // 名前であいまい検索
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    ->whereHas('subjects', function($q) use ($subjects){
      $q->whereIn('subjects.id', $subjects);   // チェックを入れた科目で検索(ひとつでも該当すれば抽出)
    })
    ->orderBy('over_name_kana', $updown)->get();
    return $users;
  }

}
