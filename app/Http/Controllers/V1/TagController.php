<?php

namespace App\Http\Controllers\V1;

use App\Domain\Support\Helpers\ResponseHelper;
use App\Domain\Tags\Actions\CreateTagAction;
use App\Domain\Tags\Actions\DeleteTagAction;
use App\Domain\Tags\Actions\UpdateTagAction;
use App\Domain\Tags\ApiResources\TagDetailResource;
use App\Domain\Tags\ApiResources\TagListResource;
use App\Domain\Tags\Requests\CreateTagRequest;
use App\Domain\Tags\Requests\UpdateTagRequest;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $tag = $user->tags()
            ->when($request->get('name'), function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->get(['id', 'name', 'color']);

        return ResponseHelper::success(TagListResource::collection($tag));
    }

    public function show(Tag $tag): JsonResponse
    {
        Gate::authorize('view', $tag);

        return ResponseHelper::success(new TagDetailResource($tag));
    }

    public function store(CreateTagRequest $request): JsonResponse
    {
        $tag = CreateTagAction::execute($request->validated());

        return ResponseHelper::success(new TagDetailResource($tag), Response::HTTP_CREATED);
    }

    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        Gate::authorize('update', $tag);

        $tag = UpdateTagAction::execute($request->validated(), $tag);

        return ResponseHelper::success(new TagDetailResource($tag));
    }

    public function destroy(Tag $tag): JsonResponse
    {
        Gate::authorize('delete', $tag);

        DeleteTagAction::execute($tag);

        return ResponseHelper::success();
    }
}
