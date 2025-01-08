<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getAll($articleId)
    {
        $PerPage = 10;
        $comments = Comment::with('user')->where('article_id', $articleId)->paginate($PerPage);
        return $comments;
    }

    public function create(array $data)
    {
        return $this->comment->create($data);
    }
    //envoyez un commentaire
    public function reply(array $data)
    {
        return $this->comment->create($data);
    }

    //recuperation de reponses à un commentaire donné
    public function getReplies($commentId)
    {
        $replies = $this->comment->with('user')->where('parent_id', $commentId)->get();
       return $replies;
    }

    public function findById($id)
    {
        return $this->comment->find($id);
    }

    public function update(array $data, $id)
    {
        $comment = $this->comment->find($id);

        if (!$comment) {
            throw new \Exception('Comment not found');
        }

        return $comment->update($data);
    }

    public function delete($id)
    {
        $comment = $this->comment->find($id);
        if (!$comment) {
            throw new \Exception('Comment not found');
        }
        return $comment->delete();
    }
}