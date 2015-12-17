<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class StoreContext implements Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
            SOS: because sometimes missing HTTP_authorization header, because JWTAuth->request is DEFERRENT FROM $app['request']
            JWTAuth::setRequest(Request::instance());
                    OR
            .htaaccess
            RewriteCond %{HTTP:Authorization} .
            RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
        */

        $app = app();

        //language, currency, customer
        $language_id = $request->header('language-id');
        $currency_id = $request->header('currency-id');
        $customer_id = null;

        //customer
        $token = \JWTAuth::getToken();
        //if (isset($token))
        //    $customer_id=\JWTAuth::GetUserFromToken($token);

        $app->context->init($language_id, $currency_id, $customer_id);

        /*
        $storeSettings=Session::get("settings", null);
        if (!isset($storeSettings)) {
            //load defaults

            $app->settings = new StoreSettings();
            $app->settings->language = $app->languageService->getById(1);
            $app->settings->currency = $app->currencyService->getById(3);
            $app->settings->customer= null;

            $app->settings->save();
        }
        else
            $app->settings=$storeSettings;

        $token = JWTAuth::getToken();
        if (isset($token)) {
            $customer=JWTAuth::toUser($token);
            $app->settings->customer =$customer;
        }
        */
        return $next($request);
    }

}
