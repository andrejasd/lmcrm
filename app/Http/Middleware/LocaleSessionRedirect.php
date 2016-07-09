<?php namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Closure;

class LocaleSessionRedirect {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        //$params = explode('/', $request->path());
        $param = $request->segment(1);
        $locale = \Session('locale', false);


        if ($param && $locale && !app('laravellocalization')->checkLocaleInSupportedLocales($param)) {
            $redirection = app('laravellocalization')->getLocalizedURL($locale);
            return new RedirectResponse($redirection, 302, [ 'Vary' => 'Accept-Language' ]);
        }


        if ( $param && $locale = app('laravellocalization')->checkLocaleInSupportedLocales($param) )
        {
            \Session([ 'locale' => $param ]);
            return $next($request);
        }

        if ( $locale && app('laravellocalization')->checkLocaleInSupportedLocales($locale) && !( app('laravellocalization')->getDefaultLocale() === $locale && app('laravellocalization')->hideDefaultLocaleInURL() ) )
        {
            app('session')->reflash();
            $redirection = app('laravellocalization')->getLocalizedURL($locale);

            return new RedirectResponse($redirection, 302, [ 'Vary' => 'Accept-Language' ]);
        }

        return $next($request);
    }
}
