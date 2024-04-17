<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */
$forms = get_field( 'contact-forms','option' );

?>

		</div><!-- #main -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-3" id="exampleModalLabel">Formulaire de contact</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body contact-forms">
						<?php echo $forms; ?>
					</div>
				</div>
			</div>
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php 
				$j = 0;
				if( have_rows('footer-links','option') ) : ?>
				<div class="site-info">
					<ul>
						<?php while( have_rows('footer-links','option') ) :
							the_row();
							$link = get_sub_field('footer-link','option'); ?>
							<li class="ml-lg-3">
								<?php 
									$link_url = $link['url'];
									$link_title = $link['title'];
									$link_target = $link['target'] ? $link['target'] : '_self'; ?>
									<a class="" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>						
							</li>
						<?php $j++;
						endwhile; ?>
							<li>Tous Droits Réservés</li>
					</ul>
					<?php endif; ?>
				</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>
