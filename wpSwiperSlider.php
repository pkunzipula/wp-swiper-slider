<?php
/*
 * Plugin Name: J Caps Swiper Slider for WordPress!
 * Description: Drop a shortcode anywhere you want to display a Swiper Slider!
 * Version: 1.0
 * Author: James Capra
 * Author URL: http://internechee.net
 */
  function make_swiper() {
    wp_enqueue_script('swiper.min', plugin_dir_url( __FILE__ ) . 'js/swiper.min.js');
    wp_enqueue_script('smooth-scroll', plugin_dir_url( __FILE__ ) . 'js/smooth-scroll.js');
    wp_enqueue_script('swiperJS', plugin_dir_url( __FILE__ ) . 'js/swiper-init.js');
    wp_enqueue_style('swiper-min', plugin_dir_url( __FILE__ ) . 'css/swiper.min.css');
    wp_enqueue_style('swiper-style', plugin_dir_url( __FILE__ ) . 'css/swiper-style.css');
    $thumbnails = array();
    $sliderCats = array();
    $slidered = new WP_QUERY( 'category_name=slidered' );
    if( $slidered->have_posts() ) : while( $slidered->have_posts() ) : $slidered->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
        array_push($thumbnails, $image_url);
        $postCats = array();
        $categories = get_the_category();
        foreach ( $categories as $cat ) {
          if ( $cat->slug != 'slidered' ) {
            array_push( $postCats, $cat->slug );
          }
        }
        $postCats = implode(" ", $postCats);
        array_push( $sliderCats, $postCats );
      endwhile;
    endif;
    $json_thumbs = json_encode($thumbnails);
    $slider_categories = json_encode($sliderCats);
    wp_localize_script('swiperJS', 'swiperObject',
      array(
        'json_thumbs' => $json_thumbs,
        'slider_categories' => $slider_categories
      )
    );
?>
<div id="js-home-slider" class="home-slider">
	<div class="swiper-container" dir="rtl">
    <div class="swiper-wrapper">
    	<?php
        rewind_posts();
        $i = 0;
        while( $slidered->have_posts()): $slidered->the_post();
          $attachment_id = get_post_thumbnail_id( $post_id );
          $img_landscape = wp_get_attachment_image_url( $attachment_id, 'full' );
          $img_portrait = wp_get_attachment_image_url( $attachment_id, 'portrait' );
          ++$i;
			  ?>
        	<div class="swiper-slide" dir="ltr">
            <div class="slide-image">
              <picture>
                <img class="landscape" src="<?php echo esc_url( $img_landscape ); ?>" alt="Slidered!">
                <img class="portrait" src="<?php echo esc_url( $img_portrait ); ?>" alt="Slidered!">
              </picture>
            </div>
            <div class="slide-content">
              <div class="slide-content-sleeve">
                <p class="story-number">
                  <span><?php echo $i ?></span>
                  <span>
    								<?php 
                      foreach(get_the_category() as $cat) {
    									   if ( $cat->name != 'Slidered' ) {
    									     echo $cat->name;   
    									   }
                      }
    								?>
							    </span>
                </p>
                <?php the_title('<h2>','</h2>');?>
                <?php the_content();?>
              </div>
            </div>
        	</div>
        <?php endwhile; ?>
    	</div>
	</div>
	<!-- Pagination Station -->
	<div class="home-slider-navigation"></div>
	<button id="js-skip-slider" class="skip-slider"><span class="btn-text">Skip carousel</span><span class="btn-icon dashicons dashicons-arrow-down-alt"></span></button>
</div>
<div id="js-after-slider" class="after-slider"></div>
<?php }
  function make_swiper_init() {
    add_shortcode('jcaps_swiper', 'make_swiper');
  }
add_action('init', 'make_swiper_init');