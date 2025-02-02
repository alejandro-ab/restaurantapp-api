<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $path
 */
class Image extends Model
{
    /** @use HasFactory<ImageFactory> */
    use HasFactory;

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrl(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
