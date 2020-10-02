<?php

namespace App\Contracts\Scolarum;


interface ScolarumInfo
{
    public function version(): string;

    public function isIntalled(): bool;


}