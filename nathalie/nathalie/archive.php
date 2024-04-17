<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Nathalie_Mota
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
					<h1 class="archive-title"><?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'Nathalie_Mota' ), get_the_date() );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'Nathalie_Mota' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'Nathalie_Mota' ) ) );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'Nathalie_Mota' ), get_the_date( _x( 'Y', 'yearly archives date format', 'Nathalie_Mota' ) ) );
						else :
							_e( 'Archives', 'Nathalie_Mota' );
						endif;
					?></h1>
				</div>
			</header>

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