<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * @OA\Schema(
     *  schema="Comments",
     *  type="object",
     * title="Comment",
     * description="Modèle de commentaire",
     * @OA\Property(
     *      property="id",
     *      type="integer",
     *      example="1"
     *  ),
     * @OA\Property(
     *      property="content",  
     *      type="string",
     *      example="Commentaire"
     *  ),
     * @OA\Property(
     *      property="user_id",
     *      type="integer",
     *      example="1"
     *  ),
     * @OA\Property(
     *      property="article_id",
     *      type="integer",
     *      example="1"
     *  ),
     * @OA\Property(
     *      property="parent_id",
     *      type="integer",
     *      example="1"
     *  ),
     * @OA\Property(
     *      property="created_at",
     *      type="string",
     *      format="date-time",
     *      example="2023-01-01T00:00:00Z"
     *  ),
     * @OA\Property(
     *      property="updated_at",
     *      type="string",
     *      format="date-time",
     *      example="2023-01-01T00:00:00Z"
     *  ),
     * @OA\Property(
     *      property="user",
     *      type="object",
     *      description="User",
     *      example={
            
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "QHn4o@example.com",
     *          "email_verified_at": "2023-01-01T00:00:00Z",
     *          "created_at": "2023-01-01T00:00:00Z",
     *          "updated_at": "2023-01-01T00:00:00Z"
     *      },
     *     
     *  ),
     * @OA\Property(
     *      property="article",
     *      type="object",
     *      description="Article",
     *      example={
     *          "id": 1,
     *          "title": "Article title",
     *          "content": "Article content",
     *          "user_id": 1,
     *          "created_at": "2023-01-01T00:00:00Z",
     *          "updated_at": "2023-01-01T00:00:00Z"
     *      },
     *      
     *  ),
     * @OA\Property(
     *      property="replies",
     *      type="array",
     *      description="Replies",
     *      @OA\Items(
            
     *          ref="#/components/schemas/Comments"
     *      )
     *  )
     * )
     */
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @OA\Get(
     *      path="/api/v2/article/{articleId}/comments",
     *      operationId="getComments",
     *      tags={"Comments"},
     *      summary="Get list of comments",
     *      description="Returns list of comments",
     *      @OA\Parameter(
     *          name="articleId",
     *          description="Article ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Comments")
     *          )
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Comments not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving comments"
     *    )
     *  )
     */

    public function index($articleId)
    {
        return $this->commentService->getAll($articleId);
    }

    /**
     * @OA\Post(
     *      path="/api/v2/add/comment/article/{articleId}",
     *      operationId="storeComment",
     *      tags={"Comments"},
     *      summary="Create new comment",
     *      description="Returns comment data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating comment"
     *      )
     * )
     */
    
    public function store(Request $request, $articleId)
    {
        // dd($request->all());
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable'
        ]);

        try {
            $comment = $this->commentService->create($validated, $articleId);

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'data' => $comment
            ], 201);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                "error" => "erreur survenue
                ",
                'message' => 'Une erreur est survenue',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v2/reply/comment/{commentId}/article/{articleId}",
     *      operationId="replyComment",
     *      tags={"Comments"},
     *      summary="Reply to a comment",
     *      description="Returns comment data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating comment"
     *      )
     * )
     */

    public function reply(Request $request, $parentId, $articleId)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable'
        ]);

        try {
            $comment = $this->commentService->reply($validated, $parentId, $articleId);

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'data' => $comment
            ], 201);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                "error" => "erreur survenue
                ",
                'message' => 'Une erreur est survenue' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v2/replies/article/{articleId}/comment/{commentId}",
     *      operationId="getReplies",
     *      tags={"Comments"},
     *      summary="Get list of replies",
     *      description="Returns list of replies",
     *      @OA\Parameter(
     *          name="articleId",
     *          description="Article ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="commentId",
     *          description="Comment ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Comments")
     *          )
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Replies not found"
     *      ),
     *      @OA\Response(
     *        response=500,
     *       description="Error retrieving replies"
     *    )
     *  )
     */
    public function getReplies($articleId, $commentId)
    {
        try {
            $RepliesComments = $this->commentService->getReplies($articleId, $commentId);

            return response()->json([
                'success' => true,
                'message' => 'Replies comments retrieved successfully',
                'data' => $RepliesComments
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v2/comment/{id}",
     *      operationId="getCommentById",
     *      tags={"Comments"},
     *      summary="Get comment details",
     *      description="Returns comment details",
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found"
     *      ),
     * @OA\Response(
     *         response=500,
     *        description="Error retrieving comment"
     *      )
     *  )
     */

    public function show($id)
    {
        try {
            $comment = $this->commentService->findByid($id);
            return response()->json([
                'success' => true,
                'message' => 'Comment retrieved successfully',
                'data' => $comment
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v2/update/comment/{id}",
     *      operationId="updateComment",
     *      tags={"Comments"},
     *      summary="Update existing comment",
     *      description="Returns updated comment data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comments")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error updating comment"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'article_id' => 'required|exists:articles,id',
            'parent_id' => 'nullable'
        ]);

        try {
            return $this->commentService->update($validated, $id);

            return response()->json([
                'success' => true,
                'message' => 'Comment updated successfully',
                'data' => $comment
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                "error" => "erreur survenue
                "
            ], 500);
        }
    }
    /**
     * @OA\Delete(
     *      path="/api/v2/delete/comment/{id}",
     *      operationId="deleteComment",
     *      tags={"Comments"},
     *      summary="Delete existing comment",
     *      description="Deletes a comment",
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment deleted successfully"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Comment not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error deleting comment"
     *      )
     *
     * )
     */
    public function destroy($id)
    {
        try {
            $this->commentService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully',
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue',
            ], 500);
        }
    }
}
