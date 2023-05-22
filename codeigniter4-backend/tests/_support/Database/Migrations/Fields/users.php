<?php

declare(strict_types=1);

return [
    'id'         => [
        'type'           => 'BIGINT',
        'unsigned'       => true,
        'auto_increment' => true,
    ],

    'name'       => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
    ],

    'email'      => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
        'unique'         => true,
    ],

    'password'   => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
    ],

    'created_at' => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
    ],

    'updated_at' => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
    ],
];
