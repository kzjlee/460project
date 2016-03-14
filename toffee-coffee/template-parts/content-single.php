 <?php

 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>

		<!-- This is the excerpt area that shows before the entry meta-->
		<?php 
		if (has_excerpt( $post ->ID)){
			echo '<div class="excerptspot">';
			echo '<p>' . get_the_excerpt() . '</p>';
			echo '</div>';
		}
		?>

		<div class="entry-meta">
			<?php toffee_coffee_posted_on(); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'pages:', 'toffee_coffee'), 'after' => '</div>')); ?>
	</div>

	<footer class="entry-footer">
		<?php toffee_coffee_entry_footer(); ?>
	</footer>
</article>

 
