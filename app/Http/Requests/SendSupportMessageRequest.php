<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendSupportMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['message' => ['required', 'string', 'max:2000']];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Tulis pesan sebelum mengirim.',
            'message.max' => 'Pesan maksimal 2.000 karakter.',
        ];
    }
}
