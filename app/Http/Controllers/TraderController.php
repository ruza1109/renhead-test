<?php

namespace App\Http\Controllers;

use App\DTO\TraderDTO;
use App\Http\Requests\StoreTraderRequest;
use App\Http\Requests\UpdateTraderRequest;
use App\Models\Trader;
use App\Services\TraderService;
use Illuminate\Http\JsonResponse;

class TraderController extends Controller
{
    public function __construct(
        private readonly TraderService $traderService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(
            $this->traderService->getAll()
        );
    }

    public function show(Trader $trader): JsonResponse
    {
        return response()->json($trader);
    }

    public function store(StoreTraderRequest $request): JsonResponse
    {
        $traderDTO = new TraderDTO(
            email: $request['email'],
            firstName: $request['first_name'],
            lastName: $request['last_name'],
            password: $request['password'],
            workingHours: $request['working_hours'],
            payrollPerHour: $request['payroll_per_hour'],
        );

        $trader = $this->traderService->store($traderDTO);

        return response()->json($trader, 201);
    }

    public function update(UpdateTraderRequest $request, Trader $trader): JsonResponse
    {
        $trader = $this->traderService->update($trader, $request->validated());

        return response()->json($trader);
    }

    public function delete(Trader $trader): JsonResponse
    {
        $this->traderService->delete($trader);

        return response()->json(status: 204);
    }
}
