<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function create(array $recordData) : ?Model;

    public function findById(int $id);

    public function update(array $newRecordData) : Model;

    public function delete();
}