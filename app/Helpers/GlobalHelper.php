<?php

/** Check input error */

if(!function_exists('hasError')) {
    function hasError($errors, string $name) : ?String
    {
        return $errors->has($name) ? 'is-invalid' : '';
    }
}

/** Set sidebar active */
if(!function_exists('setSidebarActive')) {
    function setSidebarActive(array $routes) : ?String
    {
        foreach($routes as $route) {
            if(request()->routeIs($route)) {
                return 'active';
            }
        }
        return null;
    }
}


/** format date */
if(!function_exists('formatDate')) {
    function formatDate(?string $date) : ?string
    {
        if($date) {
            return date('d M Y H:i',  strtotime($date));
        }

        return null;
    }
}




