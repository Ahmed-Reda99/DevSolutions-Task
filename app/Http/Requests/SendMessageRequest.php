<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'integer', Rule::exists('users', 'id')->whereNot('id', $this->user()->id)],
            'message' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'receiver_id.required' => 'The receiver field is required.',
            'receiver_id.integer' => 'The receiver field must be an integer.',
            'receiver_id.exists' => 'The selected receiver is invalid.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message field must be a string.',
        ];
    }
}
