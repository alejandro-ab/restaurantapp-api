<?php

namespace App\Http\Controllers;

use App\Domain\Restaurants\Actions\CreateRestaurantAction;
use App\Domain\Restaurants\Requests\CreateRestaurantRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    public function store(CreateRestaurantRequest $request): JsonResponse
    {
        $restaurant = CreateRestaurantAction::execute($request->validated());

        return ResponseHelper::success($restaurant->toArray(), Response::HTTP_CREATED);
    }
}
