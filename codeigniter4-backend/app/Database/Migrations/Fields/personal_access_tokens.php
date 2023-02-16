<?php

declare(strict_types=1);

return [
    'id'             => [
        'type'           => 'BIGINT',
        'unsigned'       => true,
        'auto_increment' => true,
    ],

    'tokenable_id'   => [
        'type'           => 'BIGINT',
        'unsigned'       => true,
    ],

    'tokenable_type' => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
    ],

    'name'           => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
    ],

    'token'          => [
        'type'           => 'VARCHAR',
        'constraint'     => 64,
        'unique'         => true,
    ],

    'abilities'      => [
        'type'           => 'TEXT',
        'null'           => true,
        'default'        => null,
    ],

    'last_used_at'   => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
    ],

    'expires_at'     => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
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
