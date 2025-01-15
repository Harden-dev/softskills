<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $userService;

    //
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $user = $this->userService->getAll();
        return $this->sendResponse(new UserResource(collect($user)), 'User retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        try {
            $user = $this->userService->update($validated, $id);

            return $this->sendResponse(new UserResource($user), 'User updated successfully');
        } catch (\Exception $th) {

            return $this->sendError('Error updating user', $th->getMessage());
        }
       
    }

    public function destroy($id)
    {
        $user = $this->userService->destroy($id);
        return $this->sendResponse(new UserResource($user), 'User disable successfully', 204);
    }
}
