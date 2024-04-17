<?php

/**
 * Template Part Name: Photos
 *
 * This is the template that Photos.
 */ 

$id = 'photos' . $block['id'];
?>
  <div id="<?php echo $id; ?>" class="py-9">
    <div class="container py-4">
      <div class="row"> 
        <div class="col-10 col-lg-11 mx-auto">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <div class="categories-filter">
                    <a>Catégories</a>
                    <input type="hidden" id="category-selected" value="">
                    <ul class="filter-category">
                    </ul>
                  </div> 
                </div>
                <div class="col-lg-6 mb-2">
                  <div class="format-filter">
                    <a>Formats</a>
                    <input type="hidden" id="format-selected" value="">
                    <ul class="filter-format">
                    </ul>
                  </div> 
                </div>
              </div>
            </div>
            <div class="col-lg-3 offset-lg-3 mb-2">
              <div class="day-filter">
                <a>Trier par</a>
                <input type="hidden" id="date-selected" value="">
                <ul class="filter-date">
                  <li data-day="DESC" class="list-day">Plus récentes</li>
                  <li data-day="ASC" class="list-day">Plus anciennes</li>
                </ul>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
      $args = array(
      'post_type' => 'photo',
      'posts_per_page' => -1,
      'post_status' => 'publish'
    );
    $wp_query = new WP_Query($args);

    if ($wp_query->have_posts()) : 
      ?>
  <div id="archives-posts">
    <div class="container">
      <div class="row"> 
        <div class="col-11 col-lg-11 mx-auto">
          <div class="row">
            <div class="col-lg-12">
              <div class="row photo-items">
                <h4 class="photolabel d-none text-center">Aucune photo trouvé</h4>
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
                  $date = get_the_date('d/m/y');
                  $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'full' );
                  $terms = get_the_terms( get_the_ID(), 'categorie' );
                  if ( !empty( $terms ) ){
                    $term = array_shift( $terms );
                  }
                  ?>
                  <div class="col-lg-6 mb-4 photos-items" data-categorie="<?php echo implode(",",$all_categorie);?>"  data-format="<?php echo implode(",",$all_format); ?>" data-date="<?php echo $date; ?>">
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
                <div id="pagination-container">
                  <button id="loadMoreBtn" class="text-center btn btn-primary">Charger plus</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif;
   wp_reset_postdata(); ?>
  
  </div>