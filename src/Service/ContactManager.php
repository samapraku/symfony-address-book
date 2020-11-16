<?php 

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;

class ContactManager {


    public $contactList;

    public function __construct(EntityManagerInterface $entityManager, FileUploaderService $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->contactList = new ArrayCollection();
        $this->fileUploader = $fileUploader;
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

    public function deleteContact(Contact $contact)
    {
        $result = $this->fileUploader->delete($contact->getImagePath());
        if($result)
        {
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
            return true;
        }
        else return false;
    }
}