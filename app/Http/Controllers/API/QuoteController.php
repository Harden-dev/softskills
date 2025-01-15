<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuoteController extends BaseController 
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
        return $this->sendResponse(new QuoteResource(collect($quotes)), 'Quotes retrieved successfully');
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

           return $this->sendResponse(new QuoteResource($quote), 'Quote created successfully');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return $this->sendError('Error creating quote', $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $quote = $this->quoteService->findById($id);

           return $this->sendResponse(new QuoteResource($quote), 'Quote retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving quote', $e->getMessage());
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
            return $this->sendResponse(new QuoteResource($quote), 'Quote updated successfully');
        } catch (\Exception $th) {
            return $this->sendError('Error updating quote', $th->getMessage());
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
            return $this->sendResponse(new QuoteResource($quote), 'Quote deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Error deleting quote', $th->getMessage());
        }
    }
}
