<?php

namespace App\Models\Repositories\Interfaces;

interface iAdminSave
{
    public function saveFromArray(array $attributes = array());
}