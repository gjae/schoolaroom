<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Period;

class StudentRepository extends Repository
{
    public function __construct(?Student $student = null)
    {
        parent::__construct($student ?? new Student() );
    }

    protected function newInstance() : Model
    {
        return new Student();
    }

    /**
     * Return true if student already was enrollment on $period
     *
     * @param Period $period
     * @param App\Models\Period|string|null $student
     * @return boll
     */
    public function enrollmentOn(Period $period, $student = null)
    {
        if ( !is_null($student)) {
            $this->findById($student);
        }

        if (is_null($this->getModel() || is_null($this->getModel()->id))) {
            throw new \Exception("Student model not find");
        }

        return $this->periodInscriptionRecord->contains($period);
    }

}