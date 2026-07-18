<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_lead()
    {
        $data = [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'ivan@yandex.ru',
            'comment' => 'Тестовый комментарий',
        ];

        $response = $this->postJson('/api/contact', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Заявка успешно создана',
            ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Иван Иванов',
            'email' => 'ivan@yandex.ru',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_for_lead_creation()
    {
        $response = $this->postJson('/api/contact', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error_code' => 'VALIDATION_ERROR',
            ])
            ->assertJsonStructure([
                'errors' => [
                    'name',
                ],
            ]);
    }

    /** @test */
    public function it_validates_email_format_for_lead_creation()
    {
        $data = [
            'name' => 'Иван Иванов',
            'email' => 'invalid-email',
        ];

        $response = $this->postJson('/api/contact', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                ],
            ]);
    }

    /** @test */
    public function it_validates_phone_format_for_lead_creation()
    {
        $data = [
            'name' => 'Иван Иванов',
            'phone' => 'invalid-phone',
        ];

        $response = $this->postJson('/api/contact', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'phone',
                ],
            ]);
    }

    /** @test */
    public function it_validates_comment_length_for_lead_creation()
    {
        $data = [
            'name' => 'Иван Иванов',
            'comment' => str_repeat('a', 1001),
        ];

        $response = $this->postJson('/api/contact', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'comment',
                ],
            ]);
    }

    /** @test */
    public function it_can_get_metrics_with_leads_list()
    {
        Lead::factory()->count(5)->create();

        $response = $this->getJson('/api/metrics');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Список лидов получен успешно',
            ])
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'phone',
                            'email',
                            'comment',
                            'created_at',
                            'ai_analysis',
                        ],
                    ],
                    'meta' => [
                        'total',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_returns_empty_list_when_no_leads()
    {
        $response = $this->getJson('/api/metrics');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'data' => [],
                    'meta' => [
                        'total' => 0,
                    ],
                ],
            ]);
    }
}
