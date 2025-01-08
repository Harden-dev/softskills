<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $contact = Contact::query()->OrderByDesc('created_at')->paginate($perPage);
        return $contact;
    }

    public function create(array $data)
    {
        return $this->contact->create($data);
    }

    public function findById($id)
    {
        return $this->contact->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $contact = $this->contact->findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    public function delete($id)
    {
        $contact = $this->contact->findOrFail($id);
        $contact->delete();
        return $contact;
    }
}