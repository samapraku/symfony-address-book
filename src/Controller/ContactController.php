<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\ContactManager;
use App\Form\ContactType;
use App\Service\FileUploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {
        return $this->redirectToRoute('contact_list');
    }

    /**
     * @Route("/list", name="contact_list", methods={"GET"})
     */
    public function list(ContactManager $contactManager): Response
    {
        $contacts = $contactManager->getContactsList();
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/new", name="new_contact",  methods={"GET", "POST"})
     */
    public function newContact(Request $request, ContactManager $contactManager, FileUploaderService $fileUploader)
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $image = $form->get('uploadedImage')->getData();
            if($image){
                $imageFileName = $fileUploader->upload($image);
                $contact->setImageFilename($imageFileName);
            }     

            $result = $contactManager->saveContact($contact);
            
            if($result){

                $this->addFlash(
                    'success',
                    'The address was successfully created.'
                );
                
            }
            else {
                $this->addFlash(
                    'danger',
                    'There was a problem creating the address'
                );
            }

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/new_contact.html.twig', [
           'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("contact/{id}/edit", name="edit_contact",  requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function editContact(Contact $contact, Request $request, ContactManager $contactManager,  FileUploaderService $fileUploader)
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $image = $form->get('uploadedImage')->getData();
            if($image){
                //delete old picture if exists and upload new
                $contactManager->updateContactImage($contact, $image);
            }     
    
            $result = $contactManager->saveContact($contact);
            if($result){

                $this->addFlash(
                    'success',
                    'The address was successfully updated.'
                );
                
            }
            else {
                $this->addFlash(
                    'danger',
                    'There was a problem updating the address'
                );
            }
            return $this->redirectToRoute('edit_contact', [
                'id' => $contact->getId()
            ]);
        }

        return $this->render('contact/edit_contact.html.twig', [
           'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("contact/{id}/delete", name="delete_contact", )
     */
    public function deleteContact(Contact $contact, ContactManager $contactManager)
    {
             if($contactManager->deleteContact($contact)){
                $this->addFlash(
                    'success',
                    'The contact was successfully deleted.'
                );
             }
             else {
                 $this->addFlash(
                     'danger', 
                     'Image was not deleted.'
                 );
             }

        
            return $this->redirectToRoute('contact_list', [
                'id' => $contact->getId()
            ]);
    }
}