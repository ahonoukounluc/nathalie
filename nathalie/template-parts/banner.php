<?php

/**
 * Template Part Name: Banner
 *
 * This is the template that Banner.
 */ 
$bannertitle = get_field('banner-title');
$bannerimage = get_field('banner-image');
$id = 'banner' . $block['id'];
?>
  <div id="<?php echo $id; ?>" class="home-banner" style="background-image: url(<?php echo $bannerimage; ?>);">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center mx-auto">
          <h1><?php echo $bannertitle; ?></h1>
        </div>
      </div>
    </div>
  </div>