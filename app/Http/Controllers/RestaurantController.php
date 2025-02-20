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
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $restaurants = $user->restaurants()
            ->with(['tags'])
            ->when($request->get('name'), function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->get(['id', 'name', 'comments', 'rating']);

        return ResponseHelper::success(RestaurantListResource::collection($restaurants));
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        Gate::authorize('view', $restaurant);

        return ResponseHelper::success(new RestaurantDetailResource($restaurant));
    }

    public function store(CreateRestaurantRequest $request): JsonResponse
    {
        $restaurant = CreateRestaurantAction::execute($request->validated());

        return ResponseHelper::success(new RestaurantDetailResource($restaurant), Response::HTTP_CREATED);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): JsonResponse
    {
        Gate::authorize('update', $restaurant);

        $restaurant = UpdateRestaurantAction::execute($request->validated(), $restaurant);

        return ResponseHelper::success(new RestaurantDetailResource($restaurant));
    }

    public function destroy(Restaurant $restaurant): JsonResponse
    {
        Gate::authorize('delete', $restaurant);

        DeleteRestaurantAction::execute($restaurant);

        return ResponseHelper::success();
    }

    public function dishes(Restaurant $restaurant): JsonResponse
    {
        Gate::authorize('view', $restaurant);

        $dishes = $restaurant->dishes()
            ->with(['tags', 'images'])
            ->get(['id', 'name', 'description', 'rating']);

        return ResponseHelper::success(DishListResource::collection($dishes));
    }

    public function visits(Restaurant $restaurant): JsonResponse
    {
        Gate::authorize('view', $restaurant);

        $visits = $restaurant->visits()
            ->with(['images', 'restaurant:id,name'])
            ->get(['id', 'visited_at', 'comments', 'restaurant_id']);

        return ResponseHelper::success(VisitListResource::collection($visits));
    }
}
