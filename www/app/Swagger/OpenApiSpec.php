<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API Лиды",
    description: "Документация API для работы с заявками.",
    contact: new OA\Contact(email: "sd-programmer@yandex.ru")
)]
#[OA\Server(
    url: "http://localhost:8080",
    description: "Сервер разработки"
)]
#[OA\Tag(
    name: "Лиды",
    description: "Операции с заявками"
)]
#[OA\Tag(
    name: "Система",
    description: "Системные операции"
)]
class OpenApiSpec
{
}
