Commands:
1. Make admin model or update user model 
2. Add guard to config/auth.php

       'guards' => [
           ...
           'admin' => [
               'driver' => 'jwt',
               'provider' => 'admins',
           ]
       ],
       ...
       'providers' => [
           ...
           'admins' => [
               'driver' => 'eloquent',
               'model' => App\Admin::class,
           ],
       ],
    
       
3. Update admin login controller      
4. Make admin roles authorization middleware
      
       php artisan make:middleware AdminRoleAuthorization
       
5. Add new middleware to app/Http/Kernel.php
              
       protected $routeMiddleware = [
        ...
        'admin.auth.role' => \App\Http\Middleware\AdminRoleAuthorization::class,
       ];
       
6. Update AdminRoleAuthorization.php 
7. Add new routes in api.php\
(Note: demo_admin, demo_lab, demo_pharm and demo_reserve are just Hello world! functions for testing purposes only.)
                    
