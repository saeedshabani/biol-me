<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       Biol.me
 * @since      1.0.0
 *
 * @package    Biolme
 * @subpackage Biolme/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

$tabs = [
	'general' => [
		'title' => 'General',
		'icon' => '<span class="dashicons dashicons-admin-site"></span>'
	],
];

$active_tab = (isset($_GET['tab'])) ? esc_attr($_GET['tab']) : 'general';

?>

<div class="wrap wpp-settings-wrap">
	<div id="icon-themes" class="icon32"></div>  
	<h2>Biol Settings</h2>  
	<?php settings_errors(); ?>  
	<!--NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working once we started using add_menu_page and stopped using add_options_page so needed this-->
	<div id="tabs">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($tabs as $key => $tab ) {
				$active = ($key == $active_tab) ? 'nav-tab-active' : '';
				echo '<a href="?page=biol&tab='.$key.'" title="'.$tab['title'].'" class="nav-tab '.$active.'">';
					echo $tab['icon'].' '.$tab['title'];
				echo '</a>';
			}
			?>
		</h2>
		<?php 
		if($active_tab == 'general') { ?>
			<div id="tab-general">
				<form method="POST" action="options.php"> 
					<?php 
						settings_fields( 'biolme_general_settings' );
						do_settings_sections( 'biolme_general_settings' ); 
					?> 
					<?php submit_button(); ?>  
				</form>            
			</div>
		<?php } ?>
	</div>
	
</div>