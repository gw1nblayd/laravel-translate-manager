<?php

namespace Gw1nblayd\TranslateManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRemoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'block' => 'required|string',
            'key'   => 'required|string',
        ];
    }
}