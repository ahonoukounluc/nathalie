<?php
/**
 * The template for displaying all single photo
 *
 * @package WordPress
 * @since Nathalie Mota 0.1
 */

get_header(); 
$forms = get_field( 'contact-forms','option' );
?>
<div id="primary" class="content-area">
<?php while ( have_posts() ) : the_post();
$terms = get_the_terms( $post->ID, 'format' );
if ( !empty( $terms ) ){
  $term = array_shift( $terms );
} 
$category = get_the_terms( $post->ID, 'categorie' );
if ( !empty( $category ) ){
  $categories = array_shift( $category );
} 
$ref = get_field( 'type-reference' );
$phototype = get_field( 'photo-type' );
$date = get_the_date('Y');

?>
  <div class="container pt-9 pb-6" role="main">
    <div class="row"> 
      <div class="col-lg-11 mx-auto">
        <div class="row align-items-lg-end">
          <div class="col-lg-6 photo-contents">
            <div class="photos-content">
              <h1 class="mb-2"><?php the_title(); ?></h1>
              <div class="mb-4">
                <input type="hidden" name="reference" value="<?php echo $ref; ?>">
                <p>Référence: <?php echo $ref; ?></p>
                <p>Catégorie: <?php echo $categories->name; ?></p>
                <p>Format: <?php echo $term->name; ?></p>
                <p>Type: <?php echo $phototype; ?></p>
                <p>Année: <?php echo $date; ?> </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 single-photos mb-2">
            <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'photo' ); ?>
            <img src="<?php echo $url ?>" />
          </div>
        </div>
        <div class="row zone-content">
          <div class="col-lg-6 py-4">
            <div class="row align-items-center">
              <div class="col-lg-6"> 
                <p>Cette photo vous intéresse ?</p>
              </div>
              <div class="col-lg-6"> 
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact</button>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
          <?php 
          $arg = array(
          'post_type' => 'photo',
          'posts_per_page' => -1,
          'post_status' => 'publish',
          'post__not_in' => array(get_the_ID()),
            );
            $wp_querys = new WP_Query($arg);
            if ($wp_querys->have_posts()) : 
          ?>
          <div class="col-lg-1 offset-lg-5 slick-photos d-none d-lg-block">
            <?php while ($wp_querys->have_posts()) : $wp_querys->the_post(); ?>
              <div>
                <?php the_post_thumbnail(); ?>
                <a href="<?php the_permalink(); ?>" class=""> </a>
              </div>
            <?php  endwhile; ?>
          </div>
          <?php endif;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
 
  <?php 
    $terms = get_the_terms(get_the_ID(), 'categorie');
    if (!empty($terms)) {
      $term_ids = array();
      foreach ($terms as $term) {
        $term_ids[] = $term->term_id;
      }
    } 
    $args = array(
      'post_type' => 'photo',
      'posts_per_page' => 2,
      'post_status' => 'publish',
      'tax_query' => array(
        array(
          'taxonomy' => 'categorie',
          'field' => 'term_id',
          'terms' => $term_ids,
        ),
      ),
      'post__not_in' => array(get_the_ID()),
    );
    $wp_query = new WP_Query($args);
    if ($wp_query->have_posts()) : 
   ?>
  <div id="archives-posts" class="py-3">
    <div class="container">
      <div class="row"> 
        <div class="col-lg-11 mx-auto">
          <div class="row">
            <div class="col-lg-12">
              <div class="row similary-photo photo-items">
                <h3 class="mb-6">Vous aimerez AUSSI</h3>
                <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                  $all_format = [];
                  $formats = wp_get_post_terms( get_the_id(), 'format' );
                  foreach($formats as $format) {
                    $values_format = get_term($format)->slug;
                    if ( !in_array( $values_format, $all_format) ) {
                      $all_format[] = get_term($format)->slug;
                    }
                  }
                  $all_categorie = [];
                  $categories = wp_get_post_terms( get_the_id(), 'categorie' );
                  foreach($categories as $categorie) {
                    $values_categorie = get_term($categorie)->slug;
                    if ( !in_array( $values_categorie, $all_categorie) ) {
                      $all_categorie[] = get_term($categorie)->slug;
                    }
                  }
                  $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'full' );
                  $terms = get_the_terms( get_the_ID(), 'categorie' );
                  if ( !empty( $terms ) ){
                    $term = array_shift( $terms );
                  }
                  ?>
                  <div class="col-lg-6 mb-4 photos-items">
                    <div class="photos-image-hover">
                      <?php the_post_thumbnail('photos'); ?>
                      <a href="<?php the_permalink(); ?>" class="">
                        <span class="icon-link"><i class="bi bi-eye"></i></span>
                      </a>
                      <span class="icon-lighbox" data-src="<?php echo $url ?>"><i class="bi bi-fullscreen"></i></span>
                      <div class="photo-footer d-flex justify-content-between">
                        <span><?php the_title(); ?></span>
                        <span><?php echo $term->name; ?></span>
                      </div>
                    </div>
                  </div>
                <?php 
                endwhile; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content contact-md">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body contact-forms">
          <img src="<?php echo get_template_directory_uri(); ?>/images/ct-header.png">
          <?php echo $forms; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif;
wp_reset_postdata(); ?>
 
</div><!-- #primary -->
<script>
  jQuery(document).ready(function($) {
    var slickphoto = jQuery('.slick-photos');
    slickphoto.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="slick-prev"><i class="bi bi-arrow-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="bi bi-arrow-right"></i></button>',
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    $('.slick-next').mouseenter(function() {
      slickphoto.slick('slickNext');
    });
    $('.slick-prev').mouseenter(function() {
      slickphoto.slick('slickPrev');
    });

    $('.slick-prev, .slick-next').mouseleave(function() {
      slickphoto.slick('goTo',  slickphoto.slick('slickCurrentSlide'));
    });
    $('.slick-prev, .slick-next').click(function() {
      var activeIndex =  slickphoto.slick('slickCurrentSlide');
      var activeSlide = slickphoto.find('.slick-slide').eq(activeIndex);
      var activeLink = activeSlide.find('a').attr('href');
      window.location.href = activeLink;
    });
  });

</script>
<?php get_footer(); ?>