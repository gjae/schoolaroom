<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInscriptionGroup extends Model
{
    use HasFactory;

    protected $table = 'student_inscription_groups';
    protected $fillable = [
        'student_group_id',
        'student_inscription_id',
        'group_horary_matter_id',
        'group_avg',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matter()
    {
        return $this->belongsTo(\App\Models\GroupHoraryMatter::class,'group_horary_matter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inscription()
    {
        return $this->belongsTo(
            \App\Models\StudentInscription::class, 
            'student_inscription_id'
        );
    }

}
