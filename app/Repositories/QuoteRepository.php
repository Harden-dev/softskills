<?php
namespace App\Repositories;

use App\Models\Quote;

class QuoteRepository
{
    protected $quote;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $quotes = Quote::query()->OrderByDesc('created_at')->paginate($perPage);
        return $quotes;
    }

    public function create(array $data)
    {
        return $this->quote->create($data);
    }

    public function findById($id)
    {
        return $this->quote->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $quote = $this->quote->findOrFail($id);
        $quote->update($data);
        return $quote;
    }

    public function delete($id)
    {
        $quote = $this->quote->findOrFail($id);
        $quote->delete();
        return $quote;
    }

}