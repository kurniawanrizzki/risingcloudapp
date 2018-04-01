<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class RSAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('login')) {
            
            $dstRoute = $request->route()->getName();

            if (!$this->isPermissionAllowed($dstRoute)) {
                 return abort(404);
            }
           
            return $next($request);     
        }

        return redirect()->route('auth.index');
        
    }
    
    /**
     * This method is used to check whether the page is allowable to access or not;
     * @param type $dstRoute destination route;
     * @return boolean {@true} means if page is allowed; otherwise {@false}
     */
    protected function isPermissionAllowed ($dstRoute) {
        
        $isCashier = Session::get('role') != Config::get('global.ADMIN_ROLE_ID');
        
        $pageWithPermissionRouteList = [
            
            'dashboard.add',
            'dashboard.edit',
            'dashboard.delete',
            
            'dashboard.product.add',
            'dashboard.product.edit',
            'dashboard.product.delete',
            
            'dashboard.user',
            'dashboard.user.add',
            'dashboard.user.edit',
            'dashboard.user.delete',
            
            'dashboard.report'
            
        ];
        
        if ($isCashier) {
            
            foreach ($pageWithPermissionRouteList as $route) {
  
                if ($dstRoute === $route) {
                    return false;
                }
  
            }
            
        }
        
        return true;
        
    }
    
}
