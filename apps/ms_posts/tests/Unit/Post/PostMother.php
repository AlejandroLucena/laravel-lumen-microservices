<?php

namespace UnitTest\Post;

use Modules\Post\Domain\Post;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;

class PostMother{

    public static function dummy(): Post
    {
        $values = [
            'id' => IdValueObjectMother::dummy(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::dummy(),
            'created_at' => DateTimeValueObjectMother::dummy(),
            'updated_at' => DateTimeValueObjectMother::dummy(),
        ];

        $post = Post::create(
            $values['title'],
            $values['slug'],
            PostContentMother::with('Updated'),
            $values['created_at'],
        );

        $post->update(
            $values['id'],
            $values['title'],
            $values['slug'],
            PostContentMother::with('Updated'),
            $values['updated_at'],
        );

        return $post;
    }

    public static function withTitle(string $value): Post
    {
        $title = PostTitleMother::with($value);

        $values = [
            'id' => IdValueObjectMother::dummy(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::dummy(),
            'created_at' => DateTimeValueObjectMother::dummy(),
            'updated_at' => DateTimeValueObjectMother::dummy(),
        ];

        $post = Post::create(
            $values['title'],
            $values['slug'],
            $values['content'],
            $values['created_at'],
        );

        $post->update(
            $values['id'],
            $title,
            $values['slug'],
            PostContentMother::with('Updated'),
            $values['created_at'],
        );
        return $post;
    }
    
    public static function emptyTitle(): Post
    {
        return self::withTitle('');
    }
}