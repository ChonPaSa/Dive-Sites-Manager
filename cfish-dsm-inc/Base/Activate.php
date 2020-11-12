<?php
/**
 * @package  DiveSitesManager
 */
namespace cfishDSMInc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'cfish_dsm' ) ) {
			update_option( 'cfish_dsm', $default );
		}
	}
}