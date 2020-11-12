<div class="wrap">
	<h1>Dive Sites Manager</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Shortcodes</a></li>
		<!--li><a href="#tab-2">Updates</a></li-->
		<li><a href="#tab-2">Manage Settings</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-2" class="tab-pane ">

			<form method="post" action="options.php">
				<?php 
					settings_fields( 'dive-sites-manager_settings' );
					do_settings_sections( 'dive-sites-manager' );
					//submit_button();
				?>
			</form>
			
		</div>

		<!--div id="tab-2" class="tab-pane">
			<h3>Updates</h3>
		</div-->

		<div id="tab-1" class="tab-pane active">
			<h3>Shortcodes</h3>
			<p>To display the dive sites list use the following shortcode</p>
			<code>[cfish-dive-sites]</code>
		</div>
	</div>
</div>