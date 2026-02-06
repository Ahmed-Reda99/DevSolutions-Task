<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetMessagesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or auth check
    }

    public function validationData(): array
    {
        return array_merge(
            $this->all(),
            $this->route()->parameters()
        );
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->whereNot('id', $this->user()->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'receiver_id.required' => 'The receiver field is required.',
            'receiver_id.integer' => 'The receiver field must be an integer.',
            'receiver_id.exists' => 'The selected receiver is invalid.',
        ];
    }
}
