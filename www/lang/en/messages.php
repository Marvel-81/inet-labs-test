<?php

return [
    // General messages
    'success' => 'Operation completed successfully',
    'error' => 'An error occurred',
    'validation_error' => 'Validation error',
    'server_error' => 'Internal server error',

    // Health Check
    'health' => [
        'healthy' => 'Application is healthy',
        'degraded' => 'Application is degraded',
        'failed' => 'Health check failed',
        'error' => 'Health check error',
    ],

    // Lead
    'lead' => [
        'created' => 'Lead created successfully',
        'not_found' => 'No leads found',
        'list_retrieved' => 'Leads list retrieved successfully',
        'creation_error' => 'An error occurred while creating the lead',
        'list_error' => 'Error retrieving leads list',
        'name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'comment' => 'Comment',
        'not_specified' => 'Not specified',
    ],

    // Validation
    'validation' => [
        'name' => [
            'required' => 'The "Name" field is required.',
            'string' => 'The "Name" field must be a string.',
            'max' => 'The "Name" field may not exceed 255 characters.',
            'min' => 'The "Name" field must contain at least 2 characters.',
            'regex' => 'The "Name" field may only contain letters, spaces and hyphens.',
        ],
        'phone' => [
            'string' => 'The "Phone" field must be a string.',
            'max' => 'The "Phone" field may not exceed 20 characters.',
            'regex' => 'Invalid phone number format.',
            'min' => 'The "Phone" field must contain at least 7 characters.',
        ],
        'email' => [
            'string' => 'The "Email" field must be a string.',
            'email' => 'Please enter a valid email address.',
            'max' => 'The "Email" field may not exceed 255 characters.',
        ],
        'comment' => [
            'string' => 'The "Comment" field must be a string.',
            'max' => 'The "Comment" field may not exceed 1000 characters.',
            'min' => 'The "Comment" field must contain at least 3 characters.',
        ],
    ],

    // Emails
    'emails' => [
        'lead_confirmation' => [
            'subject' => 'Your application has been received',
            'greeting' => 'Hello, :name!',
            'body' => 'We have received your application and will contact you soon.',
            'title' => '✅ Your application has been received!',
        ],
        'new_lead' => [
            'subject' => 'New lead on the website',
            'title' => '🔔 New lead on the website',
            'body' => 'A new application has been created on the website.',
        ],
    ],
];
