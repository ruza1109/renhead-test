<?php

namespace App\Repositories;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Collection;

class ProfessorRepository
{
    public function getAll(): Collection
    {
        return Professor::all();
    }
}
