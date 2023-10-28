<?php
namespace UnitTest\Post\Domain\ValueObject;

use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\Exception\InvalidValueException;
use UnitTest\Post\PostTestCase;

class PostTitleTest extends PostTestCase
{

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostTitleOk(): void
    {
        $value = 'lorem ipsun';
        $expected = $value;

        $return = PostTitle::from($value);

        $this->assertEquals($expected, $return->value()); 
    }

    
    /**
     * @test
     * @return void
     */
    public function shouldCreatePostTitleKoFormat(): void
    {
        $value = 'fo';

        $this->expectException(InvalidValueException::class);
        PostTitle::from($value);
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostTitleKo(): void
    {
        $value = 1;
    
        $this->expectException(InvalidValueException::class);
        PostTitle::from($value);
    }

}