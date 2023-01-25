<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    
}

Cookie::queue(Cookie::make('XSRF-TOKEN', csrf_token(), 24 * 60, '/', null, true, true));

