<?php

namespace Config;

use App\Validation\PasswordRules;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\{CreditCardRules, FileRules, FormatRules, Rules};

class Validation extends BaseConfig
{
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        PasswordRules::class,
    ];

    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];
}
