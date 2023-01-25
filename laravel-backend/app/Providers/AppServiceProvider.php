<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\Api\Rest\TaskController;
use App\Repositories\Api\Contracts\Rest\RepositoryContract;
use App\Repositories\Api\Implementations\Rest\TaskRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

/**
 * @property-read \Illuminate\Support\Facades\App $app The application instance.
 */
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(TaskController::class)
            ->needs(RepositoryContract::class)
            ->give(TaskRepository::class);
    }

    public function boot(): void
    {
        Model::shouldBeStrict(!$this->app->isProduction());
    }
}
