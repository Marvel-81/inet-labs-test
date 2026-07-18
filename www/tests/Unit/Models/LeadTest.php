<?php

namespace Tests\Unit\Models;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_lead()
    {
        $lead = Lead::create([
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'ivan@example.com',
            'comment' => 'Тестовый комментарий',
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
        ]);
    }

    /** @test */
    public function it_requires_name_to_create_lead()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Lead::create([
            'phone' => '+7 (999) 123-45-67',
            'email' => 'ivan@example.com',
        ]);
    }

}
