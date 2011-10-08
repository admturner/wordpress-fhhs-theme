<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id="main" div and all content after
 *
 * @package WordPress
 * @subpackage FHHS
 * @since FHHS 1.0
 */
?>
	</div><!-- #main -->
	
	<footer id="colophon" role="contentinfo">

		<?php get_sidebar( 'footer' ); ?>
		
		<div id="site-generator">
			<p>&copy; 2011 <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php do_action( 'twentyeleven_credits' ); ?>
			<!-- <p><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyeleven' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyeleven' ); ?>" rel="generator"><?php printf( __( 'Powered by %s', 'twentyeleven' ), 'WordPress' ); ?></a></p> -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>