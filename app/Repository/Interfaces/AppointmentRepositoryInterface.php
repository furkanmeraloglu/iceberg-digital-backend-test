<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

interface AppointmentRepositoryInterface
{
    public function getAll($filter = null) : Collection;
    public function create(array $attributes) : Model;
    public function update($id, array $attributes) : Model;
    public function delete($id) : bool;
    public function getContactId($id) : Integer;
}
