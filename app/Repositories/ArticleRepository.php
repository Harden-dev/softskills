<?php
namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $articles = Article::query()->OrderByDesc('created_at')->paginate($perPage);
        return $articles;
    }

    public function publishedArticles()
    {
        $perPage = request()->get('per_page', 10);
        $publishedArticles = Article::published()->OrderByDesc('created_at')->paginate($perPage);
        return $publishedArticles;
    }

    public function scheduledArticles()
    {
        $perPage = request()->get('per_page', 10);
        $scheduledArticles = Article::scheduled()->OrderByDesc('created_at')->paginate($perPage);
        return $scheduledArticles;
    }

    public function create(array $data)
    {
        return $this->article->create($data);
    }

    public function find($slug) 
    {
        return $this->article->where('slug', $slug)->first();
    }

    public function findById($id)
    {
        return $this->article->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $article = $this->article->findOrFail($id);
        $article->update($data);
        return $article;
    }

    public function delete($id)
    {
        $article = $this->article->findOrFail($id);
        $article->delete();
        return $article;
    }
}