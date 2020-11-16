<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadContacts($manager);
        
    }

    private function loadContacts($manager)
    {
        foreach ($this->getContactData() as $data) {
       
        $contact = new Contact;
        $contact
        ->setFirstName($data['firstname'])
        ->setLastName($data['lastname'])
        ->setStreetName($data['streetname'])
        ->setStreetNumber($data['streetnumber'])
        ->setPhoneNumber($data['phonenumber'])
        ->setBirthDay($data['birthday'])
        ->setEmailAddress($data['emailaddress'])
        ->setCountry($data['country'])
        ->setCity($data['city'])
        ->setZip($data['zip']);
        $manager->persist($contact); 
        }
        $manager->flush();
    }

    
    private function getContactData() : array
    {
        return [
            ['firstname' =>'Max', 'lastname'=>'Mustermann', 'streetname'=>'Mustermann Straße', 
              'streetnumber'=>'29', 'zip'=>'04299','city'=>'Musterstadt', 'phonenumber'=>'+49123456789', 
              'country'=>'DE','emailaddress'=>'muster@email.com',
             'birthday'=> \DateTime::createFromFormat("Y-m-d H:i:s", "2000-01-01 00:00:00")],
             ['firstname' => 'John', 'lastname' => 'Doe','streetname'=> 'Doe Street','streetnumber' => '24',
              'zip' => '0000', 'city' => 'Doe City', 'country' => 'GB',
              'phonenumber' => '+44245076408', 'emailaddress' =>'doe@email.com',
             'birthday' => \DateTime::createFromFormat("Y-m-d H:i:s", "1990-01-01 00:00:00")]
        ];
    }
}