<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\ContactManager;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ContactManager $contactManager): Response
    {
        return $this->redirectToRoute('contact_list');
    }

    /**
     * @Route("/list", name="contact_list")
     */
    public function list(ContactManager $contactManager): Response
    {
        $contacts = $contactManager->listContacts();
        dump($contacts);
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/new", name="new_contact")
     */
    public function newContact(Request $request, ContactManager $contactManager)
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contactManager->saveContact($contact);

            return $this->redirectToRoute('home_page');
        }

        return $this->render('contact/new_contact.html.twig', [
           'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("contact/{id}/edit", name="edit_contact")
     */
    public function editContact(Contact $contact, Request $request, ContactManager $contactManager)
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $contactManager->saveContact($contact);
            return $this->redirectToRoute('edit_contact', [
                'id' => $contact->getId()
            ]);
        }

        return $this->render('contact/edit_contact.html.twig', [
           'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }

}