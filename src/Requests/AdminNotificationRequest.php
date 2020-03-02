<?php

namespace Oxygencms\Notifications\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminNotificationRequest extends FormRequest
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
            'description' => 'string',
            'template' => 'nullable|string',
            'layout' => 'nullable|string',
            'channels' => 'required|array',
            'subject' => 'array|distinct',
            'subject.*' => 'required|string',
        ];
    }
}
