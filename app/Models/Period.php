<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UseUuid;

class Period extends Model
{
    use HasFactory, UseUuid, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at', 'period_opened_at', 'period_closed_at'];
    protected $appends = ['is_opened', 'is_closed'];
    protected $cats = [
        'period_opened_at' => 'datetime', 
        'period_closed_at' => 'datetime'
    ];
    protected $fillable = [
        'degree_id',
        'pensum_id',
        'period_description',
        'is_special',
        'period_opened_at',
        'period_closed_at',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function degree() 
    {
        return $this->belongsTo(
            \App\Models\Degree::class,
            'degree_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pensum()
    {
        return $this->belongsTo(
            \App\Models\Pensum::class,
            'pensum_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscriptions()
    {
        return $this->hasMany(\App\Models\StudentInscription::class, 'period_id');
    }

    /**
     * @return boolean
     */
    public function getIsOpenedAttribute() : bool
    {
        return !$this->is_closed;
    }

    /**
     * @return boolean
     */
    public function getIsClosedAttribute() : bool
    {
        return !is_null($this->period_closed_at);
    }

}
