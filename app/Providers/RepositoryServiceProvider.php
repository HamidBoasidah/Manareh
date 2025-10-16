<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Repositories
use App\Repositories\UserRepository;
use App\Repositories\MedicalFacilityRepository;
use App\Repositories\MedicalServiceRepository;
use App\Repositories\WorkingPeriodRepository;
use App\Repositories\MedicalFacilityCategoryRepository;
use App\Repositories\FacilityOwnershipRepository;
use App\Repositories\AreaRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\GovernorateRepository;
use App\Repositories\SpecialtyRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\ContentBlockRepository;
use App\Repositories\ConversationRepository;
// Models
use App\Models\User;
use App\Models\MedicalFacility;
use App\Models\MedicalService;
use App\Models\WorkingPeriod;
use App\Models\MedicalFacilityCategory;
use App\Models\FacilityOwnership;
use App\Models\Area;
use App\Models\District;
use App\Models\Governorate;
use App\Models\Specialty;
use App\Models\Advertisement;
use App\Models\ContentBlock;
use App\Models\Conversation;

// Services
use App\Services\UserService;
use App\Services\MedicalFacilityService;
use App\Services\MedicalServiceService;
use App\Services\WorkingPeriodService;
use App\Services\MedicalFacilityCategoryService;
use App\Services\FacilityOwnershipService;
use App\Services\AreaService;
use App\Services\DistrictService;
use App\Services\GovernorateService;
use App\Services\SpecialtyService;
use App\Services\AdvertisementService;
use App\Services\ContentBlockService;
use App\Services\ConversationService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepository::class, fn($app) => new UserRepository($app->make(User::class)));
        $this->app->bind(MedicalFacilityRepository::class, fn($app) => new MedicalFacilityRepository($app->make(MedicalFacility::class)));
        $this->app->bind(MedicalServiceRepository::class, fn($app) => new MedicalServiceRepository($app->make(MedicalService::class)));
        $this->app->bind(WorkingPeriodRepository::class, fn($app) => new WorkingPeriodRepository($app->make(WorkingPeriod::class)));
        $this->app->bind(MedicalFacilityCategoryRepository::class, fn($app) => new MedicalFacilityCategoryRepository($app->make(MedicalFacilityCategory::class)));
        $this->app->bind(FacilityOwnershipRepository::class, fn($app) => new FacilityOwnershipRepository($app->make(FacilityOwnership::class)));
        $this->app->bind(AreaRepository::class, fn($app) => new AreaRepository($app->make(Area::class)));
        $this->app->bind(DistrictRepository::class, fn($app) => new DistrictRepository($app->make(District::class)));
        $this->app->bind(GovernorateRepository::class, fn($app) => new GovernorateRepository($app->make(Governorate::class)));
        $this->app->bind(SpecialtyRepository::class, fn($app) => new SpecialtyRepository($app->make(Specialty::class)));
        $this->app->bind(AdvertisementRepository::class, fn($app) => new AdvertisementRepository($app->make(Advertisement::class)));
        $this->app->bind(ContentBlockRepository::class, fn($app) => new ContentBlockRepository($app->make(ContentBlock::class)));
        $this->app->bind(ConversationRepository::class, fn($app) => new ConversationRepository($app->make(Conversation::class)));

        // Bind Services to their Repositories
        $this->app->bind(UserService::class, fn($app) => new UserService($app->make(UserRepository::class)));
        $this->app->bind(MedicalFacilityService::class, fn($app) => new MedicalFacilityService($app->make(MedicalFacilityRepository::class)));
        $this->app->bind(MedicalServiceService::class, fn($app) => new MedicalServiceService($app->make(MedicalServiceRepository::class)));
        $this->app->bind(WorkingPeriodService::class, fn($app) => new WorkingPeriodService($app->make(WorkingPeriodRepository::class)));
        $this->app->bind(MedicalFacilityCategoryService::class, fn($app) => new MedicalFacilityCategoryService($app->make(MedicalFacilityCategoryRepository::class)));
        $this->app->bind(FacilityOwnershipService::class, fn($app) => new FacilityOwnershipService($app->make(FacilityOwnershipRepository::class)));
        $this->app->bind(AreaService::class, fn($app) => new AreaService($app->make(AreaRepository::class)));
        $this->app->bind(DistrictService::class, fn($app) => new DistrictService($app->make(DistrictRepository::class)));
        $this->app->bind(GovernorateService::class, fn($app) => new GovernorateService($app->make(GovernorateRepository::class)));
        $this->app->bind(SpecialtyService::class, fn($app) => new SpecialtyService($app->make(SpecialtyRepository::class)));
        $this->app->bind(AdvertisementService::class, fn($app) => new AdvertisementService($app->make(AdvertisementRepository::class)));
        $this->app->bind(ContentBlockService::class, fn($app) => new ContentBlockService($app->make(ContentBlockRepository::class)));
        $this->app->bind(ConversationService::class, fn($app) => new ConversationService($app->make(ConversationRepository::class)));
    }
}
