<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupHoraryMatter extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'curricular_unit_id',
        'finish_time',
        'init_time',
        'week_day',
    ];

    protected $casts = [
        'finish_time' => 'datetime:H;m',
        'init_time' => 'datetime:H;m',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matter()
    {
        return $this->belongsTo(
            \App\Models\CurricularUnit::class,
            'curricular_unit_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTO
     */
    public function group()
    {
        return $this->belongsTo(
            \App\Models\StudentGroup::class,
            'group_id'
        );
    }
}
