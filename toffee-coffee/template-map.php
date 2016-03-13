<?php
/**
 * Template Name: Site Map Page
 *
 * @package toffee-coffee
 */


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_content(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<h2>Pages</h2>
<ul class="sitemap">
	<?php wp_list_pages
('sort_column=menu_order&title_li='); ?>
</ul>

<h2>Categories</h2>
<ul class="sitemap">
	<?php wp_list_categories('title_li='); ?>
</ul>

<h2>Posts</h2>
<ul class="sitemap">
	<?php wp_get_archives
('type=postbypost'); ?>
</ul>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
