<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategorieResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategorieController extends BaseController
{
    /**
     *@OA\Schema(
     *  schema="Category",
     *  title="Category",
     *  type="object",
     * properties={
     *      @OA\Property(property="id", type="integer", example="1"),
     *      @OA\Property(property="name", type="string", example="Category name")
     * }
     * )
     */

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *      path="/api/v2/category/list",
     *      operationId="getCategories",
     *      tags={"Categories"},
     *      summary="Get list of categories",
     *      description="Returns list of categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving categories"
     *    )
     *  )
     */
    public function index()
    {
        return $this->categoryService->getAll();
    }


    /**
 * @OA\Post(
 *      path="/api/v2/add/category",
 *      operationId="storeCategory",
 *      tags={"Categories"},
 *      summary="Create new category",
 *      description="Returns category data",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Category")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Category")
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Category not found"
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  example="The given data was invalid."
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Error creating category"
 *      )
 * )
 */


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        try {
            $category =  $this->categoryService->create($validated);

           return $this->sendResponse(new CategorieResource($category), 'Category created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Error creating category', $th->getMessage());
        }
    }

    /**
     * 
     * @OA\Get(
     *      path="/api/category/{id}",
     *      operationId="getCategoryById",
     *      tags={"Categories"},
     *      summary="Get category details",
     *      description="Returns category details",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found"
     *      ),
     * @OA\Response(
     *         response=500,
     *        description="Error retrieving category"
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $category = $this->categoryService->findByid($id);

            return $this->sendResponse(new CategorieResource($category), 'Category retrieved successfully');
        } catch (\Exception $th) {
            return $this->sendError('Error retrieving category', $th->getMessage());
        }
    }

    /**
 * @OA\Put(
 *      path="/api/v2/update/category/{id}",
 *      operationId="updateCategory",
 *      tags={"Categories"},
 *      summary="Update existing category",
 *      description="Returns updated category data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Category id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Category")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Category")
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Category not found"
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  example="The given data was invalid."
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Error updating category"
 *      )
 * )
 */

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required'
        ]);

        try {

            $category = $this->categoryService->update($validated, $id);

            return $this->sendResponse(new CategorieResource($category), 'Category updated successfully');
        } catch (\Exception $th) {
            return $this->sendError('Error updating category', $th->getMessage());
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/v2/delete/category/{id}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      summary="Delete existing category",
     *      description="Deletes a category",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Category deleted successfully"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found"
     *      ),
     * @OA\Response(
     *        response=500,
     *       description="Error deleting category"
     *     )
     *  )
     */
    public function destroy($id)
    {
        try {
            $category = $this->categoryService->findById($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }
            return $this->categoryService->delete($id);

            return $this->sendResponse(new CategorieResource($category), 'Category deleted successfully');
        } catch (\Exception $th) {
            return $this->sendServerError('Error deleting category', $th->getMessage());
        }
    }
}
