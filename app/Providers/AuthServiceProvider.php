<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    //
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
         

            //Auth::shouldUse('admin');    if you use different guard from different tables 
            //here gate will applayed to all gaurds 
            
             if(auth()->guard('admin')->check()){
                
                  foreach (config('global.permissions') as $ability => $value) {
                    Gate::define($ability, function ($auth) use ($ability){
                        return $auth->hasAbility($ability);
                    });
                    
                  }
           
             }
   
}


}
