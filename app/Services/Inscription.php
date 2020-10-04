<?php

namespace App\Services;

use App\Repositories\PeriodRepository;
use App\Repositories\StudentRepository;
use App\Models\Student;
use App\Models\StudentInscription;
use App\Models\StudentGroup;
use App\Models\GroupHoraryMatter;
use App\Models\StudentInscriptionGroup;
use App\Contracts\Service;

class Inscription implements Service
{
    /** @var PeriodRepository */
    private $periodRepository;

    /** @var StudentRepository */
    private $studentRepository;

    /** @var StudentInscription */
    private $inscription;


    public function __construct()
    {
        $this->periodRepository = app(PeriodRepository::class);
        $this->studentRepository = app(StudentRepository::class);
    }

    /**
     * Ger period
     *
     * @param string $periodId
     * @return Service
     */
    public function onPeriod(string $periodId) : Service
    {
        $this->exceptionIfRepositoryIsNull();

        $this->periodRepository->findById($periodId);
        if (is_null($this->periodRepository->getModel())) {
            throw new \Exception("Period dont exists");
        }

        if ($this->periodRepository->is_closed) {
            throw new \Exception("Period already closed");
        }

        return $this;
    }

    /**
     *
     * @param string|null $inscription
     * @return Service
     */
    public function onInscription(?string $inscription = null)  : Service
    {
        if (!is_null($inscription)) {
            $this->inscription = StudentInscription::findOrFail($inscription);
        }

        return $this;
    }

    /**
     * Create a new inscription if the student no was enrollment on period
     *
     * @param string $student
     * @param string $period
     * @return Service
     */
    public function newInscription(string $student, string $period) : Service
    {
        $this->studentRepository->findById($student);
        $this->periodRepository->findById($period);

        if (is_null($this->studentRepository->getModel())) {
            throw new \Exception("Student not found");
        }

        if (is_null($this->periodRepository->getModel())) {
            throw new \Exception("Period not found");
        }

        if ($this->periodRepository->is_closed) {
            throw new \Exception("Period is closed");
        }

        if (
            $this->studentRepository->enrollmentOn(
                $this->periodRepository->getModel()
            )
        ) {
            throw new \Exception("Student already enrollment on {$period} period");
        }

        $this->createInscription($student, $period);
        return $this;
    }

    /**
     * @param integer $student_group_id
     * @param integer $group_horary_matter_id
     * @param string|null $student_inscription_id
     * @return \App\Contracts\Service
     */
    public function makeTimetable(
        int $student_group_id,
        int $group_horary_matter_id,
        ?string $student_inscription_id = null
    ) {
      
        $matterHorary = GroupHoraryMatter::find($group_horary_matter_id);
        $group = StudentGroup::find($student_group_id);

        if (!is_null($student_inscription_id)) {
            $this->onInscription($student_inscription_id);
        }

        if (is_null($matterHorary)) {
            throw new \Exception("Horary not available");
        }

        if (is_null($group)) {
            throw new \Exception('Group not available');
        }

        SudentInscriptionGroup::create([
            'student_group_id' => $group->id,
            'student_inscription_id' => $this->inscription->id,
            'group_horary_matter_id' => $$matterHorary->id,
        ]);

        return $this;
    }

    /**
     * @return App\Contracts\Repository|null
     */
    public function periodRepository() : ?PeriodRepository
    {
        return $this->periodRepository;
    }


    private function exceptionIfRepositoryIsNull()
    {
        if (is_null($this->periodRepository)) {
            throw new \Exception("Period repository es null");
        }

        return true;
    }

    private function createInscription($student, $period)
    {
        $this->inscription = StudentInscription::create([
            'student_id' => $student,
            'period_id' => $period,
        ]);

        return $this->inscription;
    }
}