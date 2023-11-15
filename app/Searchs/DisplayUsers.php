<?php
namespace App\Searchs;

// 改修課題：選択科目の検索機能
// インターフェイス　（クラスで実装するresultUsersメソッドを指定）
interface DisplayUsers{
public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
}
