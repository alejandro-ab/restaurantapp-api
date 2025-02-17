<?php

namespace App\Http\Controllers;

use App\Domain\Support\Helpers\ResponseHelper;
use App\Domain\Visits\Actions\CreateVisitAction;
use App\Domain\Visits\Actions\DeleteVisitAction;
use App\Domain\Visits\Actions\UpdateVisitAction;
use App\Domain\Visits\ApiResources\VisitDetailResource;
use App\Domain\Visits\ApiResources\VisitListResource;
use App\Domain\Visits\Requests\CreateVisitRequest;
use App\Domain\Visits\Requests\UpdateVisitRequest;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $visits = $user->visits()->with(['images', 'restaurant:id,name'])
            ->get(['id', 'visited_at', 'comments', 'restaurant_id']);

        return ResponseHelper::success(VisitListResource::collection($visits));
    }

    public function show(Visit $visit): JsonResponse
    {
        $visit->load(['user', 'photos']);
        return ResponseHelper::success(new VisitDetailResource($visit));
    }

    public function store(CreateVisitRequest $request): JsonResponse
    {
        $visit = CreateVisitAction::execute($request->validated());

        return ResponseHelper::success(new VisitDetailResource($visit), Response::HTTP_CREATED);
    }

    public function update(UpdateVisitRequest $request, Visit $visit): JsonResponse
    {
        $visit = UpdateVisitAction::execute($request->validated(), $visit);

        return ResponseHelper::success(new VisitDetailResource($visit));
    }

    public function destroy(Visit $visit): JsonResponse
    {
        DeleteVisitAction::execute($visit);

        return ResponseHelper::success();
    }
}
