<?php

namespace App\Http\Controllers\V1;

use App\Domain\Dishes\Actions\CreateDishAction;
use App\Domain\Dishes\Actions\DeleteDishAction;
use App\Domain\Dishes\Actions\UpdateDishAction;
use App\Domain\Dishes\ApiResources\DishDetailResource;
use App\Domain\Dishes\ApiResources\DishListResource;
use App\Domain\Dishes\Requests\CreateDishRequest;
use App\Domain\Dishes\Requests\UpdateDishRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DishController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $dishes = $user->dishes()->with(['tags', 'images'])
            ->when($request->get('name'), function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->get(['id', 'name', 'comments', 'rating']);

        return ResponseHelper::success(DishListResource::collection($dishes));
    }

    public function show(Dish $dish): JsonResponse
    {
        Gate::authorize('view', $dish);

        return ResponseHelper::success(new DishDetailResource($dish));
    }

    public function store(CreateDishRequest $request): JsonResponse
    {
        $dish = CreateDishAction::execute($request->validated());

        return ResponseHelper::success(new DishDetailResource($dish), Response::HTTP_CREATED);
    }

    public function update(Dish $dish, UpdateDishRequest $request): JsonResponse
    {
        Gate::authorize('update', $dish);

        $dish = UpdateDishAction::execute($request->validated(), $dish);

        return ResponseHelper::success(new DishDetailResource($dish));
    }

    public function destroy(Dish $dish): JsonResponse
    {
        Gate::authorize('delete', $dish);

        DeleteDishAction::execute($dish);

        return ResponseHelper::success();
    }
}
