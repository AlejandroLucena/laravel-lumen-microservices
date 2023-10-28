<?php

namespace UnitTest\Post\Domain\ValueObject;

use Modules\Post\Domain\ValueObject\PostContent;
use Illuminate\Support\Str;

class PostContentMother
{
    public static function dummy(): PostContent
    {
        return PostContent::from(Str::random(10));
    }

    public static function with(string $string): PostContent
    {
        return PostContent::from($string);
    }

    public static function empty(): PostContent
    {
        return self::with('');
    }
}