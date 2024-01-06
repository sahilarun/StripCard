<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'user/username/check',
        'user/check/email',
        '/add-money/sslcommerz/success',
        '/add-money/sslcommerz/cancel',
        '/add-money/sslcommerz/fail',
        '/add-money/sslcommerz/ipn',
        '/api-add-money/sslcommerz/success',
        '/api-add-money/sslcommerz/cancel',
        '/api-add-money/sslcommerz/fail',
        '/api-add-money/sslcommerz/ipn'
    ];
}
