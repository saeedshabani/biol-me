<?php

/**
 * Fired during plugin activation
 *
 * @link       Biol.me
 * @since      1.0.0
 *
 * @package    Biolme
 * @subpackage Biolme/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Biolme
 * @subpackage Biolme/includes
 * @author     Biol.me <info@biol.me>
 */
class Biolme_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if( !get_option('biolme_cache_schedule' ) ){
			update_option( 'biolme_cache_schedule', 3600, false );
		}

	}

}
