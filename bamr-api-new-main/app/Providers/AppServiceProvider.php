<?php

namespace App\Providers;

use App\Interfaces\AffiliatesInfoRepositoryInterface;
use App\Interfaces\AffiliatesRepositoryInterface;
use App\Interfaces\Api\ClickRepositoryInterface;
use App\Interfaces\BusinessNumberRepositoryInterface;
use App\Interfaces\CampaignCodeRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\MainRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use App\Repositories\AffiliatesInfoRepository;
use App\Repositories\AffiliatesRepository;
use App\Repositories\Api\ClickRepository;
use App\Repositories\BusinessNumberRepository;
use App\Repositories\CampaignCodeRepository;
use App\Repositories\CountryRepository;
use App\Repositories\KeywordRepository;
use App\Repositories\MainRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClickRepositoryInterface::class, ClickRepository::class);
        $this->app->bind(MainRepositoryInterface::class, MainRepository::class);
        $this->app->bind(BusinessNumberRepositoryInterface::class, BusinessNumberRepository::class);
        $this->app->bind(CampaignCodeRepositoryInterface::class, CampaignCodeRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(KeywordRepositoryInterface::class, KeywordRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(AffiliatesRepositoryInterface::class, AffiliatesRepository::class);
        $this->app->bind(AffiliatesInfoRepositoryInterface::class, AffiliatesInfoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
