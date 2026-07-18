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
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не может превышать 255 символов.',
            'name.min' => 'Поле "Имя" должно содержать минимум 2 символа.',
            'name.regex' => 'Поле "Имя" может содержать только буквы, пробелы и дефисы.',

            // Phone
            'phone.string' => 'Поле "Телефон" должно быть строкой.',
            'phone.max' => 'Поле "Телефон" не может превышать 20 символов.',
            'phone.regex' => 'Неверный формат номера телефона.',
            'phone.min' => 'Поле "Телефон" должно содержать минимум 7 символов.',

            // Email
            'email.string' => 'Поле "Email" должно быть строкой.',
            'email.email' => 'Введите корректный email адрес.',
            'email.max' => 'Поле "Email" не может превышать 255 символов.',

            // Comment
            'comment.string' => 'Поле "Комментарий" должно быть строкой.',
            'comment.max' => 'Поле "Комментарий" не может превышать 1000 символов.',
            'comment.min' => 'Поле "Комментарий" должно содержать минимум 3 символа.',
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
            'message' => 'Ошибка валидации данных',
            'errors' => $validator->errors(),
            'error_code' => 'VALIDATION_ERROR',
        ], 422));
    }

}
