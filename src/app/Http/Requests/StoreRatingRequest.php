<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function attributes()
    {
        return [
            'score' => '評価',
        ];
    }

    public function messages()
    {
        return [
            'score.required' => '評価を選択してください。',
            'score.integer'  => '評価は数値で指定してください。',
            'score.min'      => '評価は1以上を選択してください。',
            'score.max'      => '評価は5以下を選択してください。',
        ];
    }
}
