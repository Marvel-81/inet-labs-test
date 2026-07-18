<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LeadRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\+\d\s\-\(\)]+$/',
                'min:7'
            ],
            'email' => [
                'nullable',
                'string',
                'email:rfc,dns',
                'max:255'
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000',
                'min:3'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Name
            'name.required' => __('messages.validation.name.required'),
            'name.string' => __('messages.validation.name.string'),
            'name.max' => __('messages.validation.name.max'),
            'name.min' => __('messages.validation.name.min'),
            'name.regex' => __('messages.validation.name.regex'),

            // Phone
            'phone.string' => __('messages.validation.phone.string'),
            'phone.max' => __('messages.validation.phone.max'),
            'phone.regex' => __('messages.validation.phone.regex'),
            'phone.min' => __('messages.validation.phone.min'),

            // Email
            'email.string' => __('messages.validation.email.string'),
            'email.email' => __('messages.validation.email.email'),
            'email.max' => __('messages.validation.email.max'),

            // Comment
            'comment.string' => __('messages.validation.comment.string'),
            'comment.max' => __('messages.validation.comment.max'),
            'comment.min' => __('messages.validation.comment.min'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'phone' => $this->phone ? trim($this->phone) : null,
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            'comment' => $this->comment ? trim($this->comment) : null,
        ]);
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => __('messages.validation_error'),
            'errors' => $validator->errors(),
            'error_code' => 'VALIDATION_ERROR',
        ], 422));
    }
}
