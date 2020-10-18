<?php

namespace App\Repositories;

use App\Models\StudentGroup;
use Illuminate\Support\Carbon;
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
     *
     * @param string $curricularUnit
     * @param string $initTime
     * @param string $finishTime
     * @param integer $weekDay
     * @return self
     */
    public function schedule(
        string $curricularUnit,
        string $initTime,
        string $finishTime,
        int $weekDay = 1
    ) {

        $carbonInitTime = Carbon::createFromTimeString($initTime);
        $carbonFinishTime = Carbon::createFromTimeString($finishTime); 

        if (is_null($this->getModel())) {
            throw new ModelNotFoundException("Group is not available");
        } 

        if ($carbonInitTime->isAfter($carbonFinishTime)) {
            throw new \Exception("Finish time cant be greater of init time");
        }

        $schedule = $this->getModel()->horary()->save(
            new GroupHoraryMatter([
                'curricular_unit_id' => $curricularUnit,
                'finish_time' => $carbonFinishTime->format('H:m'),
                'init_time' => $carbonInitTime->format('H:m'),
                'week_day' => $weekDay
            ])
        );

        return $this;
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

    protected function newInstance(): Model
    {
        return new StudentGroup();
    }
}
