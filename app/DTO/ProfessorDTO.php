<?php

namespace App\DTO;

class ProfessorDTO extends UserDTO
{
    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        private float $totalAvailableHours,
        private float $payrollPerHour,
        private float $totalProjects,
        private float $officeNumber,
    ) {
        parent::__construct($email, $firstName, $lastName, $password);
    }

    public function getTotalAvailableHours(): float
    {
        return $this->totalAvailableHours;
    }

    public function setTotalAvailableHours(float $totalAvailableHours): static
    {
        $this->totalAvailableHours = $totalAvailableHours;
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

    public function getTotalProjects(): float
    {
        return $this->totalProjects;
    }

    public function setTotalProjects(float $totalProjects): static
    {
        $this->totalProjects = $totalProjects;
        return $this;
    }

    public function getOfficeNumber(): float
    {
        return $this->officeNumber;
    }

    public function setOfficeNumber(float $officeNumber): static
    {
        $this->officeNumber = $officeNumber;
        return $this;
    }
}
