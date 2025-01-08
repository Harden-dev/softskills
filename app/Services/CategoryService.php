<?php 

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }   

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function findById($id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }
        return $this->categoryRepository->findById($id);

    }

    public function findBySlug($slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }


    public function update(array $data, $id)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new \Exception('Category not found');
        }

        return $this->categoryRepository->update($data, $id);
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }   
        return $this->categoryRepository->delete($id);  
    }
}