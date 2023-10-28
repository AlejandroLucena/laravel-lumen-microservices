<?php
namespace UnitTest\Shared\Domain\ValueObject;

use Modules\Shared\Domain\Exception\InvalidValueException;
use Modules\Shared\Domain\ValueObject\SlugValueObject;
use UnitTest\Post\PostTestCase;

class SlugValueObjectTest extends PostTestCase
{

    /**
     * @test
     * @return void
     */
    public function shouldCreateSlugValueObjectOk(): void
    {
        $value = 'lorem-ipsun';
        $expected = $value;

        $return = SlugValueObject::from($value);

        $this->assertEquals($expected, $return->value()); 
    }

    
    /**
     * @test
     * @return void
     */
    public function shouldCreateSlugValueObjectKoFormat(): void
    {
        $value = 'fo ';

        $this->expectException(InvalidValueException::class);
        SlugValueObject::from($value);
    }
}