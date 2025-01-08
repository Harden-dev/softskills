<?php
namespace App\Repositories;

use App\Models\Categorie;

class CategoryRepository
{
    protected $category;

    public function __construct(Categorie $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $categories = Categorie::query()->OrderByDesc('created_at')->paginate($perPage);
        return $categories;
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function findById($id)
    {
        return $this->category->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return $this->category->where('slug', $slug)->first();
    }

    public function update(array $data, $id)
    {
        $category = $this->category->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();
        return $category;
    }

}