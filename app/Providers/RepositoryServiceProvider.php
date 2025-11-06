<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Repositories
use App\Repositories\UserRepository;
use App\Repositories\NominationRepository;
use App\Repositories\ExamRepository;
use App\Repositories\AreaRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\GovernorateRepository;
use App\Repositories\MosqueRepository;
use App\Repositories\DailyStudySessionRepository;
use App\Repositories\DailyStudyRepository;
// Models
use App\Models\User;
use App\Models\Area;
use App\Models\District;
use App\Models\Governorate;
use App\Models\Mosque;
use App\Models\DailyStudySession;
use App\Models\Nomination;
use App\Models\DailyStudy;
use App\Models\Exam;

// Services
use App\Services\UserService;
use App\Services\AreaService;
use App\Services\DistrictService;
use App\Services\GovernorateService;
use App\Services\MosqueService;
use App\Services\DailyStudySessionService;
use App\Services\DailyStudyService;
use App\Services\NominationService;


class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepository::class, fn($app) => new UserRepository($app->make(User::class)));
        $this->app->bind(AreaRepository::class, fn($app) => new AreaRepository($app->make(Area::class)));
        $this->app->bind(DistrictRepository::class, fn($app) => new DistrictRepository($app->make(District::class)));
        $this->app->bind(GovernorateRepository::class, fn($app) => new GovernorateRepository($app->make(Governorate::class)));
        $this->app->bind(MosqueRepository::class, fn($app) => new MosqueRepository($app->make(Mosque::class)));
        $this->app->bind(DailyStudySessionRepository::class, fn($app) => new DailyStudySessionRepository($app->make(DailyStudySession::class)));
    $this->app->bind(DailyStudyRepository::class, fn($app) => new DailyStudyRepository($app->make(DailyStudy::class)));
    $this->app->bind(NominationRepository::class, fn($app) => new NominationRepository($app->make(Nomination::class)));
        $this->app->bind(ExamRepository::class, fn($app) => new ExamRepository($app->make(Exam::class)));
        

        // Bind Services to their Repositories
        $this->app->bind(UserService::class, fn($app) => new UserService($app->make(UserRepository::class)));
        $this->app->bind(AreaService::class, fn($app) => new AreaService($app->make(AreaRepository::class)));
        $this->app->bind(DistrictService::class, fn($app) => new DistrictService($app->make(DistrictRepository::class)));
        $this->app->bind(GovernorateService::class, fn($app) => new GovernorateService($app->make(GovernorateRepository::class)));
        $this->app->bind(MosqueService::class, fn($app) => new MosqueService($app->make(MosqueRepository::class)));
        $this->app->bind(DailyStudySessionService::class, fn($app) => new DailyStudySessionService(
            $app->make(DailyStudySessionRepository::class),
            $app->make(DailyStudyRepository::class)
        ));
    $this->app->bind(DailyStudyService::class, fn($app) => new DailyStudyService($app->make(DailyStudyRepository::class)));
    $this->app->bind(NominationService::class, fn($app) => new NominationService($app->make(NominationRepository::class)));
        $this->app->bind(\App\Services\ExamService::class, fn($app) => new \App\Services\ExamService($app->make(ExamRepository::class)));
    }
}
