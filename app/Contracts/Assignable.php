<?php

namespace App\Contracts;

interface Assignable 
{
    /**
     * Total of credits units
     *
     * @return integer
     */
    public function credits() : int;

    /**
     * Get name of matter
     *
     * @return string
     */
    public function name() : string;

    /**
     * Get uuid relational
     *
     * @return string
     */
    public function uuid() : string;
}