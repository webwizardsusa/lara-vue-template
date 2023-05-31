<?php

namespace App\Repositories;

use App\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(array $attributes = null)
    {
        $data = $this->model->get();
        return $data;
    }

    public function store(array $attributes, $id = null): Model
    {
        if ($id) {
            $this->model = $this->find($id);
        }

        $this->model->fill($attributes);
        $this->model->save();

        return $this->model;
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function returnSuccess($data, $message = '', $status_code = 200)
    {
        return [
            'data' => $data,
            'message' => $message,
            'status_code' => $status_code,
            'success' => true,
        ];
    }

    public function returnError($message = '', $status_code = 400)
    {
        return [
            'message' => $message,
            'status_code' => $status_code,
            'success' => false,
        ];
    }
}
