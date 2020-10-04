<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    use HasFactory;
    protected $table = 'student_groups';
    protected $fillable = [
        'group',
        'max_quotas',
        'period_id',
        'pensum_id',
        'teacher',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relatioons\BelongsTo
     */
    public function period()
    {
        return $this->belongsTo(\App\Models\Period::class, 'period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relatioons\BelongsTo
     */
    public function pensum()
    {
        return $this->belongsTo(\App\Models\Pensum::class, 'pensum_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horary()
    {
        return $this->hasMany(
            \App\Models\GroupHoraryMatter::class,
            'group_id'
        );
    }
}
