<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Persistence\Eloquent;

use Modules\Post\Domain\Model\Post as EloquentPostModel;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Post;
use Exception;
use Illuminate\Support\Facades\Cache;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Resource\PostResource;
use Modules\Shared\Domain\Criteria\Criteria;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class EloquentPostRepository implements PostRepository
{

    public function __construct(
        private readonly EloquentPostModel $eloquentPostModel
    ) {
    }

    public function save(Post $post): void
    {
        try {
            Cache::forget('posts_all');

            $eloquentPost = $this->eloquentPostModel;
            $eloquentPost->title = $post->title()->value();
            $eloquentPost->slug = $post->slug()->value();
            $eloquentPost->content = $post->content()->value();
            $eloquentPost->created_at = $post->createdAt()->toIso8601Format();

            $eloquentPost->save();

            Cache::rememberForever('posts_all', function () {
                return $this->eloquentPostModel->all();
            });
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function update(Post $post): void
    {
        $id = $post->id()->value();
        try {
            Cache::forget('posts_all');
            Cache::forget('post_' . $id);

            $eloquentPost = $this->eloquentPostModel->find($post->id()->value());
            $eloquentPost->title = $post->title()->value();
            $eloquentPost->slug = $post->slug()->value();
            $eloquentPost->content = $post->content()->value();
            $eloquentPost->updated_at = $post->updatedAt()->toIso8601Format();

            $eloquentPost->save();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function find(IdValueObject $id): ?array
    {
        $id = $id->value();
        try {
            if (!Cache::has('post_' . $id)) {
                Cache::rememberForever('post_' . $id, function () use ($id) {
                    return $this->eloquentPostModel->find($id);
                });
            }
            $post = Cache::get('post_' . $id);

            if(!$post)
            {
                return [];
            }
            return PostResource::make($post)->resolve();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function findBySlug(SlugValueObject $slug): ?array
    {
        $value = $slug->value();
        try {
            if (!Cache::has('post_' . $value)) {
                Cache::rememberForever('post_' . $value, function () use ($value) {
                    return $this->eloquentPostModel->whereSlug($value)->first();
                });
            }
            $post = Cache::get('post_' . $value);
            if(!$post)
            {
                return [];
            }
            return PostResource::make($post)->resolve();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function findAll(): ?array
    {
        try {
            if (!Cache::has('posts_all')) {
                Cache::rememberForever('posts_all', function () {
                    return $this->eloquentPostModel->get();
                });
            }
            $posts = Cache::get('posts_all');

            return PostResource::collection($posts)->resolve();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    /**
     * findAllPostsByCourseId
     *
     * @param  mixed  $categoryId
     */
    public function FindAllPostsByCategoryId(IdValueObject $categoryId): array
    {
        $cache = 'posts_all_by_category_' . $categoryId->value();
        $id = $categoryId->value();
        try {
            if (!Cache::has($cache)) {
                Cache::rememberForever($cache, function () use ($id) {
                    return $this->eloquentPostModel->with('categories')->where('category_id', $id)->get();
                });
            }
            $posts = Cache::get($cache);

            return PostResource::collection($posts)->resolve();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function matching(Criteria $criteria): array
    {
        try {
            return PostResource::collection($this->eloquentPostModel->get())->resolve();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    public function delete(IdValueObject $id): bool
    {
        try {
            Cache::forget('posts_all');
            Cache::forget('post_' . $id->value());

            $eloquentModel = $this->eloquentPostModel->find($id->value());

            return $eloquentModel->delete();
        } catch (Exception $e) {
            Cache::rememberForever('posts_all', function () {
                return $this->eloquentPostModel->all();
            });
            throw new BadRequestException($e->getMessage());
        }
    }
}
