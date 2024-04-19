<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<div class="container">
					<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'Nathalie_Mota' ), single_cat_title( '', false ) ); ?></h1>
	
					<?php if ( category_description() ) : // Show an optional category description ?>
					<div class="archive-meta"><?php echo category_description(); ?></div>
					<?php endif; ?>
				</div>
			</header><!-- .archive-header -->

			<section class="p-7">
				<div class="container">
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php Nathalie_Mota_paging_nav(); ?>

					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</section>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>