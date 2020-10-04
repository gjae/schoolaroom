<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UseUuid;

class StudentInscription extends Model
{
    use HasFactory, UseUuid, SoftDeletes;

    public $increments = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
    protected $files = [
        'student_id',
        'period_id',
        'period_avg',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function period()
    {
        return $this->belongsTo(\App\Models\Period::class, 'period_id');
    }
}
