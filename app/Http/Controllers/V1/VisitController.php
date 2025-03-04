<?php

namespace App\Http\Controllers\V1;

use App\Domain\Dishes\ApiResources\DishListResource;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Domain\Visits\Actions\CreateVisitAction;
use App\Domain\Visits\Actions\DeleteVisitAction;
use App\Domain\Visits\Actions\UpdateVisitAction;
use App\Domain\Visits\ApiResources\VisitDetailResource;
use App\Domain\Visits\ApiResources\VisitListResource;
use App\Domain\Visits\Requests\CreateVisitRequest;
use App\Domain\Visits\Requests\UpdateVisitRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $visits = $user->visits()->with(['images', 'restaurant:id,name'])
            ->when($request->get('from'), function ($query, $from) {
                $query->where('visited_at', '>=', $from);
            })
            ->when($request->get('to'), function ($query, $to) {
                $query->where('visited_at', '<=', $to);
            })
            ->get(['id', 'visited_at', 'comments', 'restaurant_id']);

        return ResponseHelper::success(VisitListResource::collection($visits));
    }

    public function show(Visit $visit): JsonResponse
    {
        Gate::authorize('view', $visit);

        return ResponseHelper::success(new VisitDetailResource($visit));
    }

    public function store(CreateVisitRequest $request): JsonResponse
    {
        $visit = CreateVisitAction::execute($request->validated());

        return ResponseHelper::success(new VisitDetailResource($visit), Response::HTTP_CREATED);
    }

    public function update(UpdateVisitRequest $request, Visit $visit): JsonResponse
    {
        Gate::authorize('update', $visit);

        $visit = UpdateVisitAction::execute($request->validated(), $visit);

        return ResponseHelper::success(new VisitDetailResource($visit));
    }

    public function destroy(Visit $visit): JsonResponse
    {
        Gate::authorize('delete', $visit);

        DeleteVisitAction::execute($visit);

        return ResponseHelper::success();
    }

    public function dishes(Visit $visit): JsonResponse
    {
        Gate::authorize('view', $visit);

        $dishes = $visit->dishes()->with(['tags', 'images'])
            ->get(['dishes.id', 'dishes.name', 'dishes.comments', 'dishes.rating']);

        return ResponseHelper::success(DishListResource::collection($dishes));
    }
}
