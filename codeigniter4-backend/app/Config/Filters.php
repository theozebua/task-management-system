<?php

declare(strict_types=1);

namespace Config;

use App\Filters\TokenValidation;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\{CSRF, DebugToolbar, Honeypot, InvalidChars, SecureHeaders};

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'validatetoken' => TokenValidation::class,
    ];

    public array $globals = [
        'before' => [],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}
