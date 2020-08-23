<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;

class DoctorController extends Controller
{
    //
    public function demo()
    {
        //
        return ('hello world');

    }
}
