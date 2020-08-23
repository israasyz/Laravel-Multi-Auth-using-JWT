Commands:
1. composer require tymon/jwt-auth:dev-develop --prefer-source

2. php artisan vendor:publish  
    Type 8 to choose  
    [8 ] Provider: Tymon\JWTAuth\Providers\LaravelServiceProvider  
 
3. php artisan jwt:secret

4. Open app/Http/Kernel.php

   4.1 Add  'auth.jwt' middleware to $routeMiddleware

        protected $routeMiddleware = [
            ...
            'auth.jwt'  =>  \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // JWT middleware
        ];  
        
   4.2 Add 'assign.guard' middleware to $routeMiddleware
  
        protected $routeMiddleware = [
              ...
              'auth.jwt'  =>  \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // JWT middleware
              'assign.guard' => \App\Http\Middleware\AssignGuard::class, // assign guard middleware
         ];

5. Set up Api routes in routes/api.php 

       Route::post('patientLogin', 'MyController@patientLogin');
       Route::post('doctorLogin', 'MYController@doctorLogin');
       Route::post('patientRegister', 'MyController@patientRegister');
       Route::post('doctorRegister', 'MyController@doctorRegister');

       Route::group(['prefix' => 'patient','middleware' => ['assign.guard:patient','jwt.auth']],function ()
       {
         Route::get('/demo','PatientController@demo');	// Accessed if authorized only
       });

       Route::group(['prefix' => 'doctor','middleware' => ['assign.guard:doctor','jwt.auth']],function ()
       {
         Route::get('/demo','DoctorController@demo'); // Accessed if authorized only
       });
    
6. Make patient and doctor models\
   6.1 php artisan make:model Patient\
   6.2 php artisan make:model Doctor\
   6.3 Update models to use JWT
   
        use Tymon\JWTAuth\Contracts\JWTSubject;
        class ... extends Authenticatable implements JWTSubject 
        
   6.4 Add two JWT methods to the models 
  
        /**
         * Get the identifier that will be stored in the subject claim of the JWT.
         *
         * @return mixed
         */
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims()
        {
            return [];
        }
   
7. Add guards to config/auth.php 

       'guards' => [
           ...
           'patient' => [
               'driver' => 'jwt',
               'provider' => 'patients',
           ],
           'doctor' => [
               'driver' => 'jwt',
               'provider' => 'doctors',
           ],
       ],
       ...
       'providers' => [
           ...
           'patients' => [
               'driver' => 'eloquent',
               'model' => App\Patient::class,
           ],
           'doctors' => [
               'driver' => 'eloquent',
               'model' => App\Doctor::class,
           ],
       ],
    
8. Create registration form to handle validation\
   8.1 php artisan make:request RegistrationFormRequest\
   8.2 Update app/Http/Requests/RegistrationFormRequest.php file
   
9. Create login and registration Controller "MyController"\
   9.1 php artisan make:controller MyController\
   9.2 Open app/Http/Controllers/MyController.php and update it
    
10. Create assign guard middleware\
    10.1 php artisan make:middleware AssignGuard\
    10.2 Open app/Http/Middleware/AssignGuard.php and update it

11. Create patient and doctor Controllers\
    11.1 php artisan make:controller PatientController\
    11.2 php artisan make:controller DoctorController\
    11.3 Open app/Http/Controllers/PatientController.php and update it\
    11.4 Open app/Http/Controllers/DoctorController.php and update it
    
      
 
    




