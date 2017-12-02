<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\State;

class DatabaseConfigProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(\Schema::hasTable("pivot_active_state"))
        {
            $active = \DB::table("pivot_active_state")->first();
            if(isset($active)){
                $state = State::find($active->state_id);
                config()->set([
                    'constants.ACTIVE_STATE_NAME' => $state['name'],
                    'constants.ACTIVE_STATE_ID' => $active->state_id
                ]);
            }
        } 
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
