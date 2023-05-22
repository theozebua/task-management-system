<?php

declare(strict_types=1);

return [
    'id'          => [
        'type'           => 'BIGINT',
        'unsigned'       => true,
        'auto_increment' => true,
    ],

    'user_id'     => [
        'type'           => 'BIGINT',
        'unsigned'       => true,
    ],

    'title'       => [
        'type'           => 'VARCHAR',
        'constraint'     => 255,
    ],

    'description' => [
        'type'           => 'TEXT',
        'null'           => true,
        'default'        => null,
    ],

    'due_date'    => [
        'type'           => 'DATE'
    ],

    'priority'    => [
        'type'           => 'INT',
    ],

    'is_finished' => [
        'type'           => 'TINYINT',
        'constraint'     => 1,
        'default'        => false,
    ],

    'created_at'  => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
    ],

    'updated_at'  => [
        'type'           => 'TIMESTAMP',
        'null'           => true,
        'default'        => null,
    ],
];
