<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use App\Patient;
use App\Doctor;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationFormRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;



class MyController extends Controller
{
    public function __construct()
    {
        $this->patient = new Patient;
        $this->doctor = new Doctor;
    }
    
    public $loginAfterSignUp = true;

    public function patientLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        config()->set( 'auth.defaults.guard', 'patient' );
        config()->set( 'auth.guards.api.driver', 'jwt' );
        \Config::set('jwt.user', 'App\Patient'); 
	\Config::set('auth.providers.users.model', \App\Patient::class);
	$credentials = $request->only('username', 'password');
	$token = null;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // user = JWTAuth::toUser($token);
        // $user = Auth::user();

      //return response()->json(compact('token'));
	 
	 //Find user and save token   
	   $user = Auth::user();
           $user->api_token = $token;
           $user->save();
          
       return response()->json([
           compact('token'),
          'data' => $user,
        ]);
    }


    public function doctorLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password'=> 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        config()->set( 'auth.defaults.guard', 'doctor' );
        config()->set( 'auth.guards.api.driver', 'jwt' );
        \Config::set('jwt.user', 'App\Doctor'); 
	\Config::set('auth.providers.users.model', \App\Doctor::class);
	$credentials = $request->only('username', 'password');
	$token = null;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // user = JWTAuth::toUser($token);
        // $user = Auth::user();
      //return response()->json(compact('token'));
	
	//Find user and save token   
	   $user = Auth::user();
           $user->api_token = $token;
           $user->save();
          
       return response()->json([
           compact('token'),
          'data' => $user,
        ]);
    }

    /**
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function patientRegister(Request $request)
    {
	$validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:patients',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = new Patient();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->patientLogin($request);
        }

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ], 200);
    }

    public function doctorRegister(Request $request)
    {
	$validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:doctors',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
	    
        $user = new Doctor();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->doctorLogin($request);
        }

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ], 200);
    }

}
