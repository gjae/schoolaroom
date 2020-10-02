<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\IsStudent;
use App\Contracts\HasUser;
use App\Traits\UseUuid;

class People extends Model implements IsStudent, HasUser
{
    use HasFactory, SoftDeletes, UseUuid;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['birthday_at', 'deleted_at'];
    protected $appends = ['full_name'];
    protected $casts = ['birthday_at' => 'datetime'];
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'document_type',
        'civil_state',
        'document_id',
        'sex',
        'birthday_at',
        'country_id',
        'state_id',
        'email'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state() : BelongsTo
    {
        return $this->belongsTo(\App\Models\State::class);
    } 


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student() : HasOne
    {
        return $this->hasOne(\App\Models\Student::class);
    }

    public function user()
    {
        return $his->morphOne(\App\Models\User::class, 'model');
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->full_name;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
    }
}
