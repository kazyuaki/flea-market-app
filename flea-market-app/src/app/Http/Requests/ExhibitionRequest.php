<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png',
            'categories' => 'required|array|min:1',
            'condition' => 'required|integer',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'detail.required' => '商品説明は必須です。',
            'detail.max' => '商品説明は255文字以内で入力してください。',
            'img.required' => '商品画像のアップロードは必須です。',
            'img.image' => 'アップロードされたファイルは画像である必要があります。',
            'img.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',
            'categories.required' => '商品のカテゴリーを1つ以上選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'price.required' => '販売価格は必須です。',
            'price.integer' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
        ];
    }
}
