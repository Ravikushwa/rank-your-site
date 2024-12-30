<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *`
 * @link              https://rankyoursites.net/wp/wp-admin/
 * @since             1.0.3
 * @package           RankYourSites
 *
 * @wordpress-plugin
 * Plugin Name:       Rank Your Site
 * Plugin URI:        https://rankyoursites.net/wp/wp-admin/
 * Description:       Google Ads Planner Seed Keywords 
 * Version:           1.0.3
 * Author:            #`
 * Author URI:        https://rankyoursites.net/wp/wp-admin/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rank-your-site
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

 
define( 'KOMODO_BLOGS_PATH', WP_PLUGIN_DIR . '/rank-your-site' );
define( 'KOMODO_BLOGS_URL', WP_PLUGIN_URL . '/rank-your-site' );
define('EDIT_ICON','<span class="engine-edit-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="20" height="18" viewBox="0 0 13.06 12.813"> <path d="M12.722,2.926 C11.831,2.046 10.937,1.170 10.040,0.297 C9.602,-0.132 9.153,-0.131 8.711,0.302 L7.244,1.740 C4.944,3.994 2.643,6.249 0.351,8.512 C0.156,8.704 0.019,9.018 0.010,9.292 C-0.015,10.019 -0.009,10.757 -0.004,11.471 L-0.001,11.880 C0.003,12.495 0.309,12.798 0.935,12.804 C1.241,12.808 1.544,12.806 1.849,12.806 L2.253,12.805 C2.377,12.805 2.501,12.807 2.626,12.810 C2.751,12.812 2.878,12.814 3.007,12.814 C3.189,12.814 3.373,12.810 3.556,12.793 C3.789,12.772 4.112,12.679 4.318,12.478 C6.656,10.203 8.985,7.920 11.314,5.636 L12.716,4.262 C12.938,4.044 13.047,3.824 13.047,3.592 C13.048,3.360 12.941,3.142 12.722,2.926 ZM9.290,5.333 L8.117,6.483 C6.572,7.998 5.027,9.512 3.486,11.032 C3.374,11.141 3.278,11.169 3.122,11.175 C2.875,11.169 2.628,11.167 2.377,11.167 C2.219,11.167 2.060,11.168 1.898,11.169 L1.627,11.169 L1.627,10.956 C1.626,10.466 1.625,9.992 1.628,9.552 C1.631,9.542 1.650,9.512 1.684,9.479 C3.557,7.640 5.432,5.804 7.306,3.968 L7.607,3.674 L9.290,5.333 ZM10.991,3.636 L10.539,4.066 L8.905,2.464 L9.363,2.031 L10.991,3.636 Z" class="cls-1"/></svg></span>');

