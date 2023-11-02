<?php

declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class Post
{
    private ?DateTimeValueObject $deletedAt;

    public function __construct(
        private ?IdValueObject $id,
        private PostTitle $title,
        private ?SlugValueObject $slug,
        private ?PostContent $content,
        private DateTimeValueObject $createdAt,
        private ?DateTimeValueObject $updatedAt = null,
    ) {
        $this->deletedAt = null;
    }

    public function id(): ?IdValueObject
    {
        return $this->id;
    }

    public function title(): PostTitle
    {
        return $this->title;
    }

    public function slug(): SlugValueObject
    {
        return $this->slug;
    }

    public function content(): ?PostContent
    {
        return $this->content;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DateTimeValueObject
    {
        return $this->deletedAt;
    }

    public static function create(
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $createdAt,
    ): Post {
        return new self(
            null,
            $title,
            $slug,
            $content,
            $createdAt
        );
    }

    public function update(
        IdValueObject $id,
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $updateAt,
    ): self {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->updatedAt = $updateAt;
        return $this;
    }

    /**
     * Summary of delete
     */
    public function delete(): void
    {
        $this->deletedAt = DateTimeValueObject::now();
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            IdValueObject::from($primitives['id']),
            PostTitle::from($primitives['title']),
            SlugValueObject::from($primitives['slug']),
            PostContent::from($primitives['content']),
            DateTimeValueObject::createFromString($primitives['created_at']),
            DateTimeValueObject::createFromString($primitives['updated_at'])
        );
    }

    public static function fromValueObjects(array $valueObjects): self
    {
        return new self(
            IdValueObject::from($valueObjects['id']->value()),
            PostTitle::from($valueObjects['title']->value()),
            SlugValueObject::from($valueObjects['slug']->value()),
            PostContent::from($valueObjects['content']->value()),
            DateTimeValueObject::createFromString($valueObjects['created_at']->toIso8601Format()),
            DateTimeValueObject::createFromString($valueObjects['updated_at']->toIso8601Format())
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
