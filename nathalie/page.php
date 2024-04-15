<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */

get_header(); ?>


<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<?php /* The loop */ ?>
		<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', ' Nathalie_Mota') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
			</article><!-- #post -->

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>