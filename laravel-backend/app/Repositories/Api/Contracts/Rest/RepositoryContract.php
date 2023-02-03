<?php

declare(strict_types=1);

namespace App\Repositories\Api\Contracts\Rest;

use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
    /**
     * Store a newly created resource in storage.
     *
     * @param array<string, mixed>
     *
     * @return array
     */
    public function store(array $data): array;

    /**
     * Update the specified resource in storage.
     *
     * @param array<string, mixed>
     * @param Model $model
     *
     * @return array
     */
    public function update(array $data, $model): array;

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     *
     * @return array
     */
    public function destroy($model): array;
}
