<?php

namespace App\Domain\Images\Actions;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class DeleteImageAction
{
    public static function execute(Image $image): void
    {
        Storage::disk('public')->delete($image->path);

        $image->delete();
    }
}
