<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Log;
use Storage;

class ArticleController extends BaseController
{
    /**
     * @OA\Info(
     *     title="Documentation API softskills",
     * description="Documentation API softskills",
     *    version="1.0.0",
     * @OA\Contact(
     *   name="Kouame Banh",
     *    email="kouamebanh@gmail.com"
     * )
     * )
     * 
     * @OA\Server(
     *    url=SWAGGER_LARAVEL_API_URL,
     *    description="API Server"
     * )
     * 
     */
    protected $articleService;

    /** 
     * @OA\Schema(
     *  schema="Article",
     * title="Article",
     * type="object",
     * required={"title, content, category_id, file"},
     * description="Modèle de l'article",
     * @OA\Property(
     *  property="title",
     *  type="string",
     *  description="Article title",
     *  example="Article title"
     * ),
     * @OA\Property(
     *  property="content",
     *  type="string",
     *  description="Article content",
     *  example="Article content"
     * ),
     * @OA\Property(
     *  property="category_id",
     *  type="integer",
     *  description="Category id",
     *  example="1"
     * ),
     * @OA\Property(
     *  property="file",
     *  type="file",
     *  description="Article image",
     *  example="image.jpg"
     * ),
     * @OA\Property(
     *  property="published_at",
     *  type="date",
     *  description="Article published_at",
     *  example="2023-01-01"
     * )
     * )
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @OA\Get(
     * path="/api/v2/article/list",
     * summary="Get all articles",
     * description="Get all articles",
     * operationId="index",
     * tags={"Articles"},    
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Article")
     *    ),
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No articles found.")
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="An error occurred.")
     *    ),
     * ),
     * )
     */


    public function index(Request $request)
    {
        $articles = $this->articleService->getAll();
        return $this->sendResponse(new ArticleResource(collect($articles)), 'Articles retrieved successfully');
    }

    /**
     * @OA\Get(
     * path="/api/v2/published/articles",
     * summary="Get all published articles",
     * description="Get all published articles",
     * operationId="publishedArticles",
     * tags={"Articles"},    
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Article")
     *    ),
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No articles found.")
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="An error occurred.")
     *    ),
     * ),
     * )
     */

    public function publishedArticles(Request $request)
    {
        $publishedArticles = $this->articleService->publishedArticles();
        return $this->sendResponse(new ArticleResource(collect($publishedArticles)), 'Articles retrieved successfully');
    }

    /**
     * @OA\Get(
     * path="/api/v2/scheduled/articles",
     * summary="Get all scheduled articles",
     * description="Get all scheduled articles",
     * operationId="scheduledArticles",
     * tags={"Articles"},    
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Article")
     *    ),
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No articles found.")
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="An error occurred.")
     *    ),
     * ),
     * )
     */


    public function scheduledArticles(Request $request)
    {
        $scheduledArticles = $this->articleService->scheduledArticles();
        return $this->sendResponse(new ArticleResource(collect($scheduledArticles)), 'Articles retrieved successfully');
    }

    /**
     * @OA\Post(
     * path="/api/v2/add/article",
     * summary="Create a new article",
     * description="Create a new article",
     * operationId="createArticle",
     * tags={"Articles"},    
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/Article")
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="Article created successfully"),
     *       @OA\Property(property="data", ref="#/components/schemas/Article")
     *    ),
     * ),    
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Unprocessable Entity",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object", example={
     *           "title": {"The title field is required."},
     *           "content": {"The content field is required."},
     *           "category_id": {"The category id field is required."},
     *           "published_at": {"The published at field is not required."}
     *       })
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="An error occurred.")
     *    ),
     * ),
     * )
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'file' => 'file|nullable|mimes:jpeg,png,jpg,webp,gif',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date'
        ]);

        try {

            $article = $this->articleService->create($validated);

            return $this->sendResponse(new ArticleResource($article), 'Article created successfully');
        } catch (Exception $th) {
            return $this->sendError('An error occurred', 500);
        }
    }

    /** 
     * @OA\Get(
     * path="/api/v2/article/{slug}",
     * summary="Get an article by slug", 
     * description="Get an article by slug", 
     * operationId="getArticleBySlug",
     * tags={"Articles"},
     * @OA\Parameter(
     *    name="slug",
     *    in="path",
     *    required=true,
     *    description="Slug of the article",
     *    @OA\Schema(
     *       type="string"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="data", ref="#/components/schemas/Article")
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Article not found")
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="An error occurred")
     *    ),
     * ),
     * )
     */

    public function show($slug)
    {
        try {
            $article = $this->articleService->find($slug);
            return $this->sendResponse(new ArticleResource($article), 'Article found successfully');
        } catch (Exception $th) {
           return $this->sendError('Article not found', 404);
        }
    }

    /**
     * @OA\Put(
     * path="/api/v2/update/article/{id}",
     * summary="Update an article", 
     * description="Update an article", 
     * operationId="updateArticle",
     * tags={"Articles"},
     * @OA\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,
     *    description="ID of the article",
     *    @OA\Schema(
     *       type="integer"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/Article")
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="data", ref="#/components/schemas/Article")
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="Article not found")
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Unprocessable Entity",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object", example={
     *           "title": {"The title field is required."},
     *           "content": {"The content field is required."},
     *           "category_id": {"The category id field is required."},
     *           "published_at": {"The published at field is not required."}
     *       })
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="An error occurred")
     *    ),
     * ),
     * )
     */

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'file' => 'file|nullable|mimes:jpeg,png,jpg,webp,gif',
            'category_id' => 'required|exists:categories,id',
            'published_at'=> 'nullable'
        ]);

        try {
            $article = $this->articleService->update($validated, $id);

            return $this->sendResponse(new ArticleResource($article), 'Article updated successfully');
        } catch (Exception $th) {
            return $this->sendError('Error updating article', $th->getMessage());
        }
    }

    /**
     * @OA\Delete(
     * path="/api/v2/delete/article/{id}",
     * summary="Delete an article", 
     * description="Delete an article", 
     * operationId="deleteArticle",
     * tags={"Articles"},
     * @OA\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,
     *    description="ID of the article",
     *    @OA\Schema(
     *       type="integer"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true), 
     *       @OA\Property(property="message", type="string", example="Article deleted successfully"),
     *       @OA\Property(property="data", ref="#/components/schemas/Article")   
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="Article not found")
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Internal Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="An error occurred")
     *    ),
     * ),
     * )
     */

    public function destroy($id)
    {
        try {
            $article = $this->articleService->delete($id);
            return $this->sendResponse(new ArticleResource($article), 'Article deleted successfully');
        } catch (Exception $th) {
            return $this->sendError('Error deleting article', $th->getMessage());
        }
    }
}
