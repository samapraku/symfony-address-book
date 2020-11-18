<?php

namespace App\Tests;

use App\DataFixtures\ContactFixtures;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Service\ContactManager;
use App\Service\FileUploaderService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactManagerTest extends KernelTestCase
{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

    }
    
    public function testGetContactsList(){

        $contactRepository = $this->createMock(ContactRepository::class);
        $contactRepository->expects($this->once())
        ->method('findAll')
        ->willReturn([new Contact(), new Contact()]);
        
        /** @var ObjectManager | MockObject $mockEntityMgr */ 
        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->once())
        ->method('getRepository')
        ->willReturn($contactRepository); 

        /** @var FileUploaderService | MockObject $mockFileUploader */ 
        $mockFileUploader =   $this->createMock(FileUploaderService::class);
        $contactManager = new ContactManager($objectManager, $mockFileUploader);
        $contactList = $contactManager->getContactsList();
        $this->assertCount(2, $contactList);
    }

}