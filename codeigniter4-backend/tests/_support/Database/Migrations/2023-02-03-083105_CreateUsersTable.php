<?php

declare(strict_types=1);

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    private string $table = 'users';

    public function up(): void
    {
        /** @var array<string,array<string,mixed>> $fields */
        $fields = require __DIR__ . "/Fields/{$this->table}.php";

        $this->forge->addField($fields)
            ->addPrimaryKey('id', 'user_id')
            ->createTable($this->table, true);
    }

    public function down(): void
    {
        $this->forge->dropTable($this->table, true);
    }
}
