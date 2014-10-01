<?php

/*
 * Plugin Name: Slick Post Carousel
 * Description: Create a carousel of posts using the Slick jQuery carousel
 * Author Name: Patrick Johanneson
 * Author URI: http://patrickjohanneson.com/
 */

class Slick_Carousel {

	/**
	 * Some default settings
	 */
	var $max_posts = 5;
	var $default_post_type = 'post';
	// var $orderby = 'post_date';
	var $orderby = 'meta_value_num';
	// var $order = 'DESC';
	var $order = 'ASC';

	/**
	 * Constructor for the slide wossname
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );

		add_shortcode( 'slick_carousel', array( $this, 'shortcode' ) );

		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazyload' ), 10, 2 );

	}

	function load_scripts() {
		$ver = null;
		$in_footer = true;
		wp_register_script( 'slick-js', '//cdn.jsdelivr.net/jquery.slick/1.3.7/slick.min.js', array( 'jquery', ), $ver, $in_footer );
		wp_enqueue_script( 'slick-js' );

		wp_register_script( 'slick-loader', plugins_url( 'js/slick-loader.js', __FILE__ ), array( 'slick-js' ), $ver, $in_footer );
		wp_enqueue_script( 'slick-loader' );
	}

	function load_styles() {
		wp_register_style( 'slick-style', '//cdn.jsdelivr.net/jquery.slick/1.3.7/slick.css' );
		wp_enqueue_style( 'slick-style' );

		if( file_exists( get_stylesheet_directory() . '/slick-carousel.css' ) ) {
			// Override the bundled styles
			wp_register_style( 'slick-override', get_stylesheet_directory_uri() . '/slick-carousel.css', array( 'slick-style', ) );
			wp_enqueue_style( 'slick-override' );
		}
	}

	function shortcode( $atts ) {
		$defaults = array(
			'id' => '',
			'post_type' => get_option( '_sc_default_post_type', $this->default_post_type ),
			'max_posts' => get_option( '_sc_max_posts', $this->max_posts ),
			'orderby' => get_option( '_sc_orderby', $this->orderby ),
			'order' => get_option( '_sc_order', $this->order ),
		);
		$atts = shortcode_atts( $defaults, $atts );
		if( ! post_type_exists( $atts['post_type'] ) ) {
			return "No such post type!";
		}
		$args = array(
			'post_type'		=> $atts['post_type'],
			'posts_per_page'	=> $atts['max_posts'],
			'orderby'		=> $atts['orderby'],
			'order'			=> $atts['order'],
			'meta_query'	=> array(
				array(
					'key'		=> '_evans_showtime1',
					'value'	=> time(),
					'compare'	=> '>=',
				),
			),

		);
		$q = new WP_Query( $args );
		if( $q->have_posts() ) {
			$content = '<div class="' . $atts['post_type'] . ' carousel">' . PHP_EOL;
			$i = 0;
			while( $q->have_posts() ) {
				$q->the_post();
				$showtime1 = get_post_meta( get_the_ID(), '_evans_showtime1', true );
				if( has_post_thumbnail() ) {
					$content .= '<div>' .
						get_the_post_thumbnail() .
						'<h1>' . get_the_title() . '</h1>' . PHP_EOL .
						'<p>' . date( 'Y-m-d', $showtime1 ) . '</p>' . PHP_EOL .

						'</div>' . PHP_EOL;
				}
			}
			$content .= '</div> <!-- .' . $atts['post_type'] . ' carousel -->' . PHP_EOL;
			wp_reset_postdata();
			return $content;
		}

		return;
	}

	/**
	 * Set up lazy loading on post thumbnails
	 * @param array $attr
	 * @return array
	 * @todo Use an option to decide if lazy load should be used; pass this to the JS too
	 */
	function lazyload( $attr, $attachment ) {
		$attr['data-lazy'] = $attr['src'];
		$attr['src'] = plugins_url( 'images/grey.png', __FILE__ );
		return $attr;
	}


}

new Slick_Carousel();
