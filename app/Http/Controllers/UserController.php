<?php

namespace App\Http\Controllers;
use App\Models\User;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->classe = User::class;
    }
}
