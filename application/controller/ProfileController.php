<?php

class ProfileController extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->View->render('profile/index', array(
            'users' => UserModel::getPublicProfilesOfAllUsers())
        );
    }

    public function showProfile($user_id) {
        if (isset($user_id)) {
            $this->View->render('profile/showProfile', array(
                'user' => UserModel::getPublicProfileOfUser($user_id))
            );
        } 
		else {
            Redirect::home();
        }
    }
}
