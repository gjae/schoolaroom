<?php

namespace App\Repositories;

use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\GroupHoraryMatter;
use App\Models\StudentInscriptionGroup;
use App\Models\Period;

class GroupRepository extends Repository
{

    private ?Period $period = null;

    public function __construct(?StudentGroup $model)
    {
        parent::__construct($model ?? new StudentGroup());
    }

    /**
     * @param string $groupCode
     * @param string $pensum_id
     * @param int $quota
     * @param string|null $period_id
     * @return self
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function newGroup(
        string $code,
        string $pensum,
        int $quota,
        ?string $period = null
    ) {
        if (!is_null($period)) {
            $periodModel = Period::findOrFail($period);
            $this->onPeriod($periodModel);
        }

        if (is_null($this->period)) {
            throw new ModelNotFoundException("Period is missing on newGroup");
        }

        $newGroup = $this->period->groups()->save(
            new StudentGroup([
                'group' => $code,
                'max_quotas' => $quota,
                'pensum_id' => $pensum 
            ])
        );

        return $this->setModel($newGroup);
    }


    /**
     * @param \App\Models\Period $period
     * @return self
     */
    public function onPeriod(Period $period)
    {
        $this->period = $period;

        return $this;
    }

    protected function newInstance() : Model
    {
        return new StudentGroup();
    }
}
