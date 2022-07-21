<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureAppIsInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * Here, we need to intercept all requests, making sure that
         * the environment file has the correct database configuration file,
         * and that the database migrations has been made and that the site owner
         * has registered.
         */
        if(!$request->is('setup/*')) {
            /**
             * Check if .env file has been configured for database connection
             */
            if(!\env('IS_CONFIGURED')) {
                return response()->view('pages.installation.welcome', [
                    'title' => 'Setup Configuration | ' . \config('app.name', 'E-commerce'),
                    'site_title' => \config('app.name', 'E-commerce'),
                ]);
            }

            /**
             * Check if migrations have been made.
             */
            if(!$this->isDatabaseReady()) {
                return response()->view('pages.installation.install', [
                    'title' => 'Setup Installation | ' . \config('app.name', 'E-commerce'),
                    'site_title' => \config('app.name', 'E-commerce'),
                ]);
            }
        }

        /**
         * Check if the site owner has registered account
         */
        // if(!$this->isConfigured()) {
        //     //Check if it's installed
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'website not configured',
        //     ]);
        // }

        return $next($request);
    }

    protected function isInstalled(Request $request, Closure $next) {
        dd($request);
    }

    protected function isDatabaseReady() {
        try {
            DB::connection()->getPdo();
            DB::connection()->getDatabaseName();

            $tables = [
                "activity_log", "api_sessions",
                "banking_info", "discount_codes",
                "discount_code_uses", "email_addresses",
                "notifications", "product_category_brand",
                "product_reviews", "product_photos",
                "sponsored_products", "shopping_cart",
                "orders", "shopping_cart_items",
                "product_info", "products",
                "shops", "phone_numbers",
                "referrals", "sessions",
                "remember_me", "site_settings",
                "transactions", "users",
                "user_data", "user_settings",
                "user_lists", "verification_keys",
                "wallets",
            ];

            foreach($tables as $table) if(!Schema::hasTable($table)) return false;
            return true;
        } catch( \Throwable | \Exception $e ) {
            return false;
        }
    }
}
