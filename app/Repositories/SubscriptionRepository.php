<?php
namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $subscription = Subscription::query()->OrderByDesc('created_at')->paginate($perPage);
        return $subscription;
    }

    public function create(array $data)
    {
        return $this->subscription->create($data);
    }

    public function findById($id)
    {
        return $this->subscription->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $subscription = $this->subscription->findOrFail($id);
        $subscription->update($data);
        return $subscription;
    }

    public function delete($id)
    {
        $subscription = $this->subscription->findOrFail($id);
        $subscription->delete();
        return $subscription;
    }
}