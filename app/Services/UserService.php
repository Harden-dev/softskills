<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }

}