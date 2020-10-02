<?php

namespace App\Contracts;

use App\Models\User;

interface HasUser
{
    public function getEmail() : string;

    public function getName() : string;
}