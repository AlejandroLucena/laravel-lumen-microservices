<?php

namespace UnitTest\Post\Domain\ValueObject;

use Modules\Post\Domain\ValueObject\PostTitle;
use Illuminate\Support\Str;

class PostTitleMother{

    public static function dummy(): PostTitle
    {
        return PostTitle::from(Str::random(10));
    }

    public static function with(string $string): PostTitle
    {
        return PostTitle::from($string);
    }

    public static function empty(): PostTitle
    {
        return self::with('');
    }
}