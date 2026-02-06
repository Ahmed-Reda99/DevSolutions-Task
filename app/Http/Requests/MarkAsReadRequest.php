<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MarkAsReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return array_merge(
            $this->all(),
            $this->route()->parameters()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message_id' => [
                'required',
                'integer',
                Rule::exists('messages', 'id')
                    ->where('status', Status::delivered->value)
                    ->where('receiver_id', $this->user()->id)],
        ];
    }

    public function messages()
    {
        return [
            'message_id.required' => 'The message field is required.',
            'message_id.integer' => 'The message field must be an integer.',
            'message_id.exists' => 'The selected message is invalid or you are not the receiver of this message or you have already marked this message as read.',
        ];
    }
}
