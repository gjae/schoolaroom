<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensumHasSubject extends Model
{
    use HasFactory;

    protected $with = ['subject'];
    protected $fillable = [
        'order',
        'pensum_id',
        'assignable_type',
        'assignable_id',
        'assignable_prelation_type',
        'assignable_prelation_id'
    ];

    public function pensum()
    {
        return $this->belongsTo(\App\Models\Pensum::class, 'pensum_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo('assignable');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function prelation()
    {
        return $this->morphTo('assignable_prelation');
    }

}
