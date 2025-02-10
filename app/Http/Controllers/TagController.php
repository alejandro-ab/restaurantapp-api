<?php

namespace App\Http\Controllers;

use App\Domain\Restaurants\Actions\CreateRestaurantAction;
use App\Domain\Restaurants\Actions\DeleteRestaurantAction;
use App\Domain\Restaurants\Actions\UpdateRestaurantAction;
use App\Domain\Restaurants\ApiResources\RestaurantDetailResource;
use App\Domain\Restaurants\ApiResources\RestaurantListResource;
use App\Domain\Restaurants\Requests\CreateRestaurantRequest;
use App\Domain\Restaurants\Requests\UpdateRestaurantRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Restaurant;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{

    public function store(CreateRestaurantRequest $request): JsonResponse
    {
        $restaurant = CreateRestaurantAction::execute($request->validated());

        return ResponseHelper::success(new RestaurantDetailResource($restaurant), Response::HTTP_CREATED);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): JsonResponse
    {
        $restaurant = UpdateRestaurantAction::execute($request->validated(), $restaurant);

        return ResponseHelper::success(new RestaurantDetailResource($restaurant));
    }

    public function destroy(Restaurant $restaurant): JsonResponse
    {
        DeleteRestaurantAction::execute($restaurant);

        return ResponseHelper::success();
    }
}
