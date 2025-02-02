<?php

namespace App\Http\Controllers;
use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Support\Helpers\ResponseHelper;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function show(Image $image): JsonResponse
    {
        return ResponseHelper::success(new ImageDetailResource($image));
    }
}
