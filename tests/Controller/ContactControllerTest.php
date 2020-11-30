<?php

namespace App\Tests\Controller;

use App\DataFixtures\ContactFixtures;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ContactControllerTest extends AbstractControllerTest
{
   
    /**
    * @dataProvider provideUrls
    */
    public function testPageIsSuccessful($url)
    {        
        $this->loadFixture(new ContactFixtures());
        $this->client->followRedirects(true);
        $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
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
        $this->loadFixture(new ContactFixtures());
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', '/new');

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
        $this->client->submit($form);
        $this->assertStringContainsString(
    	    'The address was successfully created.',
    	    $this->client->getResponse()->getContent()
	);
    }

    
    public function testUpateContact()
    {
        $this->loadFixture(new ContactFixtures());
        $this->client->followRedirects(true);
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $oldContact = new Contact();
        $oldContact = $entityManager->createQueryBuilder()->select('c')
        ->from("\App\Entity\Contact", 'c')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

        $id = $oldContact->getId();
        
       
        $crawler = $this->client->request('GET', "/contact/{$id}/edit");

        $buttonCrawlerNode = $crawler->selectButton('Update');
        $form = $buttonCrawlerNode->form();
        $this->client->submit($form);
        $this->assertStringContainsString(
    	    'The address was successfully updated.',
    	    $this->client->getResponse()->getContent()
	);
    }
    
    public function testCreateNewContactWithPicture()
    {
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', '/new');

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
        $this->client->submit($form);
        $this->assertStringContainsString(
    	    'The address was successfully created.',
    	    $this->client->getResponse()->getContent()
	);
    }

    
    public function testNoSearchResult()
    {
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', '/list');

        $formNode = $crawler->filter('form#form-sort-search');
        $form = $formNode->form([
            'search'    => 'NoName'
        ]);
        
        $crawler = $this->client->submit($form);
        
        $this->assertStringContainsString(
    	    'No address was found.',
    	    $crawler->filter('h1')->text()
	);
    }

    
    public function testSearchFound()
    {
        $this->loadFixture(new ContactFixtures());
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', '/list');

        $formNode = $crawler->filter('form#form-sort-search');
        $form = $formNode->form([
            'search'    => 'Max'
        ]);
        
        $crawler = $this->client->submit($form);
        $this->assertGreaterThanOrEqual(1, 
    	    $crawler->filter('li.list-group-item')->count()
	);
    }

    public function tearDown() : void
    {
        parent::tearDown();   

        // Remove uploaded test images
        $files = glob(__DIR__.'/../../public/uploads/images/default-img-*.png'); // get all uploaded test images
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }
}