<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

/**
 * Маршруты управления лидами
 */
class LeadsPathsAnnotation
{
    #[OA\Post(
        path: "/api/contact",
        operationId: "createLead",
        tags: ["Лиды"],
        summary: "Создание нового лида",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LeadRequest")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Заявка успешно создана",
                content: new OA\JsonContent(ref: "#/components/schemas/SuccessResponse")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации входных данных",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationErrorResponse")
            ),
            new OA\Response(
                response: 500,
                description: "Внутренняя ошибка сервера",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            )
        ]
    )]
    public function createContact()
    {
    }

    #[OA\Get(
        path: "/api/metrics",
        operationId: "getLeadsList",
        tags: ["Лиды"],
        summary: "Получение списка всех лидов с аналитикой",
        responses: [
            new OA\Response(
                response: 200,
                description: "Список получен",
                content: new OA\JsonContent(ref: "#/components/schemas/LeadCollectionResource")
            ),
            new OA\Response(
                response: 500,
                description: "Ошибка получения списка",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            )
        ]
    )]
    public function getMetrics()
    {
    }
}