define('DELETE_ICON','<span class="engine-delete-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="18" height="20" viewBox="0 0 12 14"><path d="M11.380,3.494 C11.273,3.511 11.165,3.509 11.044,3.506 L11.044,11.488 C11.043,13.040 10.140,14.004 8.689,14.005 C7.700,14.006 6.712,14.007 5.724,14.007 C4.911,14.007 4.099,14.006 3.287,14.005 C1.875,14.003 0.965,13.030 0.966,11.526 L0.966,3.508 C0.862,3.511 0.767,3.510 0.674,3.500 C0.271,3.454 0.021,3.173 0.008,2.748 C0.002,2.560 0.064,2.382 0.183,2.249 C0.316,2.101 0.507,2.019 0.720,2.017 C1.331,2.009 1.944,2.009 2.556,2.010 L11.112,2.011 C11.222,2.009 11.281,2.009 11.339,2.015 C11.735,2.055 11.987,2.330 11.999,2.732 C12.012,3.140 11.774,3.432 11.380,3.494 ZM2.373,3.528 L2.373,11.491 C2.374,12.222 2.642,12.506 3.331,12.508 C4.873,12.512 6.417,12.512 7.959,12.509 L8.731,12.509 C9.339,12.508 9.635,12.193 9.635,11.547 L9.638,3.528 L2.373,3.528 ZM7.994,10.184 C7.992,10.908 7.661,11.000 7.519,11.006 C7.513,11.006 7.507,11.006 7.500,11.006 C7.372,11.006 7.260,10.948 7.177,10.835 C7.069,10.690 7.014,10.469 7.013,10.178 C7.012,9.044 7.011,7.911 7.011,6.778 L7.010,5.928 C7.010,5.820 7.010,5.747 7.015,5.675 C7.043,5.255 7.247,4.971 7.530,5.003 C7.813,5.036 7.985,5.296 7.989,5.697 C7.994,6.112 7.993,6.526 7.993,6.940 L7.992,7.826 L7.994,8.564 L7.994,10.184 ZM4.796,10.872 C4.715,10.961 4.617,11.007 4.510,11.007 C4.475,11.007 4.439,11.002 4.403,10.992 C4.249,10.949 3.991,10.796 3.992,10.245 C3.994,9.708 3.994,9.171 3.993,8.634 L3.993,7.373 C3.992,6.859 3.992,6.345 3.994,5.831 C3.994,5.545 4.054,5.315 4.166,5.169 C4.256,5.052 4.368,4.992 4.511,4.999 C4.745,5.011 4.995,5.236 4.995,5.829 C4.996,7.290 4.996,8.750 4.993,10.211 C4.992,10.497 4.922,10.732 4.796,10.872 ZM8.259,1.002 C8.015,1.004 7.772,1.004 7.529,1.004 C7.356,1.004 7.182,1.004 7.009,1.004 L6.490,1.003 L5.973,1.003 C5.578,1.004 4.182,1.005 3.788,1.002 C3.529,1.001 3.317,0.942 3.176,0.833 C3.058,0.742 2.997,0.621 3.002,0.484 C3.011,0.250 3.221,0.001 3.784,-0.000 C4.939,-0.003 7.095,-0.002 8.252,-0.000 C8.697,0.001 8.992,0.189 9.007,0.478 C9.014,0.612 8.952,0.738 8.832,0.832 C8.695,0.940 8.491,1.000 8.259,1.002 Z" class="cls-2"/></svg></span>');
define('PLUS_ICON','<span class="engine-plus-icon"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><g> <path class="st0" d="M467,211H301V45c0-24.9-20.1-45-45-45s-45,20.1-45,45v166H45c-24.9,0-45,20.1-45,45s20.1,45,45,45h166v166 c0,24.9,20.1,45,45,45s45-20.1,45-45V301h166c24.9,0,45-20.1,45-45S491.9,211,467,211z" class="cls-1"/> </g> </svg> </span>');
define('EYE_ICON','<span class="engine-eye-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class=""><g><linearGradient id="a"><stop offset="0" stop-color="#1aa3ff"/><stop offset="1" stop-color="#0f56f6"/></linearGradient><linearGradient xlink:href="#a" id="b" x1="5.23" x2="504.69" y1="509.055" y2="9.595" gradientTransform="matrix(1 0 0 -1 0 514.55)" gradientUnits="userSpaceOnUse"/><linearGradient xlink:href="#a" id="c" x1="5.297" x2="504.757" y1="509.122" y2="9.662" gradientTransform="matrix(1 0 0 -1 0 514.55)" gradientUnits="userSpaceOnUse"/><path fill="url(#b)" d="M256.1 86.3c52.6 0 99.2 17.8 142 47.2 22.1 15.2 42.4 32.9 60.7 52.5 19.2 20.7 36.9 42.7 52 66.6 1.6 2.5 1.6 4.3 0 6.8-13.6 21-28.8 41-45.5 59.7-25.4 28.5-54.1 53-87 72.4-28.8 17-59.8 28.5-93.1 32.5-49.3 5.8-96.2-2.8-140.2-26.2-44.5-23.5-81.2-56.3-112.5-95.2-11.1-13.8-20.8-28.7-31.3-43-1.9-2.6-1.4-4.6.1-7.2 13-21 28.2-40.2 44.6-58.6 28.8-32.2 61.4-59.5 99.8-79.8 25.2-13.4 52.6-22.2 80.9-26 9.8-1.2 19.7-1.2 29.5-1.7zM380.5 256c-.6-70.4-56.4-124.5-124.7-124.4-68.4-.3-124.1 54.8-124.4 123.2v1.4c.1 69.2 55.2 124.5 124.6 124.4 69.2-.1 124-55.2 124.5-124.6z" opacity="1" data-original="url(#b)" class=""/><path fill="url(#c)" d="M256 333.8c-42.8 0-77.8-35-77.8-77.8s35.1-77.7 77.9-77.7 77.6 35.2 77.5 78c0 42.5-35.1 77.5-77.6 77.5z" opacity="1" data-original="url(#c)"/></g></svg></span>');

define( 'KOMODO_BLOG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-komodo-blog-activator.php
 */
function activate_komodo_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-komodo-blog-activator.php';
	Komodo_Blog_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-komodo-blog-deactivator.php
 */
function deactivate_komodo_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-komodo-blog-deactivator.php';
	Komodo_Blog_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_komodo_blog' );
register_deactivation_hook( __FILE__, 'deactivate_komodo_blog' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-komodo-blog.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_komodo_blog() {

	$plugin = new Komodo_Blog();
	$plugin->run();

}
run_komodo_blog();
