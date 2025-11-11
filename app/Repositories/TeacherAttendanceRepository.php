<?php

namespace App\Repositories;

use App\Models\TeacherAttendance;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class TeacherAttendanceRepository extends BaseRepository
{
    protected array $defaultWith = [
        'circle:id,name',
        'user:id,name',
        'user.roles:id,name,display_name',
        'recordedBy:id,name',
    ];

    public function __construct(TeacherAttendance $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(int $perPage = 15, array $filters = [], array $with = [])
    {
        $perPage = max(1, min(100, $perPage));

        $query = $this->builder($with);

        $selectedDate = Arr::get($filters, 'selected_date');
        $month = Arr::get($filters, 'month');
        $search = Arr::get($filters, 'search');
        $sort = Arr::get($filters, 'sort');
        $direction = strtolower(Arr::get($filters, 'direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($selectedDate) {
            try {
                $date = Carbon::parse($selectedDate)->toDateString();
                $query->whereDate('date_g', $date);
            } catch (\Throwable $e) {
                // Ignore invalid dates to avoid breaking the listing.
            }
        } elseif ($month) {
            try {
                $monthCarbon = Carbon::createFromFormat('Y-m', $month);
                $start = $monthCarbon->copy()->startOfMonth();
                $end = $monthCarbon->copy()->endOfMonth();
                $query->whereBetween('date_g', [$start, $end]);
            } catch (\Throwable $e) {
                // Ignore invalid months.
            }
        }

        if ($search) {
            $searchTerm = '%'. $search .'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('status', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('circle', function ($circleQuery) use ($searchTerm) {
                        $circleQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        $sortableColumns = ['date_g', 'status'];
        if ($sort && in_array($sort, $sortableColumns, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('date_g', 'desc');
        }

        return $query->paginate($perPage);
    }
}
