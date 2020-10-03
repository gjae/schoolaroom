<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UseUuid;
use App\Models\Scopes\PensumActive;

class Degree extends Model
{
    use HasFactory, SoftDeletes, UseUuid;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at', 'degree_opened_at'];
    protected $casts = ['opened_at' => 'datetime'];
    protected $with = ['is_dependent'];
    protected $fillable = [
        'id',
        'degree',
        'degree_opened_at',
        'mode',
        'degree_depends_id'
    ];

    /**
     * Return degree dependency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function is_dependent() 
    {
        return $this->belongsTo(Degree::class, 'degree_depends_id', 'id');
    }

    /**
     * Return dependents degrees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dependents()
    {
        return $this->hasOne(Degree::class, 'degree_depends_id', 'id');
    }

    /**
     * Return true if is dependent of some degree
     *
     * @return boolean
     */
    public function hasDependencies()
    {
        return !is_null($this->is_dependent);
    }

    /**
     * Retrieve pensums
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pensums()
    {
        return $this->hasMany(\App\Models\Pensum::class)
            ->whereIsCurrent(true);
    }

    /**
     * Return all pensums from some degree
     *
     * @return 
     */
    public function allPensums()
    {
        return $this->hasMany(\App\Models\Pensum::class)
            ->withoutGlobalScope(PensumActive::class);
    }
}
