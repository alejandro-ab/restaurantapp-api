<?php

namespace App\Http\Controllers;

use App\Domain\Dishes\ApiResources\DishListResource;
use App\Domain\Restaurants\Actions\CreateRestaurantAction;
use App\Domain\Restaurants\Actions\DeleteRestaurantAction;
use App\Domain\Restaurants\Actions\UpdateRestaurantAction;
use App\Domain\Restaurants\ApiResources\RestaurantDetailResource;
use App\Domain\Restaurants\ApiResources\RestaurantListResource;
use App\Domain\Restaurants\Requests\CreateRestaurantRequest;
use App\Domain\Restaurants\Requests\UpdateRestaurantRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Domain\Visits\ApiResources\VisitListResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $restaurants = $user->restaurants()
            ->with(['tags'])
            ->get(['id', 'name', 'comments', 'rating']);

        return ResponseHelper::success(RestaurantListResource::collection($restaurants));
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        return ResponseHelper::success(new RestaurantDetailResource($restaurant));
    }

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

    public function dishes(Restaurant $restaurant): JsonResponse
    {
        $dishes = $restaurant->dishes()
            ->with(['tags', 'images'])
            ->get(['id', 'name', 'description', 'rating']);

        return ResponseHelper::success(DishListResource::collection($dishes));
    }

    public function visits(Restaurant $restaurant): JsonResponse
    {
        $visits = $restaurant->visits()
            ->with(['images', 'restaurant:id,name'])
            ->get(['id', 'visited_at', 'comments', 'restaurant_id']);

        return ResponseHelper::success(VisitListResource::collection($visits));
    }
}
