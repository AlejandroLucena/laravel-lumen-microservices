<?php

namespace UnitTest\Post\Domain\ValueObject;

use Modules\Post\Domain\ValueObject\PostContent;
use Faker\Factory;
use UnitTest\Post\PostTestCase;

class PostContentTest extends PostTestCase
{
    /**
     * @test
     * @return void
     */
    public function shouldCreatePostContentOk(): void
    {
        $paragraph = Factory::create()->paragraph;

        $return = PostContent::from($paragraph);

        $this->assertEquals($paragraph, $return->value()); 
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostContentKo(): void
    {
        $value = 1;
        $expected = $value;

        $return = PostContent::from($value);

        $this->assertNotEquals(gettype($expected), gettype($return->value())); 
    }

}