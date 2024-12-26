<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://http://localhost/wordpress
 * @since      1.0.0
 *
 * @package    Komodo_Blog
 * @subpackage Komodo_Blog/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Komodo_Blog
 * @subpackage Komodo_Blog/includes
 * @author     # <Ravi.kushwah@pixelnx.com>
 */
class Komodo_Blog_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {		
		global $wpdb;
		$authkey = delete_option('rys-auth-key');
		$wpemails_access = delete_option('rys_access_oto');
		
	}

}
