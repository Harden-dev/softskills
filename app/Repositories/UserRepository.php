<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        $perPage = request()->get('per_page', 10);
        $users = User::withTrashed()->OrderByDesc('created_at')->paginate($perPage);
        return $users;
    }

    public function update(array $data, $id)
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if($user->trashed())
        {
            $user->restore();
        }else{
            $user->delete();
        }
      
        return $user;
    }
}
