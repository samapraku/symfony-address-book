<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    
    /**
    * @dataProvider provideUrls
    */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    
    public function provideUrls()
    {
        return [
            ['/'],
            ['/list'],
            ['/new'],
            ['/contact/1/edit'],
            ['/contact/1/delete'],
        ];
    }

}