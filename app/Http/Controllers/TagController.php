<?php

namespace App\Http\Controllers;

use App\Domain\Tags\Actions\CreateTagAction;
use App\Domain\Restaurants\Actions\DeleteRestaurantAction;
use App\Domain\Restaurants\Actions\UpdateRestaurantAction;
use App\Domain\Tags\ApiResources\TagDetailResource;
use App\Domain\Restaurants\ApiResources\RestaurantListResource;
use App\Domain\Tags\Requests\CreateTagRequest;
use App\Domain\Restaurants\Requests\UpdateRestaurantRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Restaurant;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{

    public function store(CreateTagRequest $request): JsonResponse
    {
        $tag = CreateTagAction::execute($request->validated());
        
        return ResponseHelper::success(new TagDetailResource($tag), Response::HTTP_CREATED);
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
