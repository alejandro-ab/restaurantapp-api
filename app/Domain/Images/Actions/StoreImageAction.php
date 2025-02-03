<?php

namespace App\Domain\Images\Actions;

use App\Models\Image;
use App\Models\ImageableModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImageAction
{
    public static function execute(ImageableModel $model, UploadedFile $file): Image
    {
        $path = Storage::disk('public')->putFile($model->getPathPrefix(), $file);

        return $model->images()->save(new Image(['path' => $path]));
    }
}
