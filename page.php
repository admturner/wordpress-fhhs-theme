<?php
/**
 * The template for displaying standard Pages.
 *
 * This is the template that displays regular WordPress Pages
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
						
						<?php 
						the_content();
						
						if ( is_page( 'resources' ) ) {	
							
							// The Books query
							global $wp_query;
							
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$books = new WP_Query( array( 
									'post_type' => 'books', 
									'posts_per_page' => 9, 
									'paged' => $paged
								) );
							
							// A new loop for the Books
							while ( $books->have_posts() ) : $books->the_post(); ?>
								<div class="book-meta">
									<?php fhhs_book_the_meta(); ?>								
								</div>
								<div class="section-content">
									<?php the_excerpt(); ?>
								</div>
							<?php endwhile;
							
							// The pagination links
							if ( $books->max_num_pages > 1) { ?>
								<nav id="nav-single">
									<p class="assistive-text">Post navigation</p>
									<?php if ( $paged > 1 ) { ?>
										<span class="previous"><a title="Go to previous page" href="<?php echo '?paged=' . ($paged -1); //prev link ?>">&laquo;</a></span>
									<?php }
									
									for ( $i=1; $i<=$books->max_num_pages; $i++ ) { ?>
										<span class="middles"><a title="Go to page <?php echo $i; ?>" href="<?php echo '?paged=' . $i; ?>" <?php echo ($paged==$i)? 'class="selected"':'';?>><?php echo $i;?></a></span>
									<?php }
									
									if ( $paged < $books->max_num_pages ) { ?>
										<span class="next"><a title="Go to next page" href="<?php echo '?paged=' . ($paged + 1); //next link ?>">&raquo;</a></span>
									<?php } ?>
								</nav>
							<?php }
							
							// Reset Post data
							wp_reset_postdata();
						}
						?>
						
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
					
					</div><!-- .entry-content -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
					
				</article><!-- #post-<?php the_ID(); ?> -->
				
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>