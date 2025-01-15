<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Mail\ContactNotification;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends BaseController
{
    /**
     * @OA\Schema(
     * schema="Contact",
     * required={"name", "email", "tel"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="j3v5m@example.com"),
     * @OA\Property(property="tel", type="string", example="1234567890"),
     * @OA\Property(property="message", type="string", example="Message"),
     * )
     */
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }
    //
    /**
     * @OA\Get(
     *      path="/api/v2/contact/list",
     *      operationId="getContacts",
     *      tags={"Contacts"},
     *      summary="Get list of contacts",
     *      description="Returns list of contacts",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving contacts"
     *    )
     *  )
     */
    public function index(Request $request)
    {
        $contacts = $this->contactService->getAll();
        return $this->sendResponse(new ContactResource(collect($contacts)), 'Contacts retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/v2/contact",
     *      operationId="addContact",
     *      tags={"Contacts"},
     *      summary="Add a new contact",
     *      description="Returns contact data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Contact created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error creating contact"
     *    )
     *  )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        try {
            $contact = $this->contactService->create($validated);
            Mail::to('direction@softskills.ci')->send(new ContactNotification($contact));

            return $this->sendResponse(new ContactResource($contact), 'Contact created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error creating contact', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $contact = $this->contactService->findById($id);

            return $this->sendResponse(new ContactResource($contact), 'Contact retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendResponse('Error retrieving contact', $e->getMessage());
        }
    }

    /**
     * @OA\Put(
        *      path="/api/v2/update/contact/{id}",
        *      operationId="updateContact",
        *      tags={"Contacts"},
        *      summary="Update an existing contact",
        *      description="Returns updated contact data",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(ref="#/components/schemas/Contact")
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Contact updated successfully",
        *          @OA\JsonContent(ref="#/components/schemas/Contact")
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Contact not found"
        *      ),
        *      @OA\Response(
        *        response=500,
        *       description="Error updating contact"
        *
        *    )
        *  )
        */
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        try {
            $contact = $this->contactService->update($validated, $id);

            return $this->sendResponse(new ContactResource($contact), 'Contact updated successfully');
        } catch (\Exception $e) {
            return $this->sendResponse('Error updating contact', $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v2/contact/delete/{id}",
     *      operationId="deleteContact",
     *      tags={"Contacts"},
     *      summary="Delete an existing contact",
     *      description="Returns deleted contact data",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Contact deleted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error deleting contact"
     *    )
     *  )
     */
    public function destroy($id)
    {
        try {
            $contact = $this->contactService->delete($id);
            return $this->sendResponse(new ContactResource($contact), 'Contact deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting contact', ['error' => $e->getMessage()], 500);
        }
    }
}
