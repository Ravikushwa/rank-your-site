<?php

/**
 * Fired during plugin activation
 *
 * @link       https://http://localhost/wordpress
 * @since      1.0.0
 *
 * @package    Komodo_Blog
 * @subpackage Komodo_Blog/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Komodo_Blog
 * @subpackage Komodo_Blog/includes
 * @author     # <Ravi.kushwah@pixelnx.com>
 */
class Komodo_Blog_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
					
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . 'redirects';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`requested_url` VARCHAR(255) NOT NULL,
			`redirect_url` VARCHAR(255) NOT NULL,
			`created_at` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY  (id),
			KEY requested_url (requested_url)
		) $charset_collate;";

		
		
		
		$check_competition_data = 'rys_check_competition_data';
		
		$ccmD = "CREATE TABLE $check_competition_data (
			`cc_id` INT(11) NOT NULL AUTO_INCREMENT,
			`cc_data` longtext NOT NULL,	
			`added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`Favorite` INT(11) NOT NULL,
			PRIMARY KEY (`cc_id`)
		) $charset_collate;";	
	
        
        
		$trends_save_keuword = 'rys_trends_save_keuword';
		
		$sTD = "CREATE TABLE $trends_save_keuword (
			`tk_id` INT(11) NOT NULL AUTO_INCREMENT,
			`tk_name` TEXT NOT NULL,
			`added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`tk_id`)
		) $charset_collate;";	

		dbDelta($sql);
		dbDelta($ccmD);
        dbDelta($sTD);

		
	}

}
