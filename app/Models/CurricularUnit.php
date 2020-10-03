<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UseUuid;
use App\Traits\OnPensum;
use App\Contracts\Assignable;

class CurricularUnit extends Model implements Assignable
{
    use HasFactory, SoftDeletes, UseUuid, OnPensum;

    public $increments = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'code',
        'credit_units'
    ];

    /**
     * Total of credits units
     *
     * @return integer
     */
    public function credits() : int
    {
        return $this->credit_units;
    }

    /**
     * Get name of matter
     *
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * Get uuid relational
     *
     * @return string
     */
    public function uuid() : string
    {
        return $this->id;
    }
}
