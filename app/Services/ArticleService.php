<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAll()
    {
        return $this->articleRepository->getAll();
    }

    public function publishedArticles()
    {
        return $this->articleRepository->publishedArticles();
    }

    public function scheduledArticles()
    {
        return $this->articleRepository->scheduledArticles();
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        if (isset($data['file'])) {
            $data['file_path'] = $data['file']->store('IMAGES_ARTICLES', 'public');
            unset($data['file']);
        }
        return $this->articleRepository->create($data);
    }

    public function find($slug)
    {
        return $this->articleRepository->find($slug);
    }

    public function update(array $data, $id)
    {
        $article = $this->articleRepository->findById($id);
       

        if (!$article) {
            throw new Exception('Article not found');
        }

        if (isset($data['file'])) {
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }
            $data['file_path'] = $data['file']->store('IMAGES_ARTICLES', 'public');
            unset($data['file']);
        }


        return $this->articleRepository->update($data, $id);
    }

    public function delete($id)
    {
        $article = $this->articleRepository->findById($id);
        if (!$article) {
            throw new Exception('Article not found');
        }
        if ($article->file_path) {
            Storage::disk('public')->delete($article->file_path);
        }
        return $this->articleRepository->delete($id);
    }
}
