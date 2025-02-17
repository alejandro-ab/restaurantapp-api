<?php

namespace App\Http\Controllers;

use App\Domain\Dishes\Actions\CreateDishAction;
use App\Domain\Dishes\Actions\DeleteDishAction;
use App\Domain\Dishes\Actions\UpdateDishAction;
use App\Domain\Dishes\ApiResources\DishDetailResource;
use App\Domain\Dishes\Requests\CreateDishRequest;
use App\Domain\Dishes\Requests\UpdateDishRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Dish;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DishController extends Controller
{
    public function store(CreateDishRequest $request): JsonResponse
    {
        $dish = CreateDishAction::execute($request->validated());

        return ResponseHelper::success(new DishDetailResource($dish), Response::HTTP_CREATED);
    }

    public function update(Dish $dish, UpdateDishRequest $request): JsonResponse
    {
        $dish = UpdateDishAction::execute($request->validated(), $dish);

        return ResponseHelper::success(new DishDetailResource($dish));
    }

    public function destroy(Dish $dish): JsonResponse
    {
        DeleteDishAction::execute($dish);

        return ResponseHelper::success();
    }
}
