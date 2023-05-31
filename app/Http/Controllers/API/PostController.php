<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $data = $this->postRepository->index();
        return $this->respondSuccess(PostResource::collection($data));
    }

    public function store(PostRequest $request)
    {
        $post = $this->postRepository->store($request->all());
        return $this->respondSuccess(new PostResource($post), 'User Created Successfully');
    }

    public function update(PostRequest $request, $id)
    {
        $post = $this->postRepository->store($request->all(), $id);
        return $this->respondSuccess(new PostResource($post), 'User Updated Successfully');
    }

    public function show($id)
    {
        try {
            $post = $this->postRepository->find($id);
            return $this->respondSuccess(new PostResource($post));
        } catch (ModelNotFoundException $e) {
            return $this->respondWithError('User Record Not Found');
        }
    }

    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return $this->respondSuccess([], 'User Deleted Successfully');
    }
}
