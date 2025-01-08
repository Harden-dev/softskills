<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuoteController extends Controller
{
    /**
     * @OA\Schema(
     * schema="Devis",
     * required={"name", "email", "tel", "personality", "dev", "budget"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="t5TtB@example.com"),
     * @OA\Property(property="tel", type="string", example="1234567890"),
     * @OA\Property(property="personality", type="string", example="particulier"),
     * @OA\Property(property="dev", type="string", example="site vitrine"),
     * @OA\Property(property="budget", type="string", example="1000"),
     * @OA\Property(property="description", type="string", example="Description")
     * )
     */
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }
    //
    /**
     * @OA\Get(
     *      path="/api/v2/quote/list",
     *      operationId="getQuotes",
     *      tags={"Devis"},
     *      summary="Get list of quotes",
     *      description="Returns list of quotes",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Devis")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Quote not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving quotes"
     *    )
     *  )
     */
    public function index(Request $request)
    {
        $quotes = $this->quoteService->getAll();
        return response()->json($quotes);
    }

    /**
     * @OA\Post(
     *      path="/api/v2/quote",
     *      operationId="addQuote",
     *      tags={"Devis"},
     *      summary="Add a new quote",
     *      description="Add a new quote",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Devis")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Quote created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Devis")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating quote",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
            'personality' => 'required|string',
            'dev' => 'required',
            'budget' => 'required',
            'description' => 'nullable|string'
        ], [
            'personality.required' => 'Préciser votre statut: particulier ou entreprise',
            'budget.required' => 'Préciser votre budget'
        ]);

        try {
            $quote = $this->quoteService->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Quote created successfully',
                'data' => $quote
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating quote',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $quote = $this->quoteService->findById($id);

            return response()->json([
                'success' => true,
                'message' => 'Quote retrieved successfully',
                'data' => $quote
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving quote',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v2/quote/upate/{id}",
     *      operationId="updateQuote",
     *      tags={"Devis"},
     *      summary="Update an existing quote",
     *      description="Update an existing quote",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Quote ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Devis")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Quote updated successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Devis")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Quote not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error updating quote"
     *    )
     *
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
            'personality' => 'required|string',
            'dev' => 'required',
            'budget' => 'required',
            'description' => 'nullable|string',
        ], [
            'personality.required' => 'Préciser votre statut: particulier ou entreprise',
            'budget.required' => 'Préciser votre budget'
        ]);

        try {
            $quote = $this->quoteService->update($validated, $id);
            return response()->json([
                'success' => true,
                'message' => 'Quote updated successfully',
                'data' => $quote
            ], 201);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating quote',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/quote/{id}",
     *    operationId="deleteQuote",
     *   tags={"Devis"},
     * summary="Delete a quote",
     * description="Delete a quote",
     * @OA\Parameter(
     *    name="id",
     *    in="path",
     *   description="Quote ID",
     * required=true,
     * @OA\Schema(
     *    type="integer"
     * )
     * ),
     * @OA\Response(
     *    response=200,
     *  description="Quote deleted successfully"
     * ),
     * @OA\Response(
     *    response=404,
     *  description="Quote not found"
     * ),
     * @OA\Response(
     *    response=500,
     *  description="Error deleting quote"
     *
     * ),
     * ) 
     */
    public function destroy($id)
    {
        try {
            $quote = $this->quoteService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Quote deleted successfully',
                'data' => $quote
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting quote',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
