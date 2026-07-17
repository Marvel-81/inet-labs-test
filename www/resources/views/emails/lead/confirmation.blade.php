<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Подтверждение заявки</title>
</head>

<body>
    <h2>✅ Ваша заявка принята!</h2>
    <p>Здравствуйте, {{ $lead->name }}!</p>
    <p>Мы получили вашу заявку и скоро свяжемся с вами.</p>
    <p><strong>Имя:</strong> {{ $lead->name }}</p>
    <p><strong>Телефон:</strong> {{ $lead->phone ?? 'Не указан' }}</p>
    <p><strong>Email:</strong> {{ $lead->email ?? 'Не указан' }}</p>
</body>

</html>