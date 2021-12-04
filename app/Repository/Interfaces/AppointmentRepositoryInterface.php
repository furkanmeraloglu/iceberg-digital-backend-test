<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AppointmentRepositoryInterface
{
    public function getAll() : Collection;
    public function getByQuery($query) : ?Collection;
    public function create(array $attributes) : Model;
    public function update($id, array $attributes) : Model;
    public function restore($id) : bool;
    public function delete($id) : bool;
}
