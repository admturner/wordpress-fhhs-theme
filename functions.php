<?php
/**
 * FHHS functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage FHHS
 * @since FHHS 1.0
 */

/**
 * Register and enqueue styles and scripts in the header
 *
 * @since Plain Sight 0.2.0
 */
function fhhs_styles_scripts_fn() {
	wp_register_script( 'fhhsscript', get_bloginfo('stylesheet_directory') . '/lib/js/jquery/fhhsscript.js', array('jquery'), '', true );
	wp_enqueue_script( 'fhhsscript' );
}
add_action( 'wp_print_styles', 'fhhs_styles_scripts_fn' );

/**
 * Register widgetized areas
 *
 * @since FHHS 1.0
 * @uses register_sidebar
 */
function plainsight_widgets_init() {		
	// Sidebar widget on the About page
	register_sidebar( array(
		'name' => __( 'About Page Widget Area', 'twentyten' ),
		'id' => 'about-page-widget-area',
		'description' => __( 'Widget area for the About page', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div><!-- #%1$s -->',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Sidebar widget on the Membership page
	register_sidebar( array(
		'name' => __( 'Membership Page Widget Area', 'twentyten' ),
		'id' => 'membership-widget-area',
		'description' => __( 'Widget area for the Membership page', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div><!-- #%1$s -->',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Sidebar widget on the Membership page
	register_sidebar( array(
		'name' => __( 'News Widget Area', 'twentyten' ),
		'id' => 'news-widget-area',
		'description' => __( 'Widget area for the News page', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div><!-- #%1$s -->',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'plainsight_widgets_init' );
add_filter('widget_text', 'do_shortcode');

/**
 * A shortcode to do conditional tests in content/widgets
 *
 * @since 0.8.0
 * @uses is_page()
 * @uses is_user_logged_in()
 * @todo Add ability to test for other things
 */
function ps_conditional_shortcode_fn( $args, $content = null ) {
	global $wpdb;
	extract(shortcode_atts(array(
		'query' => 'is_page',
		'value' => '',
		'untrue' => false
	), $args));
	
	ob_start();
		
		$value = explode(", ", $value);
		
		if ( $untrue == true ) {
			if ( ! $query( $value ) ) {
				echo $content;
			}
		} else {
			if ( $query( $value ) ) {
				echo $content;
			}
		}
		$output = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'the_content', $output );
}
add_shortcode( 'ps_if', 'ps_conditional_shortcode_fn' );

function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		/* sprintf( esc_attr__( 'View all posts by %s', 'twentyeleven' ), get_the_author() ), */
		esc_html( get_the_author() )
	);
}
?>