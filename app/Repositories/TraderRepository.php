<?php

namespace App\Repositories;

use App\Models\Trader;
use Illuminate\Database\Eloquent\Collection;

class TraderRepository
{
    public function getAll(): Collection
    {
        return Trader::all();
    }
}
