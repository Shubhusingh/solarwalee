<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        Blade::directive('can', function ($code) {
            return '<?php $hasPermission = App\Models\Role::hasPermission(' . $code . ')  ? 1 : 0;
            if($hasPermission == 1): ?>';
        });

        Blade::directive('endcan', function () {
            return "<?php endif ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}


