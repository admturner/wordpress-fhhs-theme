<?php 
/**
 * The footer navigation area
 *
 * Provides the footer navigation area (breadcrumb)
 * used in the footer.php file
 *
 * @package WordPress
 * @subpackage Plain_Sight_VA
 * @since Plain Sight VA 2.0
 */
?>
<nav id="breadcrumb" role="navigation">
	<ul>
		<?php /* Start by gathering all of the current post's relatives */
		$kinfolk = get_post_ancestors( $post );
		$kinfolk = array_reverse( $kinfolk );
		// If we're not on the home page, then put link to get there
		if ( ! is_front_page() ) {
			echo '<li class="home"><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"><span class="assistive-text">' . get_bloginfo( 'name' ) . '</span></a></li>';
		} else {
			echo '<li class="home">' . get_bloginfo( 'name' ) . '</li>';
		}
		
		// If we're on a page with parents/ancestors, then list 'em
		if ( $kinfolk ) {
			foreach ( $kinfolk as $kin ) {
				echo '<li class="page-ancestor"><a href="' . esc_url( get_permalink( $kin ) ) . '" title="' . esc_attr( get_the_title( $kin ) ) . '"><span>&raquo;</span>' . get_the_title( $kin ) . '</a></li>';
			}
		}
		// If not the front page, display the current page title
		if ( ! is_front_page() ) {
				echo '<li class="current_page"><span>&raquo;</span>' . get_the_title( $post->ID ) . '</li>';
		} ?>										
	</ul>
</nav><!-- #breadcrumb -->