<?php

namespace App\DTO;

class JobDTO
{
    public function __construct(
        private string $date,
        private float  $totalHours,
    ) {}

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getTotalHours(): float
    {
        return $this->totalHours;
    }

    public function setTotalHours(float $totalHours): static
    {
        $this->totalHours = $totalHours;
        return $this;
    }
}
