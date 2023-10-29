<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
    public function rules()
    {
        // 投稿内容のバリデーション
        return [
            'post_category_id' => 'required|exists:sub_categories,id',
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];
    }

    public function messages(){
        return [
            'post_category_id.required' => 'カテゴリーを選択してください。',
            'post_category_id.exists' => 'このカテゴリーは存在しません。',
            'string' => '文字で入力してください。',
            'post_title.required' => 'タイトルを入力してください。',
            'post_body.required' => '投稿内容を入力してください。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.max' => '最大文字数は5000文字です。',
        ];
    }
}
