<?php

class IndexController extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to index/index - or - as this is the default controller, also
     * when the user moves to /index.
     */
    public function index() {
        $this->View->render('index/index');
    }
}
