<?php

namespace App\Twig;

use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('country_name', [$this, 'getCountryName']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('country_name', [$this, 'getCountryName']),
        ];
    }

    public function getCountryName($countryCode) : string
    {
        if(is_null($countryCode)) return 'No country selected';
        $countryCode = strtoupper($countryCode);
        $country = Intl::getRegionBundle()->getCountryName($countryCode);
        return $country ?? $countryCode;
    }
}