<?php

namespace imageColor\cases\util;

use imageColor\util\Color;
use imageColorTest\stubs\ColorJizzStub;
use imageColorTest\Unit;

class ColorTest extends Unit
{
    public function testColorAtReturnsCorrectObject()
    {
        $img = imagecreate(1, 1);
        $black = imagecolorallocate($img, 0, 0, 0);

        $color = Color::colorAt($img, 0, 0);

        $this->assertInstanceOf('MischiefCollective\ColorJizz\ColorJizz', $color);

        imagedestroy($img);
    }

    public function testColorConvertedToRGBIsCorrectColorSimpleColor()
    {
        $img = imagecreate(1, 1);
        $black = imagecolorallocate($img, 0, 0, 0);

        $color = Color::colorAt($img, 0, 0)->toRGB();

        $this->assertSame(0, $color->getRed());
        $this->assertSame(0, $color->getGreen());
        $this->assertSame(0, $color->getBlue());

        imagedestroy($img);
    }

    public function testColorConvertedToRGBIsCorrectColorComplexColor()
    {
        $img = imagecreate(1, 1);
        $black = imagecolorallocate($img, 15, 30, 45);

        $color = Color::colorAt($img, 0, 0)->toRGB();

        $this->assertSame(15, $color->getRed());
        $this->assertSame(30, $color->getGreen());
        $this->assertSame(45, $color->getBlue());

        imagedestroy($img);
    }

    public function testBestColorWithLowestColorBeingBlack()
    {
        $color = new ColorJizzStub();
        $color->data['distance'] = function($destinationColor) {
            if ($destinationColor->toHEX()->__toString() === '000000') {
                return 1;
            }

            return 10;
        };
        $bestColor = Color::bestColor($color);

        $this->assertSame('black', $bestColor);
    }

}
