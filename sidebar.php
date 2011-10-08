<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php if ( is_page( 'about' ) ) {
				// display the About page sidebar(s)	
				if ( is_active_sidebar( 'about-page-widget-area' ) ) {
					dynamic_sidebar( 'about-page-widget-area' );
				}
			} elseif ( is_page( 'membership' ) ) {
				// display the Membership page sidebar(s)	
				if ( is_active_sidebar( 'membership-widget-area' ) ) {
					dynamic_sidebar( 'membership-widget-area' );
				}
			} elseif ( is_home() || is_archive() ) {
				// Blog home: display the News page sidebar(s)	
				if ( is_active_sidebar( 'news-widget-area' ) ) {
					dynamic_sidebar( 'news-widget-area' );
				}
			} else {
				// if its a generic sidebar page, then do this instead
				if ( ! dynamic_sidebar( 'sidebar-1' ) ) : 
					// If sidebar 1 is not active, then display some standard content ?>				
					<aside id="archives" class="widget">
						<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
						<ul>
							<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
						</ul>
					</aside>
					
					<aside id="meta" class="widget">
						<h3 class="widget-title"><?php _e( 'Meta', 'twentyeleven' ); ?></h3>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<?php wp_meta(); ?>
						</ul>
					</aside>
				<?php endif; // end sidebar widget area
			} ?>
		</div><!-- #secondary .widget-area -->