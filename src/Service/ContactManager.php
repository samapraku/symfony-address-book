<?php 

namespace App\Service;
use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ContactManager {


    private $objectManager;
    public $contactList;

    public function __construct(ObjectManager  $objectManager, FileUploaderService $fileUploader)
    {
        $this->objectManager = $objectManager;
        $this->contactList = new ArrayCollection();
        $this->fileUploader = $fileUploader;
    }

    public function getContactsList(){
        $this->contactList = $this->objectManager->getRepository(Contact::class)->findAll();
        return $this->contactList;
    }

    public function loadContact($id)
    {
       return $this->objectManager->getRepository(Contact::class)->find($id);
    }

    public function saveContact(Contact $contact){
        
        $this->objectManager->persist($contact);
        $this->objectManager->flush();    
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
            $this->objectManager->remove($contact);
            $this->objectManager->flush();
            return true;
        }
        else return false;
    }

    private function deleteImage($path) : bool
    {
        return $this->fileUploader->delete($path);
    }

}