<?php

namespace App\Traits;


trait OnPensum
{


    /**
     * Return belongs pensum
     *
     * @return \App\Models\Pensum
     */
    public function pensum()
    {
        return $this->morphOne(\App\Models\PensumHasSubject::class, 'assignable')->first()->pensum();
    }

    /**
     * Return pensum matter prelations
     *
     * @return \App\Contracts\Assignable
     */
    public function prelation()
    {
        return $this->pensum->prelation;
    }

    /**
     * @return \ArrayAccess
     */
    public function prelateds()
    {
        return $this
            ->morphMany(\App\Models\PensumHasSubject::class, 'assignable_prelation')
            ->get()
            ->map(fn($prelation)=> $prelation->subject);
    }
}