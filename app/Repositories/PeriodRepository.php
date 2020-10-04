<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Models\Period;

class PeriodRepository extends Repository
{
    public function __construct(?Period $period = null)
    {
        parent::__construct($period ?? new Period);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance() : Model
    {
        return new Period();
    }

    /**
     * Create a new period to degree and pensum
     *
     * @param string $degree
     * @param string $pensum
     * @param string $description
     * @param boolean $is_special
     * @param \DateTime $opened_at
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newPeriod(
        string $degree, 
        string $pensum, 
        string $description = '', 
        bool $is_special = false,
        \DateTime $opened_at
    ) {

        if (!Str::isUuid($degree)) {
            throw new \Exception('Degree id has been a uuid format id');
        }

        if (!Str::isUuid($pensum)) {
            throw new \Exception("Pensum id has been a uuid format id");
        }

        if (empty($description)) {
            throw new \Exception("Period descriptions cant be empty string");
        }

        return parent::create([
            'degree_id' => $degree,
            'pensum_id' => $pensum,
            'period_description' => trimAndUpper($description),
            'is_special' => $is_special,
            'period_oepened_at' => $opened_at
        ]);
    }

    /**
     * @return \ArrayAccess
     */
    public function getOpeneds() : \ArrayAccess
    {
        return $this->newInstance()->openeds()->get();
    }

    /**
     * @return \ArrayAccess
     */
    public function getCloseds() : \ArrayAccess
    {
        return $this->newInstance()->closeds()->get();
    }
}