<?php

namespace App\Http\Controllers;

use App\Domain\Tags\Actions\CreateTagAction;
use App\Domain\Tags\Actions\DeleteTagAction;
use App\Domain\Tags\Actions\UpdateTagAction;
use App\Domain\Tags\ApiResources\TagDetailResource;
use App\Domain\Tags\ApiResources\TagListResource;
use App\Domain\Tags\Requests\CreateTagRequest;
use App\Domain\Tags\Requests\UpdateTagRequest;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tag = Tag::query()
            ->get(['id', 'name', 'color']);

        return ResponseHelper::success(TagListResource::collection($tag));
    }

    public function show(Tag $tag): JsonResponse
    {
        return ResponseHelper::success(new TagDetailResource($tag));
    }

    public function store(CreateTagRequest $request): JsonResponse
    {
        $tag = CreateTagAction::execute($request->validated());
        
        return ResponseHelper::success(new TagDetailResource($tag), Response::HTTP_CREATED);
    }

    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        $tag = UpdateTagAction::execute($request->validated(), $tag);

        return ResponseHelper::success(new TagDetailResource($tag));
    }

    public function destroy(Tag $tag): JsonResponse
    {
        DeleteagAction::execute($tag);

        return ResponseHelper::success();
    }
}
