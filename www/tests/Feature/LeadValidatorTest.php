<?php

namespace Tests\Unit\Validators;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadValidatorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_name_required()
    {
        $validator = Validator::make(
            ['name' => ''],
            ['name' => 'required|string|min:2|max:255']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_name_min_length()
    {
        $validator = Validator::make(
            ['name' => 'A'],
            ['name' => 'required|string|min:2|max:255']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_name_max_length()
    {
        $validator = Validator::make(
            ['name' => str_repeat('a', 256)],
            ['name' => 'required|string|min:2|max:255']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_email_format()
    {
        $validator = Validator::make(
            ['email' => 'invalid-email'],
            ['email' => 'nullable|email|max:255']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_valid_email()
    {
        $validator = Validator::make(
            ['email' => 'valid@example.com'],
            ['email' => 'nullable|email|max:255']
        );

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_validates_phone_format()
    {
        $validator = Validator::make(
            ['phone' => 'invalid-phone'],
            ['phone' => 'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('phone', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_valid_phone()
    {
        $validPhones = [
            '+7 (999) 123-45-67',
            '+79991234567',
            '8-999-123-45-67',
            '(999) 123-45-67',
        ];

        foreach ($validPhones as $phone) {
            $validator = Validator::make(
                ['phone' => $phone],
                ['phone' => 'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/']
            );
            $this->assertFalse($validator->fails(), "Phone {$phone} should be valid");
        }
    }

    /** @test */
    public function it_validates_comment_max_length()
    {
        $validator = Validator::make(
            ['comment' => str_repeat('a', 1001)],
            ['comment' => 'nullable|string|max:1000']
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('comment', $validator->errors()->toArray());
    }

    /** @test */
    public function it_validates_all_fields_together()
    {
        $data = [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'ivan@example.com',
            'comment' => 'Тестовый комментарий',
        ];

        $rules = [
            'name' => 'required|string|min:2|max:255',
            'phone' => 'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
            'email' => 'nullable|email|max:255',
            'comment' => 'nullable|string|max:1000',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertFalse($validator->fails());
    }
}
