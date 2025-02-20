<?php

namespace App\Http\Controllers;

use App\Domain\Images\Actions\DeleteImageAction;
use App\Domain\Images\Actions\StoreImageAction;
use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Images\Requests\CreateImageRequest;
use App\Domain\Images\Resolvers\ImageableResolver;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    public function show(Image $image): JsonResponse
    {
        Gate::authorize('view', $image);

        return ResponseHelper::success(new ImageDetailResource($image));
    }

    public function store(CreateImageRequest $request): JsonResponse
    {
        $model = ImageableResolver::resolve($request->input('class'), $request->input('id'));

        $image = StoreImageAction::execute($model, $request->file('image'));

        return ResponseHelper::success(new ImageDetailResource($image));
    }

    public function destroy(Image $image): JsonResponse
    {
        Gate::authorize('delete', $image);

        DeleteImageAction::execute($image);

        return ResponseHelper::success();
    }
}
