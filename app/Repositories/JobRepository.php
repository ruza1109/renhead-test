<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use Illuminate\Database\Eloquent\Collection;

class JobRepository
{
    public function getAll(): Collection
    {
        return Job::all();
    }

    public function getEmployeeByModelAndId(Trader|Professor $model, $id): Trader|Professor
    {
        return $model::findOrFail($id);
    }
}
