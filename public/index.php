<?php
/**
* Where the magic happens...
*/

// auto-loading the classes (currently only from application/libs) via Composer's PSR-4 auto-loader
// later it might be useful to use a namespace here, but for now let's keep it as simple as possible
require_once '../vendor/autoload.php';

// Start the site
new Application();
