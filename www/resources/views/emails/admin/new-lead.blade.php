<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Новый лид</title>
</head>

<body>
    <h2>🔔 Новый лид на сайте</h2>
    <p><strong>Имя:</strong> {{ $lead->name }}</p>
    <p><strong>Телефон:</strong> {{ $lead->phone ?? 'Не указан' }}</p>
    <p><strong>Email:</strong> {{ $lead->email ?? 'Не указан' }}</p>
    @if($lead->comment)
    <p><strong>Комментарий:</strong> {{ $lead->comment }}</p>
    @endif
</body>

</html>