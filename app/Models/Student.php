<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UseUuid;
use App\Contracts\HasUser;
use App\Models\User;

class Student extends Model
{
    use HasFactory, UseUuid;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['last_year_active'];
    protected $fillable = [
        'id',
        'is_active',
        'last_year_active',
        'total_uc_approveds',
        'people_id',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function people() : BelongsTo
    {
        return $this->belongsTo(\App\Models\People::class, 'people_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany(\App\Models\StudentInscription::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function periodInscriptionRecord()
    {
        return $this->hasManyThrough(
            \App\Models\Period::class,
            \App\Models\StudentInscription::class,
            'student_id',
            'id',
            'id',
            'period_id'
        );
    }

}
