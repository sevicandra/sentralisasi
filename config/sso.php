<?php
    return [
        'base_uri' => env('SSO_BASE_URI'),
        'authorize' => [
            'endpoint' => env('SSO_AUTHORIZE_ENDPOINT'),
            'grant_type' => env('SSO_AUTHORIZE_GRANT_TYPE'),
            'response_type' => env('SSO_AUTHORIZE_RESPONSE_TYPE'),
            'client_id' => env('SSO_AUTHORIZE_CLIENT_ID'),
            'scope' => env('SSO_AUTHORIZE_SCOPE'),
            'nonce' => env('SSO_AUTHORIZE_NONCE'),
            'state' => env('SSO_AUTHORIZE_STATE'),
            'redirect_uri' => env('SSO_AUTHORIZE_REDIRECT_URI')
        ],
        'token' => [
            'endpoint' => env('SSO_TOKEN_ENDPOINT'),
            'client_secret' => env('SSO_TOKEN_CLIENT_SECRET')
        ],
        'userinfo' => [
            'endpoint' => env('SSO_USERINFO_ENDPOINT')
        ],
        'endsession' => [
            'endpoint' => env('SSO_ENDSESSION_ENDSESSION')
        ]
    ];