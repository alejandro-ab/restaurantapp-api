<?php

namespace App\Domain\Tags\Actions;

use App\Domain\Images\Actions\DeleteImageAction;
use App\Models\Image;
use App\Models\Tag;

class DeleteTagAction
{
    public static function execute(Tag $tag): void
    {

        $tag->delete();
    }
}
