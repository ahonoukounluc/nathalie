<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area error404 py-8">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<img  class="error-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/404.svg" alt="">
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>