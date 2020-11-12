<?php 
/**
 * @package  DiveSitesManager
 */
namespace cfishDSMInc\Base;

use cfishDSMInc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();
		wp_enqueue_style( 'pluginstyle', $this->plugin_url . 'assets/admin-style.css' );
		wp_enqueue_script( 'pluginscript', $this->plugin_url . 'assets/admin-script.min.js' );
	}
}