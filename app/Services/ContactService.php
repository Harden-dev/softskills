<?php
namespace App\Services;

use App\Repositories\ContactRepository;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAll()
    {
        return $this->contactRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function findById($id)
    {
        return $this->contactRepository->findById($id);
    }

    public function update(array $data, $id)
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            throw new \Exception('Contact not found');
        }

        return $this->contactRepository->update($data, $id);
    }

    public function delete($id)
    {
        $contact = $this->contactRepository->findById($id);
        if (!$contact) {
            throw new \Exception('Contact not found');
        }
        return $this->contactRepository->delete($id);
    }
}