<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

/**
 * Схемы данных (Data Models / Components Schemas)
 */
class SchemasAnnotation
{
    #[OA\Schema(
        schema: "SuccessResponse",
        required: ["success"],
        properties: [
            new OA\Property(property: "success", type: "boolean", example: true),
            new OA\Property(property: "message", type: "string"),
            new OA\Property(property: "data", type: "object", nullable: true)
        ]
    )]
    public function successResponseSchema()
    {
    }

    #[OA\Schema(
        schema: "ErrorResponse",
        required: ["success"],
        properties: [
            new OA\Property(property: "success", type: "boolean", example: false),
            new OA\Property(property: "message", type: "string"),
            new OA\Property(property: "error_code", type: "string"),
            new OA\Property(property: "debug", type: "string", nullable: true)
        ]
    )]
    public function errorResponseSchema()
    {
    }

    #[OA\Schema(
        schema: "ValidationErrorResponse",
        required: ["success", "message", "errors", "error_code"],
        properties: [
            new OA\Property(property: "success", type: "boolean", example: false),
            new OA\Property(property: "message", type: "string", example: "Ошибка валидации данных"),
            new OA\Property(
                property: "errors",
                type: "object",
                additionalProperties: new OA\AdditionalProperties(
                    type: "array",
                    items: new OA\Items(type: "string")
                ),
                example: [
                    "email" => ["Введите корректный email адрес."],
                    "name" => ["Поле name обязательно для заполнения."]
                ]
            ),
            new OA\Property(property: "error_code", type: "string", example: "VALIDATION_ERROR")
        ]
    )]
    public function validationErrorResponseSchema()
    {
    }

    #[OA\Schema(
        schema: "LeadRequest",
        required: ["name"],
        properties: [
            new OA\Property(property: "name", type: "string", minLength: 2, maxLength: 255, example: "Иван Иванов"),
            new OA\Property(property: "phone", type: "string", pattern: "^\\+?[0-9\\s\\-()]+$", maxLength: 20, nullable: true),
            new OA\Property(property: "email", type: "string", format: "email", maxLength: 255, nullable: true),
            new OA\Property(property: "comment", type: "string", maxLength: 1000, nullable: true)
        ]
    )]
    public function leadRequestSchema()
    {
    }

    #[OA\Schema(
        schema: "LeadResource",
        properties: [
            new OA\Property(property: "id", type: "integer", example: 18),
            new OA\Property(property: "name", type: "string", example: "Иван Иванов"),
            new OA\Property(property: "phone", type: "string", nullable: true, example: "+7 (999) 123-45-67"),
            new OA\Property(property: "email", type: "string", format: "email", nullable: true, example: "ivan@example.com"),
            new OA\Property(property: "comment", type: "string", nullable: true, example: "Хочу заказать услугу"),
            new OA\Property(property: "created_at", type: "string", format: "date-time", example: "18.07.2026 06:23"),
            new OA\Property(
                property: "ai_analysis",
                type: "array",
                items: new OA\Items(ref: "#/components/schemas/AiAnalysis")
            )
        ]
    )]
    public function leadResourceSchema()
    {
    }

    #[OA\Schema(
        schema: "LeadCollectionResource",
        allOf: [
            new OA\Schema(ref: "#/components/schemas/SuccessResponse"),
            new OA\Schema(
                type: "object",
                properties: [
                    new OA\Property(
                        property: "data",
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "data",
                                type: "array",
                                items: new OA\Items(ref: "#/components/schemas/LeadResource"),
                                example: [
                                    [
                                        "id" => 18,
                                        "name" => "Тест",
                                        "phone" => "+7 (999) 123-45-67",
                                        "email" => "test@yandex.ru",
                                        "comment" => "Тестовый комментарий",
                                        "created_at" => "18.07.2026 06:23",
                                        "ai_analysis" => [
                                            [
                                                "id" => 6,
                                                "parameter" => "Тональность",
                                                "decoded_value" => "Тональность не проанализирована",
                                                "created_at" => "18.07.2026 06:25"
                                            ]
                                        ]
                                    ]
                                ]
                            ),
                            new OA\Property(
                                property: "meta",
                                type: "object",
                                properties: [
                                    new OA\Property(property: "total", type: "integer", example: 18)
                                ]
                            )
                        ]
                    )
                ]
            )
        ]
    )]
    public function leadCollectionResourceSchema()
    {
    }

    #[OA\Schema(
        schema: "AiAnalysis",
        properties: [
            new OA\Property(property: "id", type: "integer", example: 6),
            new OA\Property(property: "parameter", type: "string", example: "Тональность"),
            new OA\Property(property: "decoded_value", type: "string", example: "Тональность не проанализирована"),
            new OA\Property(property: "created_at", type: "string", format: "date-time", example: "18.07.2026 06:25")
        ]
    )]
    public function aiAnalysisSchema()
    {
    }

    #[OA\Schema(
        schema: "HealthCheckResponse",
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
        ]
    )]
    public function healthCheckResponseSchema()
    {
    }

    #[OA\Schema(
        schema: "HealthCheckDegradedResponse",
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
        ]
    )]
    public function healthCheckDegradedResponseSchema()
    {
    }
}
