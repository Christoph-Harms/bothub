<?php

namespace BotHub\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '316838507%3AAAF4KeNhDPWPS6tIdaM1u9b4_-xYgFUXZhc'
    ];
}
