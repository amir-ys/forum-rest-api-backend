<?php

namespace App\Http\Requests\Thread;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'content' => ['required'],
            'thread_id' => ['required'],
            'user_id' => ['required'],
        ];

        if (request()->method == "PATCH") {
            $rules = [
                'content' => ['required'],
            ];
        }

        return $rules;
    }
}
