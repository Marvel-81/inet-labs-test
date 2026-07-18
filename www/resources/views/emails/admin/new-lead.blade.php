<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ __('messages.emails.new_lead.title') }}</title>
</head>

<body>
    <h2>{{ __('messages.emails.new_lead.title') }}</h2>
    <p>{{ __('messages.emails.new_lead.body') }}</p>
    <p><strong>{{ __('messages.lead.name') }}:</strong> {{ $lead->name }}</p>
    <p><strong>{{ __('messages.lead.phone') }}:</strong> {{ $lead->phone ?? __('messages.lead.not_specified') }}</p>
    <p><strong>{{ __('messages.lead.email') }}:</strong> {{ $lead->email ?? __('messages.lead.not_specified') }}</p>
    @if($lead->comment)
    <p><strong>{{ __('messages.lead.comment') }}:</strong> {{ $lead->comment }}</p>
    @endif
</body>

</html>
