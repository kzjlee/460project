<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package toffee-coffee
 */

if ( ! function_exists( 'toffee_coffee_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function toffee_coffee_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'on %s', 'post date', 'toffee-coffee' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'Published by %s', 'post author', 'toffee-coffee' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	// Display the author avator in the meta tag for every posts. 
	$author_id = get_the_author_meta( 'ID');
	echo '<div class="author-avatar">' . get_avatar( $author_id) . '</div>';


	echo '<span class="byline">' . $byline . '</span><span class="posted_on"> ' . $posted_on . '</span>'; // WPCS: XSS OK.
	if (! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( '&nbsp;Leave a comment here', 'toffee-coffee' ), esc_html__( '1 Comment', 'toffee-coffee' ), esc_html__( '% Comments', 'toffee-coffee' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'toffee_coffee_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function toffee_coffee_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'toffee-coffee' ) );
		if ( $categories_list && toffee_coffee_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'toffee-coffee' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'toffee-coffee' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'toffee-coffee' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'toffee-coffee' ), esc_html__( '1 Comment', 'toffee-coffee' ), esc_html__( '% Comments', 'toffee-coffee' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'toffee-coffee' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function toffee_coffee_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'toffee_coffee_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'toffee_coffee_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so toffee_coffee_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so toffee_coffee_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in toffee_coffee_categorized_blog.
 */
function toffee_coffee_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'toffee_coffee_categories' );
}
add_action( 'edit_category', 'toffee_coffee_category_transient_flusher' );
add_action( 'save_post',     'toffee_coffee_category_transient_flusher' );
