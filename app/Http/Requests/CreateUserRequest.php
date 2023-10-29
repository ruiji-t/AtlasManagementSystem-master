<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    /* 生年月日の変数 */
    public function getValidatorInstance()
    {
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        $datetime = $old_year .'-'. $old_month .'-'. $old_day ;

        $this->merge([
            'datetime_validation' => $datetime,
        ]);

        return parent::getValidatorInstance();
    }

    public function rules()
    {
        return [
            // ユーザーの新規登録のバリデーション
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => 'required|email|unique:users|max:100',
            'sex' => 'required|in:1,2,3',
            'datetime_validation' => 'required|date|after:1999-12-31|before:tomorrow',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed',
            'password_confirmation' => 'required|min:8|max:30'
        ];

    }

    public function messages(){
        return [
            "required" => "※必須項目です",
            "email" => "※メールアドレスの形式で入力してください",
            "regex" => "※全角カタカナで入力してください",
            "string" => "※文字で入力してください",
            "max" => "※30文字以内で入力してください",
            "over_name.max" => "※10文字以内で入力してください",
            "under_name.max" => "※10文字以内で入力してください",
            "min" => "※8文字以上で入力してください",
            "mail_address.max" => "※100文字以内で入力してください",
            "unique" => "※登録済みのメールアドレスは無効です",
            "confirmed" => "※パスワードが一致しません",
            "datetime_validation.date" => "※有効な日付に直してください",
            "datetime_validation.after" => "※2000年1月1日から今日までの日付を入力してください",
            "datetime_validation.before" => "※2000年1月1日から今日までの日付を入力してください"
        ];
    }
}
