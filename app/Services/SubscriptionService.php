<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;

class SubscriptionService 
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getAll()
    {
        return $this->subscriptionRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->subscriptionRepository->create($data);
    }

    public function findById($id)
    {
        return $this->subscriptionRepository->findById($id);

        if (!$subscription) {
            throw new \Exception('Subscription not found');
        }
    }

    public function update(array $data, $id)
    {
        $subscription = $this->subscriptionRepository->findById($id);

        if (!$subscription) {
            throw new \Exception('Subscription not found');
        }

        return $this->subscriptionRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->subscriptionRepository->delete($id);
    }
}
