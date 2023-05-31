<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $data = $this->userRepository->index();
        return $this->respondSuccess(UserResource::collection($data));
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->store($data);
        return $this->respondSuccess(new UserResource($user), 'User Created Successfully');
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = $this->userRepository->store($request->all(), $id);
        return $this->respondSuccess(new UserResource($user), 'User Updated Successfully');
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->find($id);
            return $this->respondSuccess(new UserResource($user));
        } catch (ModelNotFoundException $e) {
            return $this->respondWithError('User Record Not Found');
        }
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return $this->respondSuccess([], 'User Deleted Successfully');
    }
}
