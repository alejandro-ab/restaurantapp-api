<?php

namespace App\Http\Controllers;

use App\Domain\Dishes\Actions\CreateDishAction;
use App\Domain\Dishes\ApiResources\DishDetailResource;
use App\Domain\Dishes\Requests\CreateDishRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DishController extends Controller
{
    public function store(CreateDishRequest $request): JsonResponse
    {
        $dish = CreateDishAction::execute($request->validated());

        return ResponseHelper::success(new DishDetailResource($dish), Response::HTTP_CREATED);
    }
}
