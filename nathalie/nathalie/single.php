<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area container py-8">
		<div class="row">
			<div class="col-lg-11 mx-auto">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php Nathalie_Mota_post_nav(); ?>
				<?php endwhile; ?>

			</div>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>