<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

/**
 * Маршрут проверки состояния системы
 */
class HealthPathAnnotation
{
    #[OA\Get(
        path: "/api/health",
        operationId: "checkHealth",
        tags: ["Система"],
        summary: "Проверка работоспособности API и зависимостей",
        description: "Выполняет проверку подключения к БД, кэшу и выводит общую информацию о приложении.",
        responses: [
            new OA\Response(
                response: 200,
                description: "Сервис полностью работоспособен (All checks passed)",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Application is healthy"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "status", type: "string", example: "ok"),
                                new OA\Property(property: "timestamp", type: "string", format: "date-time", example: "2026-07-18T10:25:07.363922Z"),
                                new OA\Property(
                                    property: "checks",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "database",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "ok"),
                                                new OA\Property(property: "message", type: "string", example: "Database connection successful")
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "cache",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "ok"),
                                                new OA\Property(property: "message", type: "string", example: "Cache connection successful")
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "app",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "ok"),
                                                new OA\Property(property: "environment", type: "string", example: "local"),
                                                new OA\Property(property: "debug", type: "boolean", example: true),
                                                new OA\Property(property: "timezone", type: "string", example: "UTC")
                                            ]
                                        )
                                    ]
                                )
                            ]
                        )
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 503,
                description: "Частичный сбой (Degraded mode). Одна из систем (БД или кэш) недоступна.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Application is degraded"),
                        new OA\Property(property: "error_code", type: "string", example: "HEALTH_CHECK_FAILED"),
                        new OA\Property(
                            property: "debug",
                            type: "object",
                            properties: [
                                new OA\Property(property: "status", type: "string", example: "degraded"),
                                new OA\Property(property: "timestamp", type: "string", format: "date-time", example: "2026-07-18T10:27:18.058190Z"),
                                new OA\Property(
                                    property: "checks",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "database",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "error"),
                                                new OA\Property(property: "message", type: "string", example: "Database connection failed")
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "cache",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "ok"),
                                                new OA\Property(property: "message", type: "string", example: "Cache connection successful")
                                            ]
                                        ),
                                        new OA\Property(
                                            property: "app",
                                            type: "object",
                                            properties: [
                                                new OA\Property(property: "status", type: "string", example: "ok"),
                                                new OA\Property(property: "environment", type: "string", example: "local"),
                                                new OA\Property(property: "debug", type: "boolean", example: true),
                                                new OA\Property(property: "timezone", type: "string", example: "UTC")
                                            ]
                                        )
                                    ]
                                )
                            ]
                        )
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 500,
                description: "Критическая ошибка выполнения health check",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            )
        ]
    )]
    public function checkHealth()
    {
    }
}
