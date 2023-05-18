<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonalAccessTokensTable extends Migration
{
    private string $table = 'personal_access_tokens';

    public function up(): void
    {
        /** @var array<string,array<string,mixed>> $fields */
        $fields = require __DIR__ . "/Fields/{$this->table}.php";

        $this->forge->addField($fields)
            ->addPrimaryKey('id', 'personal_access_token_id')
            ->createTable($this->table, true);
    }

    public function down(): void
    {
        $this->forge->dropTable($this->table, true);
    }
}
