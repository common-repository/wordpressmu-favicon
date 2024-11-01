<?php
/*
Plugin Name: WordPress/MU Favicon
Plugin URI: http://rohankapoor.com/projects/plugins/wordpress-mu-favicon
Description: Adds a custom favicon to all MU Blogs and Administration Panels! Originally based of the WordPress Admin Favicon Plugin by John Kolbert!
Version: 2.0-Alpha3
Author: Rohan Kapoor
Author URI: http://rohankapoor.com
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_action('admin_menu', 'silpstream_wpmufavicon_admin_add_option_page');

function silpstream_wpmufavicon_admin_add_option_page() {
	if ( function_exists('add_management_page') ) {
		 add_management_page('WPPMU Favicon', 'WordPress/MU Favicon', 8, __FILE__, 'silpstream_wpmufavicon_option_page');
	}
}

function silpstream_wpmufavicon_option_page() {

	// variables for the field and option names 
    $favicon_name = 'favicon_location';
    $wpmufavicion_uri_changed = 'mt_submit_hidden';
    $wpmufavicon_uri = 'favicon_location';

    // Read in existing option value from database
    $favicon_val = get_option( $favicon_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $wpmufavicon_uri_changed ] == 'Y' ) {
        // Read their posted value
        $favicon_val = $_POST[ $wpmufavicon_uri ];

        // Save the posted value in the database
        update_option( $wpmufavicon_uri, $favicon_val );

        // Put an options updated message on the screen

		?>

		<div class="updated"><p><strong><?php _e('Options saved.', 'wpmu_favicon' ); ?></strong></p></div>
		<?php
    }
	
	// Now display the options editing screen
	echo '<div class="wrap">';
	// header
	echo "<h2>" . __( 'WP/MU Favicon Options', 'wpmu_favicon' ) . "</h2>";
	// options form
	?>
	<p>Help and Support for this plugin is available at <a href="http://rohankapoor.com/projects/plugins/">WordPress Plugins by Rohan Kapoor!</a></p>
	<p>If you found this plugin helpful please consider a <a href="http://rohankapoor.com/donate/">donation</a>. Thanks in advance!</p>
	<p>Please Enter the Web Path to the Favicon in the box below and then click the update options button, which will then save the favicon and add it into your template.</p>
	<p><br></p>

	<form name="wpmufavicon" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="<?php echo $wpmufavicon_uri_changed; ?>" value="Y">

	<p><?php _e("Full Path to Favicon:", 'wpmu_favicon' ); ?> 
	<input type="text" name="<?php echo $wpmufavicon_uri; ?>" value="<?php echo $favicon_val; ?>" size="40">
	<class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', 'wpmufavicon' ) ?>" />
	</p>

	</form>
	</div>
	<hr />

	<?php
	
}

function wpmu_sitewide_favicon() {
	echo '<link rel="shortcut icon" href="<?php echo $favicon_val; ?>" />';
}

add_action('admin_head', 'wpmu_sitewide_favicon');
add_action('wp_head', 'wpmu_sitewide_favicon');

?>