<?php 

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll($articleId)
    {
        return $this->commentRepository->getAll($articleId);
    }

    public function create(array $data, $articleId)
    {
        $articles = Article::findOrFail($articleId);
    
        $data['article_id'] = $articleId;
        $data['user_id'] = Auth::id();
        return $this->commentRepository->create($data);
    }

    public function reply(array $data,  $parentId, $articleId,)
    {
        $articles = Article::findOrFail($articleId);
        $parentComents = $this->commentRepository->findById($parentId);
        $data['parent_id'] = $parentId;
        $data['article_id'] = $articleId;
        $data['user_id'] = Auth::id();
      
        return $this->commentRepository->reply($data);
    }

    public function getReplies($articleId, $commentId)
    {
        $comments = $this->commentRepository->findById($commentId);

        if (!$comments) {
            throw new \Exception('Comment not found');
        }

        return $this->commentRepository->getReplies($commentId);
    }   

    public function findById($id)
    {
        return $this->commentRepository->findById($id);
    }

    public function update(array $data, $id)
    {
        $comments = $this->commentRepository->findById($id);

        if (!$comments) {
            throw new \Exception('Comment not found');
        }
        return $this->commentRepository->update($data, $id);
    }

    public function delete($id)
    {
        $comments = $this->commentRepository->findById($id);

        if (!$comments) {         
            throw new \Exception('Comment not found');
        }
        return $this->commentRepository->delete($id);
    }


}