<?php

use PHPUnit\Framework\TestCase;
use UnitTest\Post\PostTestCase;

class CreatePostTest extends TestCase
{
    /**
     * @test 
     * A test to create post.
     *
     * @return void
     */
    public function testBasicExample(): void
    {
        $this->json('POST', '/api/posts', [
            'title' => 'test title',
            'slug' => 'test-title',
            'content' => ''])
             ->seeJson([
                'created' => true,
             ]);
    }
}