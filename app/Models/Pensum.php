<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;
use App\Models\Scopes\PensumActive;

class Pensum extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $with = ['degree'];
    protected $fillable = [
        'id',
        'degree_id',
        'approved_at',
        'code',
        'is_active',
        'is_current'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new PensumActive);
        static::creating(function (Pensum $pensum) {
            $pensum->id = (string) Str::uuid();
        });
    }

    public function matters()
    {
        return $this->hasMany(
            \App\Models\PensumHasSubject::class,
            'pensum_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relatioons\HasMany
     */
    public function groups()
    {
        return $this->hasMany(\App\Models\StudentGroup::class, 'pensum_id');
    }

    /**
     * Get degree own of this pensum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function degree()
    {
        return $this->belongsTo(\App\Models\Degree::class, 'degree_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany(
            \App\Models\Period::class,
            'pensum_id'
        );
    }
}
