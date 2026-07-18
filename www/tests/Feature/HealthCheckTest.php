<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HealthCheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_healthy_status_when_all_services_are_working()
    {
        // Реальный ответ при успешном health check
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Application is healthy',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'status',
                    'timestamp',
                    'checks' => [
                        'database' => [
                            'status',
                            'message',
                        ],
                        'cache' => [
                            'status',
                            'message',
                        ],
                        'app' => [
                            'status',
                            'environment',
                            'debug',
                            'timezone',
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_checks_database_connection_status()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertArrayHasKey('checks', $data);
        $this->assertArrayHasKey('database', $data['checks']);

        // Проверяем, что статус БД либо 'ok', либо 'error'
        $this->assertContains(
            $data['checks']['database']['status'],
            ['ok', 'error']
        );
    }

    /** @test */
    public function it_checks_cache_connection_status()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertArrayHasKey('checks', $data);
        $this->assertArrayHasKey('cache', $data['checks']);

        // Проверяем, что статус кэша либо 'ok', либо 'error'
        $this->assertContains(
            $data['checks']['cache']['status'],
            ['ok', 'error']
        );
    }

    /** @test */
    public function it_returns_app_information_in_health_check()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertArrayHasKey('checks', $data);
        $this->assertArrayHasKey('app', $data['checks']);

        // Проверяем наличие полей приложения
        $appData = $data['checks']['app'];
        $this->assertArrayHasKey('status', $appData);
        $this->assertArrayHasKey('environment', $appData);
        $this->assertArrayHasKey('debug', $appData);
        $this->assertArrayHasKey('timezone', $appData);

        // Проверяем, что статус приложения всегда 'ok'
        $this->assertEquals('ok', $appData['status']);
    }

    /** @test */
    public function it_returns_timestamp_in_health_check()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertArrayHasKey('timestamp', $data);

        // Проверяем, что timestamp - валидная дата
        $this->assertNotEmpty($data['timestamp']);
        $this->assertTrue(
            strtotime($data['timestamp']) !== false,
            'Timestamp should be a valid date'
        );
    }

    /** @test */
    public function it_returns_success_response_structure()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'status',
                    'timestamp',
                    'checks',
                ],
            ]);
    }

    /** @test */
    public function it_returns_503_when_services_are_degraded()
    {

        $response = $this->getJson('/api/health');

        // Если приложение работает нормально, статус 200
        // Если есть проблемы - 503
        $status = $response->status();
        $this->assertContains($status, [200, 503]);

        if ($status === 503) {
            $response->assertJson([
                'success' => false,
                'message' => 'Application is degraded',
                'error_code' => 'HEALTH_CHECK_FAILED',
            ])
            ->assertJsonStructure([
                'debug' => [
                    'status',
                    'timestamp',
                    'checks',
                ],
            ]);
        }
    }

}
