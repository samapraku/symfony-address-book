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
}