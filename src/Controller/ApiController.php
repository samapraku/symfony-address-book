<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Service\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api", name="contact_api")
 */
class ApiController extends Controller
{

    /**
     * @param ContactManager $contactManager
     * @return JsonResponse
     * @Route("/addresses/{page}", name="api_contacts", methods={"GET"}, defaults={"page":1})
     */
    public function getContacts($page, ContactManager $contactManager)
    {
        $data = $contactManager->getContactsList($page);
       
        return $this->response($data->getItems());
    }

    /**
     * @param Request $request
     * @param ContactManager $contactManager
     * @return JsonResponse
     * @throws \Exception
     * @Route("/address", name="api_add_contact", methods={"POST"})
     */
    public function addAddress(Request $request, ContactManager $contactManager)
    {

        try {
            $request = $this->transformJsonBody($request);

            if (!$request) {
                throw new \Exception();
            }

            $result = $contactManager->apiSaveContact($request);

            if ($result) {
                $data = [
                    'status' => 201,
                    'success' => "Address added successfully",
                ];

                return $this->response($data);
            }
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data not valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param ContactManager $contactManager
     * @param $id
     * @return JsonResponse
     * @Route("/addresses/{id}", name="api_get_address", methods={"GET"})
     */
    public function getAddress(ContactManager $contactManager, $id)
    {
        $contact = $contactManager->loadContact($id);

        if (!$contact) {
            $data = [
                'status' => 404,
                'errors' => "Address not found",
            ];
            return $this->response($data, 404);
        }
        return $this->response($contact);
    }


    /**
     * @param Request $request
     * @param ContactManager $contactManager
     * @param $id
     * @return JsonResponse
     * @Route("/address/{id}", name="api_address_put", methods={"PUT"})
     */
    public function updateAddress($id, Request $request, ContactManager $contactManager)
    {

        try {
            $contact = $$contactManager->loadContact($id);

            if (!$contact) {
                $data = [
                    'status' => 404,
                    'errors' => "Address not found",
                ];
                return $this->response($data, 404);
            }

            $request = $this->transformJsonBody($request);


            $result = $contactManager->apiSaveContact($request);
            $contact = $$contactManager->loadContact($id);

            if ($result) {
                $data = [
                    'status' => 200,
                    'errors' => "Contact updated successfully",
                ];
                return $this->response($data);
            }
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data not valid",
            ];
            return $this->response($data, 422);
        }
    }

   /**
   * @param $id
   * @param ContactManager $contactManager
   * @return JsonResponse
   * @Route("/addresses/{id}", name="api_address_delete", methods={"DELETE"})
   */
  public function deleteAddress( $id, ContactManager $contactManager){
    $address = $contactManager->loadContact($id);
 
    if (!$address){
     $data = [
      'status' => 404,
      'errors' => "Address not found",
     ];
     return $this->response($data, 404);
    }
    
    $contactManager->deleteContact($address);
   
    $data = [
     'status' => 200,
     'errors' => "Address deleted successfully.",
    ];
    return $this->response($data);
   }

    private function validateRequest(Request $request): array
    {
        $missing = [];
        if (!$request->$request->get('firstName')) {
            $missing['firstName'];
        }
        if (!$request->request->get('lastName')) {
            $missing['lastName'];
        }
        return $missing;
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }


    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}