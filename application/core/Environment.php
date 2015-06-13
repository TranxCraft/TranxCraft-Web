<?php
/**
 * Class Environment
 *
 * Extremely simple way to get the environment, everywhere within the site.
 * We can add stuff here too :)
 */
class Environment {
	
	public static function get() {
		// if APPLICATION_ENV constant exists (set in Apache configs)
		// then return content of APPLICATION_ENV
		// else return "development"
		return (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : "development");
	}
}
