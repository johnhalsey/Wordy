<?php

namespace App\Providers;

use App\Models\Submission;
use App\Observers\SubmissionObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\WordValidationService;
use App\Contracts\DictionaryServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DictionaryServiceInterface::class, WordValidationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Submission::observe(SubmissionObserver::class);
    }
}
