<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactNotification;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
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
        return response()->json($contacts);
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

            return response()->json([
                'success' => 'contact created successfully',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $contact = $this->contactService->findById($id);

            return response()->json([
                'success' => true,
                'message' => 'Contact retrieved successfully',
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving contact',
                'error' => $e->getMessage()
            ], 500);
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

            return response()->json([
                'success' => true,
                'message' => 'Contact updated successfully',
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating contact',
                'error' => $e->getMessage()
            ], 500);
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

            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully',
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
