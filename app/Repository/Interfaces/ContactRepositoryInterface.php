<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ContactRepositoryInterface
{
    public function getContact($id) : Model;
    public function create(array $attributes) : Model;
    public function update($id, array $attributes) : Model;
    public function delete($id) : bool;
}
