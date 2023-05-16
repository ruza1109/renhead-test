<?php

namespace App\DTO;

class TraderDTO extends UserDTO
{
    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        private float $workingHours,
        private float $payrollPerHour,
    ) {
        parent::__construct($email, $firstName, $lastName, $password);
    }

    public function getWorkingHours(): float
    {
        return $this->workingHours;
    }

    public function setWorkingHours(float $workingHours): static
    {
        $this->workingHours = $workingHours;
        return $this;
    }

    public function getPayrollPerHour(): float
    {
        return $this->payrollPerHour;
    }

    public function setPayrollPerHour(float $payrollPerHour): static
    {
        $this->payrollPerHour = $payrollPerHour;
        return $this;
    }
}
