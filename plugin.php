<?php

/*
 * Plugin Name: Evans Slide Tools
 * Description: Tweaks to the Meteor Slides to work with the Evans Theatre website
 * Author Name: Patrick Johanneson
 * Author URI: http://patrickjohanneson.com/
 */

class Evans_Slide {

	/**
	 * Let's get everything started
	 */
	function __construct() {
		add_action( 'pre_get_posts', array( $this, 'es_populate_slideshow_with_movies' ) );

		add_action( 'shutdown', array( $this, 'es_debug' ) );
	}
	function es_populate_slideshow_with_movies( $query ) {
		if( is_admin() ) {
			return;
		}
		if( 'slide' == $query->query_vars['post_type']	 ) {

		}
	}

}

new Evans_Slide();