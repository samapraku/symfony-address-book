<?php

namespace App\Tests;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        
        $date = new \DateTime();
        $formData = [
                'firstName' =>'Max', 
                'lastName'=>'Mustermann', 
                'streetName'=>'Mustermann Straße', 
                'streetNumber'=>'29',
                'zip'=>'04299',
                'city'=>'Musterstadt',
                'phoneNumber'=>'+49123456789', 
                'country'=>'DE',
                'emailAddress'=>'muster@email.com',
             

        ];

        $model = new Contact();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ContactType::class, $model);

        $expected = new Contact();
        $expected->setFirstname($formData['firstName'])
        ->setLastname($formData['lastName']) 
        ->setStreetname($formData['streetName']) 
        ->setStreetnumber($formData['streetNumber'])
        ->setZip($formData['zip'])
        ->setCity($formData['city'])
        ->setPhonenumber($formData['phoneNumber']) 
        ->setCountry($formData['country'])
        ->setEmailaddress($formData['emailAddress']);
        //->setBirthday($date);      

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}