<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use App\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationFormRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;



class MyController extends Controller
{
       
    public $loginAfterSignUp = true;

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        config()->set( 'auth.defaults.guard', 'admin' );
        config()->set( 'auth.guards.api.driver', 'jwt' );
        \Config::set('jwt.user', 'App\Admin'); 
		    \Config::set('auth.providers.users.model', \App\Admin::class);
		    $credentials = $request->only('username', 'password');
	    	$token = null;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //$user = JWTAuth::toUser($token);
        $user = Auth::user();
        $user->api_token = $token;
        $user->save();
          
        return response()->json([
            compact('token'),
            'data' => $user,
        ]);
        // return response()->json([
        //     'data'      =>  $user
        // ], 200);
    }


 
    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:admins',
            'password'=> 'required'
        ]);
        $user = new Admin();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->managed_by = $request->managed_by;
        $user->gender = $request->gender;
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->adminLogin($request);
        }

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ], 200);
    }
	
    public function demo_admin(){
        return ('hello super admin!');
    }	
    public function demo_lab(){
        return ('hello lab admin!');
    }
    public function demo_pharm(){
        return ('hello pharm admin!');
    }
    public function demo_reserve(){
        return ('hello reserve admin!');
    }
   
    
    public function logout(Request $request){
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
    }

}
