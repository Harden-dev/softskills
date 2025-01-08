<?php

namespace App\Services;

use App\Repositories\QuoteRepository;

class QuoteService
{
    protected $quoteRepository;

    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function getAll()
    {
        return $this->quoteRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->quoteRepository->create($data);
    }

    public function findById($id)
    {
        return $this->quoteRepository->findById($id);
    }

    public function update(array $data, $id)
    {
        $quote = $this->quoteRepository->findById($id);

        if (!$quote) {
            throw new \Exception('Quote not found');
        }

        return $this->quoteRepository->update($data, $id);
    }

    public function delete($id)
    {
        $quote = $this->quoteRepository->findById($id);
        if (!$quote) {
            throw new \Exception('Quote not found');
        }
        return $this->quoteRepository->delete($id);
    }
}