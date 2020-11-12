<?php 
/**
 * @package  DiveSitesManager
 */
namespace cfishDSMInc\Base;

use cfishDSMInc\Api\SettingsApi;
use cfishDSMInc\Base\BaseController;
use cfishDSMInc\Api\Callbacks\DiveSitesCallbacks;

/**
* 
*/
class DiveSitesController extends BaseController
{
	public $settings;

	public $callbacks;

	public function register()
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new DiveSitesCallbacks();

		add_action( 'init', array( $this, 'dive_sites_cpt' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
		add_action( 'manage_divesite_posts_columns', array( $this, 'set_custom_columns' ) );
		add_action( 'manage_divesite_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );
		add_filter( 'manage_edit-divesite_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ));

		add_shortcode( 'cfish-dive-sites', array( $this, 'cfish_dive_sites_shortcode' ) );
	}

	public function enqueue_frontend(){
		wp_enqueue_style( 'front-style', $this->plugin_url . 'assets/front-style.css' );
	}


	public function cfish_dive_sites_shortcode()
	{
		require_once( "$this->plugin_path/templates/display-divesites.php" );
	}
	

	public function dive_sites_cpt ()
	{
		$labels = array(
			'name' => 'Dive Sites',
			'singular_name' => 'Dive Site'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-palmtree',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true
		);

		register_post_type ( 'divesite', $args );
	}

	public function add_meta_boxes()
	{
		add_meta_box(
			'dive_site_options',
			'Dive Site Options',
			array( $this, 'render_features_box' ),
			'divesite',
			'normal',
			'default'
		);
	}

	public function render_features_box($post)
	{
		wp_nonce_field( 'cfish_dive_site', 'cfish_dive_site_nonce' );

		$data = get_post_meta( $post->ID, '_cfish_dive_site_key', true );
		$diveType = isset($data['diveType']) ? $data['diveType'] : '';
		$diveDepth = isset($data['diveDepth']) ? $data['diveDepth'] : '';
		$diveLevel = isset($data['diveLevel']) ? $data['diveLevel'] : '';
		$diveDistance = isset($data['diveDistance']) ? $data['diveDistance'] : '';
		$diveEntry = isset($data['diveEntry']) ? $data['diveEntry'] : '';

		?>
		<p>
			<label class="meta-label" for="cfish_dive_site_type">Dive Type</label>
			<input type="text" id="cfish_dive_site_type" name="cfish_dive_site_type" class="widefat" value="<?php echo esc_attr( $diveType ); ?>">
		</p>
		<p>
			<label class="meta-label" for="cfish_dive_site_depth">Depth</label>
			<input type="text" id="cfish_dive_site_depth" name="cfish_dive_site_depth" class="widefat" value="<?php echo esc_attr( $diveDepth ); ?>">
		</p>
		<p>
			<label class="meta-label" for="cfish_dive_site_level">Level</label>
			<input type="text" id="cfish_dive_site_level" name="cfish_dive_site_level" class="widefat" value="<?php echo esc_attr( $diveLevel ); ?>">
		</p>
		<p>
			<label class="meta-label" for="cfish_dive_site_distance">Distance from shop</label>
			<input type="text" id="cfish_dive_site_distance" name="cfish_dive_site_distance" class="widefat" value="<?php echo esc_attr( $diveDistance ); ?>">
		</p>
		<p>
			<label class="meta-label" for="cfish_dive_site_entry">Entry Type</label>
			<input type="text" id="cfish_dive_site_entry" name="cfish_dive_site_entry" class="widefat" value="<?php echo esc_attr( $diveEntry ); ?>">
		</p>
		<?php
	}

	public function save_meta_box($post_id)
	{
		if (! isset($_POST['cfish_dive_site_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['cfish_dive_site_nonce'];
		if (! wp_verify_nonce( $nonce, 'cfish_dive_site' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'diveType' => sanitize_text_field( $_POST['cfish_dive_site_type'] ),
			'diveDepth' => sanitize_text_field( $_POST['cfish_dive_site_depth'] ),
			'diveLevel' => sanitize_text_field( $_POST['cfish_dive_site_level'] ),
			'diveDistance' => sanitize_text_field( $_POST['cfish_dive_site_distance'] ),
			'diveEntry' => sanitize_text_field( $_POST['cfish_dive_site_entry'] )
		);
		update_post_meta( $post_id, '_cfish_dive_site_key', $data );
	}

	public function set_custom_columns($columns)
	{
		$title = $columns['title'];
		$author = $columns['author'];
		$date = $columns['date'];
		unset( $columns['title'], $columns['date'], $columns['author'] );

		
		$columns['title'] = $title;
		$columns['diveType'] = 'Type';
		$columns['diveDepth'] = 'Depth';
		$columns['diveLevel'] = 'Level';
		$columns['author'] = $author;
		$columns['date'] = $date;

		return $columns;
	}

	public function set_custom_columns_data($column, $post_id)
	{
		$data = get_post_meta( $post_id, '_cfish_dive_site_key', true );
		$type = isset($data['diveType']) ? $data['diveType'] : '';
		$depth = isset($data['diveDepth']) ? $data['diveDepth'] : '';
		$level = isset($data['diveLevel']) ? $data['diveLevel'] : '';

		switch($column) {
			case 'diveType':
				echo $type;
				break;

			case 'diveDepth':
				echo $depth;
				break;

			case 'diveLevel':
				echo $level;
				break;
		}
	}

	public function set_custom_columns_sortable($columns)
	{
		$columns['author'] = 'Author';
		$columns['diveLevel'] = 'Level';
		$columns['diveDepth'] = 'Depth';
		$columns['diveType'] = 'Type';

		return $columns;
	}
}