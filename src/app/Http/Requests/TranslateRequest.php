<?php

namespace Gw1nblayd\TranslateManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'lang'  => 'required|string',
            'block' => 'required|string',
            'key'   => 'required|string',
            'value' => 'required|string',
        ];
    }
}