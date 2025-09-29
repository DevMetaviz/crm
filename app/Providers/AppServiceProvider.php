<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Configuration;
use Illuminate\Support\Facades\URL; 
use App\Models\Company;
use App\Models\Branch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (app()->environment('local')) {
        URL::forceScheme('https');
    }


        Schema::defaultStringLength(191);

         $name=Configuration::company_full_name();
        $short_name=Configuration::company_short_name();
        $abbreviation=Configuration::company_abbreviation();
        $factory_address=Configuration::company_factory_address();

        $company_config=array('full_name'=>$name,'short_name'=>$short_name,'abbreviation'=>$abbreviation,'factory_address'=>$factory_address);

        $companies=Company::with('branches')->get();

        \View::share('company_config', $company_config);

        \View::share('companies', $companies);
    }
}
