<?php
/**
 * The template for displaying the Front Page.
 *
 * This is the template that displays the Front Page (home
 * page).
 *
 * @package WordPress
 * @subpackage FHHS
 * @since FHHS 1.0
 */
get_header(); ?>
		<div id="primary">
			<div id="content" role="main">
				
				<?php the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<header class="entry-header">
						<h1 class="assistive-text"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					
					<div class="entry-content">	
						
						<?php
						if ( is_active_sidebar( 'front-page-widget-area' ) ) {
							dynamic_sidebar( 'front-page-widget-area' );
						}
						
						the_content();
						
						wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); 
						?>
					
					</div><!-- .entry-content -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
					
				</article><!-- #post-<?php the_ID(); ?> -->
				
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>