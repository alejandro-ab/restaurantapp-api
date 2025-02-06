<?php

namespace App\Domain\Images\Actions;

use App\Domain\Images\Concerns\Imageable;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImageAction
{
    public static function execute(Imageable $model, UploadedFile $file): Image
    {
        $path = Storage::disk('public')->putFile($model->getPathPrefix(), $file);

        return $model->images()->save(new Image(['path' => $path]));
    }
}
