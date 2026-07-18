<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ __('messages.emails.lead_confirmation.title') }}</title>
</head>

<body>
    <h2>{{ __('messages.emails.lead_confirmation.title') }}</h2>
    <p>{{ __('messages.emails.lead_confirmation.greeting', ['name' => $lead->name]) }}</p>
    <p>{{ __('messages.emails.lead_confirmation.body') }}</p>
    <p><strong>{{ __('messages.lead.name') }}:</strong> {{ $lead->name }}</p>
    <p><strong>{{ __('messages.lead.phone') }}:</strong> {{ $lead->phone ?? __('messages.lead.not_specified') }}</p>
    <p><strong>{{ __('messages.lead.email') }}:</strong> {{ $lead->email ?? __('messages.lead.not_specified') }}</p>
</body>

</html>
