<?php

/**
 * Class Auth
 */
class Auth {
	
    public static function checkAuthentication() {
        // initialize the session (if not initialized yet)
        Session::init();

        // if user is not logged in...
        if (!Session::userIsLoggedIn()) {
            // ... then treat user as "not logged in", destroy session, redirect to login page
            Session::destroy();
            header('location: ' . Config::get('URL') . 'login');
            // to prevent fetching views via cURL (which "ignores" the header-redirect above) we leave the application
            // the hard way, via exit().
            // this is not optimal and will be fixed in future releases
            exit();
        }
    }
}
