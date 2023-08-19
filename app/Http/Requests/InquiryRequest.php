<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// 追加
use Illuminate\Validation\Rule;

class InquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return trueに変更
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // ここから編集
        return [
            'name'         => ['required', 'string'],
            'email'        => ['required', 'email'],
            'relationship' => ['required', Rule::in(config('relationship'))],
            'content'      => ['required', 'string'],
        ];
        // ここまで編集
    }

    // ここから追加
    public function attributes()
    {
        return [
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'relationship' => '社会の窓が空いている人との関係',
            'content' => '何か伝えたいこと',
        ];
    }
    // ここまで追加
    
}
