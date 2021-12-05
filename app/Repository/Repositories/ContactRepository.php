<?php

namespace App\Repository\Repositories;

use App\Repository\Interfaces\ContactRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface
{

    public function getContact($id): Model
    {
        return Contact::findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return Contact::create($attributes);
    }

    public function update($id, array $attributes): Model
    {
        $contact = Contact::findOrFail($id);
        $contact->update($attributes);
        return $contact;
    }

    public function delete($id): bool
    {
        return Contact::findOrFail($id)->delete();
    }
}
