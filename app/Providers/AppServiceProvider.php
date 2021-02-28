<?php

namespace App\Providers;

use App\Mocks\GoogleApiMock;
use App\Mocks\IOSApiMock;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(GoogleApiMock $googleApiMock, IOSApiMock $iosApiMock)
    {
        $googleApiMock->mock();
        $iosApiMock->mock();
    }


}
