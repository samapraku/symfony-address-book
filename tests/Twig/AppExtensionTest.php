<?php

namespace App\Tests\Twig;

use PHPUnit\Framework\TestCase;

use App\Twig\AppExtension;

class AppExtensionTest extends TestCase
{
    /**
     * @dataProvider getCountryCodes
     */
    public function testCountryName(string $code, string $country)
    {
        $extension = new AppExtension;
        $this->assertSame($country, $extension->getCountryName($code));
    }
    
    public function getCountryCodes() {
         yield ['DE','Germany'];
         yield ['GB', 'United Kingdom'];
         yield ['US', 'United States'];
         yield ['CA', 'Canada'];
    }

}