<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    /**
     * @OA\Schema(
     * schema="Subscription",
     * required={"name", "email", "tel"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example=" B4TtD@example.com"),
     * @OA\Property(property="tel", type="string", example="1234567890"),
     * ),
     */
    protected $subscriptionService;

    //
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * @OA\Get(
     *      path="/api/v2/subscription/list",
     *      operationId="getSubscriptions",
     *      tags={"Subscriptions"},
     *      summary="Get list of subscriptions",
     *      description="Returns list of subscriptions",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Subscription")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Subscription not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving subscriptions"
     *    )
     *  )
     */
    public function index(Request $request)
    {
        $subscriptions = $this->subscriptionService->getAll();
        return $this->sendResponse(new SubscriptionResource(collect($subscriptions)), 'Subscriptions retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/v2/subscription",
     *      operationId="addSubscription",
     *      tags={"Subscriptions"},
     *      summary="Add a new subscription",
     *      description="Add a new subscription",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Subscription")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Subscription")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating subscription"
     *      )
     * )
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
        ]);

        try {
            $subscription = $this->subscriptionService->create($validated);

            return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error creating subscription', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $subscription = $this->subscriptionService->findById($id);

            return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription retrieved successfully');
        } catch (Exception $e) {
           return $this->sendError('Subscription not found', $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v2/update/subscription/{id}",
     *      operationId="updateSubscription",
     *      tags={"Subscriptions"},
     *      summary="Update an existing subscription",
     *      description="Update an existing subscription",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Subscription ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Subscription")
     *      ),
     *     @OA\Response(
     *         response=200,
     *        description="Subscription updated successfully",
     *        @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *    @OA\Response(
     *       response=404,
     *     description="Subscription not found"
     *  ),
     *   @OA\Response(
     *     response=500,
     *   description="Error updating subscription"
     * )
     * )
     */

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|max:199',
            'tel' => 'required|string|max:20',
        ]);

        try {
            $subscription = $this->subscriptionService->update( $validated, $id);
          return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription updated successfully');
        } catch (Exception $th) {
           return $this->sendError('Error updating subscription', $th->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v2/delete/subscription/{id}",
     *      operationId="deleteSubscription",
     *      tags={"Subscriptions"},
     *      summary="Delete an existing subscription",
     *      description="Delete an existing subscription",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Subscription ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Subscription deleted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Subscription")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Subscription not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error deleting subscription"
     *    )
     * )
     */

    public function destroy($id)
    {
        try {
            $subscription = $this->subscriptionService->delete($id);
            return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription deleted successfully');
        } catch (Exception $th) {
            return $this->sendError('Error deleting subscription', $th->getMessage());
        }
    }
}
