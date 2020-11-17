<?php

namespace App\Tests\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    

    public function testCreateNewContactWithoutPicture()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/new');

        $buttonCrawlerNode = $crawler->selectButton('Add new address');
        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form([
            'contact[firstName]'    => 'Max',
            'contact[lastName]' => 'Mustermann',
            'contact[streetName]' => 'Mustermann Straße',
            'contact[streetNumber]' => '29',
            'contact[zip]' => '12344',
            'contact[city]' => 'Musterstadt',
            'contact[country]' => 'DE',
            'contact[phoneNumber]' => '+49234244335454',
            'contact[birthDay]' => '2000-01-01',
            'contact[emailAddress]' => 'muster@mustermail.com'

        ]);
        $client->submit($form);
        $this->assertContains(
    	    'The address was successfully created.',
    	    $client->getResponse()->getContent()
	);
    }

    
    public function testUpateContact()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $oldContact = new Contact();
        $oldContact = $entityManager->createQueryBuilder()->select('c')
        ->from("\App\Entity\Contact", 'c')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

        $id = $oldContact->getId();
        
       
        $crawler = $client->request('GET', "/contact/{$id}/edit");

        $buttonCrawlerNode = $crawler->selectButton('Update');
        $form = $buttonCrawlerNode->form();
        $client->submit($form);
        $this->assertContains(
    	    'The address was successfully updated.',
    	    $client->getResponse()->getContent()
	);
    }
    
    public function testCreateNewContactWithPicture()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/new');

        $buttonCrawlerNode = $crawler->selectButton('Add new address');
        
        $uploadedFile = new UploadedFile(
            __DIR__.'/../../src/DataFixtures/default-img.png',
            'default-img.png'
        );

        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form([
            'contact[firstName]'    => 'Max',
            'contact[lastName]' => 'Mustermann',
            'contact[streetName]' => 'Mustermann Straße',
            'contact[streetNumber]' => '29',
            'contact[zip]' => '12344',
            'contact[city]' => 'Musterstadt',
            'contact[country]' => 'DE',
            'contact[phoneNumber]' => '+49234244335454',
            'contact[birthDay]' => '2000-01-01',
            'contact[emailAddress]' => 'muster@mustermail.com',
            'contact[uploadedImage]' => $uploadedFile

        ]);
        $client->submit($form);
        $this->assertContains(
    	    'The address was successfully created.',
    	    $client->getResponse()->getContent()
	);
    }

}