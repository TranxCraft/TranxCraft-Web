<?php

/**
 * This controller shows an area that's only visible for logged in users (because of Auth::checkAuthentication(); on line 16)
 */
class DashboardController extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();

        // this entire controller should only be visible/usable by logged in users, so we put authentication-check here
		// In other things we will have permissions to check too :)
        Auth::checkAuthentication();
    }

    /**
     * This method controls what happens when you move to /dashboard/index on the site. This will be a personal dashboard type thing.
     */
    public function index() {
        $this->View->render('dashboard/index');
    }
}
