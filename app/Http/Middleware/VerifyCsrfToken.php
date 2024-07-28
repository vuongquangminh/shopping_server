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
        //
        'api/auth/login', // Bỏ qua kiểm tra CSRF cho endpoint login
        'api/auth/register', // Bỏ qua kiểm tra CSRF cho endpoint register
    ];
}
