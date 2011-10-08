<?php
/**
 * Template Name: One column, no sidebar
 *
 * The template for displaying 1-column pages.
 * This is the template that displays the regular content
 * formatted as a single column (no sidebar).
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
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					
					<div class="entry-content">	
					
						<?php the_content(); ?>
						
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
					
					</div><!-- .entry-content -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
					
				</article><!-- #post-<?php the_ID(); ?> -->
				
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>