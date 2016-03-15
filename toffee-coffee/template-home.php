<?php
/**
 * Template Name: Template Home
 *
 * @package toffee-coffee
 */

?>

<?php get_header(); ?>


<?php
$counter = 1; //start counter


global $query_string; //Need this to make pagination work


$args = array(
	'paged' => get_query_var('page'),
	'posts_per_page' => 6,
	'order' => 'ASC',
	'post_type' => 'post',
//	'category_name' => 'Home'
	);

$wp_query = new WP_Query($args);

if ($wp_query->have_posts()) :
      while ($wp_query->have_posts()) : $wp_query->the_post();

if ($counter == 1) {
	$gridClass = "grid-full";
}
else if ($counter == 4) {
	$gridClass = "grid-full";
}
else {
	$gridClass = "grid-column";
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($gridClass); ?>>
<h2 class="post-title"><?php the_title(); ?></h2>
<div class="entry-content">
	<div class="entry-meta-new">
					<?php toffee_coffee_posted_on(); ?>
				</div>

	<?php the_post_thumbnail(array(250,250)); ?>

<?php the_content(); ?>
</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php
$counter++;
endwhile; endif; ?>

<?php the_posts_pagination( array(
    'mid_size' => 2,
    'prev_text' => __( 'Newer', 'textdomain' ),
    'next_text' => __( 'Older', 'textdomain' ),
) );
?>



<?php get_sidebar(); ?>
<?php get_footer(); ?>
