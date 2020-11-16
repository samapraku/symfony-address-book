<?php 

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function updateContactImage(Contact &$contact, UploadedFile $image){
        //delete old image if new image is uploaded
        if(!empty($contact->getImageFilename())){
            $this->deleteImage($contact->getImagePath());
        }
        $imageFileName = $this->fileUploader->upload($image);
        $contact->setImageFilename($imageFileName);
    }

    public function deleteContact(Contact $contact)
    {
        $result = $this->deleteImage($contact->getImagePath());
        if($result)
        {
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
            return true;
        }
        else return false;
    }

    private function deleteImage($path) : bool
    {
        return $this->fileUploader->delete($path);
    }

}