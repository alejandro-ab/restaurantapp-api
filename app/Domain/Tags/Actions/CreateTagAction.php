<?php

namespace App\Domain\Tags\Actions;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateTagAction
{
    public static function execute(array $data): Tag
    {
        /** @var User $user */
        $user = Auth::user();

        $tag = Tag::query()->make($data);

        $user->tags()->save($tag);

        return $tag;
    }
}
