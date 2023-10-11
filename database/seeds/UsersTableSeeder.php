<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // usersテーブルの初期データの登録
        DB::table('users')->insert([
            ['over_name' => '東',
             'under_name' => '京',
             'over_name_kana' => 'トウ',
             'under_name_kana' => 'キョウ',
             'mail_address' => 'ttt@ttt',
             'sex' => '2',
             'birth_day' => '2000/01/01',
             'role' => '2',
             'password' => Hash::make('password'),
             ]
             ,
             ['over_name' => '埼',
             'under_name' => '玉',
             'over_name_kana' => 'サイ',
             'under_name_kana' => 'タマ',
             'mail_address' => 'sss@sss',
             'sex' => '3',
             'birth_day' => '2010/08/01',
             'role' => '1',
             'password' => Hash::make('password'),
             ]
             ,
             ['over_name' => '神奈',
             'under_name' => '川',
             'over_name_kana' => 'カナ',
             'under_name_kana' => 'ガワ',
             'mail_address' => 'kkk@kkk',
             'sex' => '1',
             'birth_day' => '2020/12/24',
             'role' => '4',
             'password' => Hash::make('password'),
             ]
        ]);

    }
}
