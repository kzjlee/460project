<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package toffee-coffee
 */

?>

			</div><!-- #content -->
		</div><!-- #content area full -->
	</div><!-- #content inner -->

		<div class="footer-area full">
		<div class="main-page">
			<!--changing page-width to full-width -->
			<footer id="colophon" class="site-footer inner" role="contentinfo">
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'toffee-coffee' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'toffee-coffee' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'toffee-coffee' ), 'toffee-coffee', '<a href="http://underscores.me/" rel="designer">Alex Tsai, Chungyu Lay, Keizac Lee</a>' ); ?>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
		</div>
	</div>


<?php wp_footer(); ?>

</body>
</html>