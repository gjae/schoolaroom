<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\People;
use App\Contracts\Repository as RepositoryInterface;
use App\Contracts\PeopleRepository as BaseRepository;

class PeopleRepository extends Repository implements BaseRepository
{
    public function __construct(?People $model)
    {
        parent::__construct($model ?? new People());
    }

    /**
     * Return if people is a student
     *
     * @return boolean
     */
    public function isStudent() : bool
    {
        if (!$this->hasModel())
            throw new \Exception('Model is missing');

        return !is_null($this->getModel()->people);
            
    }
}