<?php

namespace App\Domain\Tags\Actions;

use App\Models\Tag;

class UpdateTagAction
{
    public static function execute(array $data, Tag $tag): Tag
    {
        $tag->update($data);

        return $tag;
    }
}
