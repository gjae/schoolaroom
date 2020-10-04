<?php

namespace App\Contracts;

interface Closeable 
{
    /**
     * Mark object as closed
     *
     * @return mixed
     */
    public function markAsClosed();
}