<?php 

namespace App\Service;
use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
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

    public function getContactsList($page, $sort_method = '', $search = ''){
        $this->contactList = $this->objectManager->getRepository(Contact::class)->findAllPaginated($page, $sort_method, $search);
        return $this->contactList;
    }

    public function loadContact($id)
    {
       return $this->objectManager->getRepository(Contact::class)->find($id);
    }

    public function saveContact(Contact $contact): bool 
    {
        
        $this->objectManager->persist($contact);
        $this->objectManager->flush(); 
        return true;
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

    public function apiSaveContact(Request $request)
    {
      
      $contact = new Contact();
        
      $contact->setFirstname($request->get('firstName'))
     ->setLastname($request->get('lastName')) 
     ->setStreetname($request->get('streetName')) 
     ->setStreetnumber($request->get('streetNumber'))
     ->setZip($request->get('zip'))
     ->setCity($request->get('city'))
     ->setPhonenumber($request->get('phoneNumber')) 
     ->setCountry($request->get('country'))
     ->setEmailaddress($request->get('emailAddress'));
     
      return $this->saveContact($contact);
 
        
    }

    private function deleteImage($path) : bool
    {
        return $this->fileUploader->delete($path);
    }

}