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
 * @since FHHS 0.2.0
 */
function fhhs_styles_scripts_fn() {
	wp_register_script( 'tiptip', get_bloginfo('stylesheet_directory') . '/lib/js/jquery/jquery.tipTip.minified.js', array('jquery'), '', true );
	wp_register_script( 'fhhsscript', get_bloginfo('stylesheet_directory') . '/lib/js/jquery/fhhsscript.js', array('jquery','tiptip'), '', true );
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
	// Widget on the Front Page
	register_sidebar( array(
		'name' => __( 'Front Page Widget Area', 'twentyten' ),
		'id' => 'front-page-widget-area',
		'description' => __( 'Widget area for the Front Page', 'twentyten' ),
		'before_widget' => '<section id="splash-%1$s" class="splash one-third">',
		'after_widget' => '</section><!-- #%1$s -->',
		'before_title' => '<h4 class="splash-title">',
		'after_title' => '</h4>',
	) );
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

/**
 * A PayPal payment form
 *
 * @since 1.1.0
 */
function fhss_get_the_paypal_form($args ) {
	$defaults = array(
		'form_class' => 'member-dues-form',
		'submit_id' => 'paypal-submit',
		'small_image' => ''
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	
	$form = '';
	$form .= '<form class="' . $form_class . '" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
	$form .= '<input type="hidden" name="cmd" value="_s-xclick" />';
	$form .= '<input type="hidden" name="hosted_button_id" value="SFVCBBRFWPT3Q" />';
	if ( '' == $small_image ) {
		$form .= '<input id="' . $submit_id . '" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="Pay dues with PayPal" />';
	} else {
		$form .= '<input id="' . $submit_id . '" type="image" src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/btn_paynow_SM.gif" name="submit" alt="Pay to renew dues with PayPal" />';
	}
	$form .= '<img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1">';
	$form .= '</form>';
	
	echo $form;
}

/**
 * A shortcode to display the membership dues form
 *
 * @since 1.1.0
 */
function fhhs_the_paypay_form_shortcode( $args ) {
	global $wpdb;
	extract(shortcode_atts(array(
		'form_class' => 'member-dues-form',
		'submit_id' => 'paypal-submit',
		'submit_text' => ''
	), $args));
	
	ob_start();
		$output = fhss_get_the_paypal_form( $args );
		$output = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'the_content', $output );
}
add_shortcode( 'fhhs_dues', 'fhhs_the_paypay_form_shortcode' );

/**
 * Modify the nav menu to add description field as a <span></span>
 *
 * Replacement for the native Walker, using user meta fields where
 * 
 * @since 1.1.0
 * @see http://wordpress.stackexchange.com/q/14037/
 
class Fhhs_Description_Walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		$description = ! empty( $item->description ) ? ' <span class="assistive-text">' . esc_attr( $item->description ) . '</span>' : '';
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $description;
		$item_output .= $args->after;
		
		$item_output .= $jump_url;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
*/
?>