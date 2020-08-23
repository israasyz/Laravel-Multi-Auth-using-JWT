<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;

class PatientController extends Controller
{
    //
    public function demo()
    {
        //
        return ('hello world');

    }
}
