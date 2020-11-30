<?php

namespace App\Tests\Controller;

use App\DataFixtures\ContactFixtures;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;


class ApiControllerTest extends AbstractControllerTest
{
    public function testListAddresses()
    {
        date_default_timezone_set('UTC');
        $this->loadFixture(new ContactFixtures());
        $this->client->request('GET', '/api/addresses');

        $response = $this->client->getResponse();

        $actual = json_encode([               
                [
                    'id' => 2,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone_number' => '+44245076408',
                    'city' => 'Doe City',
                    'zip' => '0000',
                    'street_name' => 'Doe Street',
                    'street_number' => '24',
                    'birthday' => [
                        'date' => '1990-01-01 00:00:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                    'country' => 'GB'
                ], [
                    'id' => 1,
                    'first_name' => 'Max',
                    'last_name' => 'Mustermann',
                    'phone_number' => '+49123456789',
                    'city' => 'Musterstadt',
                    'zip' => '04299',
                    'street_name' => 'Mustermann Straße',
                    'street_number' => '29',
                    'birthday' => [
                        'date' => '2000-01-01 00:00:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                    'country' => 'DE'
                ]
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($response->getContent(), $actual);
    }

    public function testSingleAddress()
    {
        $this->loadFixture(new ContactFixtures());
        $this->client->request('GET', 'api/addresses/1');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($response->getContent(), json_encode(
            [
                'id' => 1,
                'first_name' => 'Max',
                'last_name' => 'Mustermann',
                'phone_number' => '+49123456789',
                'city' => 'Musterstadt',
                'zip' => '04299',
                'street_name' => 'Mustermann Straße',
                'street_number' => '29',
                'birthday' => [
                    'date' => '2000-01-01 00:00:00.000000',
                    'timezone_type' => 3,
                    'timezone' => 'UTC'
                ],
                'country' => 'DE'
            ]
        ));
    }

    public function testSingleAddressNotFound()
    {
        $this->client->request('GET', '/api/addresses/1');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testCreateAddress()
    {
        $this->loadFixture(new ContactFixtures());
        $firstName = 'Max';
        $this->client->request('POST', 'api/addresses', [], [], [], json_encode([
            'firstName'    => $firstName,
            'lastName' => 'Mustermann',
            'streetName' => 'Mustermann Straße',
            'streetNumber' => '29',
            'zip' => '12344',
            'city' => 'Musterstadt',
            'country' => 'DE',
            'phoneNumber' => '+49234244335454',
            'birthDay' => '2000-01-01',
            'emailAddress' => 'muster@mustermail.com',
        ]));

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Contact $contact */
        $contact = $em->getRepository(Contact::class)->find(3);
        $this->assertEquals($firstName, $contact->getFirstName());
    }

    
    public function testDeleteProduct()
    {
        $this->loadFixture(new ContactFixtures());
        $this->client->request('DELETE', '/api/addresses/1');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());

        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Contact $contact */
        $contact = $em->getRepository(Contact::class)->findAll();
        $this->assertCount(1, $contact);
    }
}