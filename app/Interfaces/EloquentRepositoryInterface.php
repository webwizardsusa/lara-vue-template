<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function index(array $attributes = null);

    public function store(array $attributes, $id = null): Model;

    public function find($id): Model;

    public function delete($id);
}
