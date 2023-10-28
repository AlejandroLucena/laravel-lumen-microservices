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
            IdValueObject::from($primitives['id']->value()),
            PostTitle::from($primitives['title']->value()),
            SlugValueObject::from($primitives['slug']->value()),
            PostContent::from($primitives['content']->value()),
            DateTimeValueObject::createFromString($primitives['created_at']->toIso8601Format()),
            DateTimeValueObject::createFromString($primitives['updated_at']->toIso8601Format())
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
