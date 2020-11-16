<?php 

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;

class ContactManager {


    public $contactList;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function listContacts(){
        $this->contactList = $this->entityManager->getRepository(Contact::class)->findAll();
        return $this->contactList;
    }

    public function loadContact($id)
    {
       return $this->entityManager->find($id);
    }

    public function saveContact(Contact $contact){
        $this->entityManager->persist($contact);
        $this->entityManager->flush();    
    }

    public function deleteContact($id)
    {
        
    }
}