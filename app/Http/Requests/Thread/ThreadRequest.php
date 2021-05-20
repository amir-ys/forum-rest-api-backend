<?php

namespace App\Http\Requests\Thread;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
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
        if ($this->has('best_answer_id')) {
            $rules = ['best_answer_id' => 'required'];
        } else {
            $rules = [
                'title' => 'required|min:3|max:190',
                'content' => 'required',
                'channel_id' => 'required|exists:channels,id'
            ];
        }

        return $rules;
    }
}
