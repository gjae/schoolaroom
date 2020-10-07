<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Period;
use App\Models\StudentInscription;
use App\Models\StudentInscriptionGroup;

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
     * Get period inscription
     *
     * @param string $period
     * @return \App\Models\StudentInscription|null
     */
    public function findInscriptionByPeriod(string $period)
    {
        return StudentInscription::whereStudentId($this->id)
        ->wherePeriodId($period)->first();
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

        $this->findStudent($student);
        $this->exceptionIfStudentIsNull();

        return $this->periodInscriptionRecord->contains($period);
    }

    /**
     * Get groups by inscription
     *
     * @return \Illuminate\Support\Collection
     */
    public function findGroupsByInscription(string $inscription)
    {
        return StudentInscriptionGroup::whereStudentInscriptionId(
            $inscription
        )->with('matter')->get();
    }

    /**
     * Check if student has horary a
     *
     * @param Period $period
     * @param string|null $student
     * @return boolean
     */
    public function isBusySchedule(
        Period $period, 
        string $timeInit,
        string $timeEnd,
        ?string $student = null
    ) 
    {
        $this->findStudent($student);
        $this->exceptionIfStudentIsNull();
        
        $inscription = $this->findInscriptionByPeriod($period->id);
        if (is_null($inscription)) return false;
        
        $groups = $this->findGroupsByInscription($inscription->id);

        if ($groups->isEmpty()) return false;
        
        // If result collection is not empty
        // Then the 
        return $groups->filter(function ($group) use ($timeInit, $timeEnd) {
            $init = $group->matter->init_time->format('H:m');
            $finish = $group->matter->finish_time->format('H:m');
            
            if (\timeBetweenAnd($timeInit, $init, $finish)) {
                return true;

            } else if(\timeBetweenAnd($timeEnd, $init, $finish)) {
                return true;
            }

            return false;
            
        })->isNotEmpty();
    }

    /**
     * Find student if $student is not null
     *
     * @param string|null $student
     * @return void
     */
    private function findStudent(?string $student = null) 
    {
        if ( !is_null($student)) {
            $this->findById($student);
        }
    }

    /**
     * If model is null then launch exception
     *
     * @return void
     */
    private function exceptionIfStudentIsNull()
    {
        if (is_null($this->getModel() || is_null($this->getModel()->id))) {
            throw new \Exception("Student model not find");
        }

    }
}