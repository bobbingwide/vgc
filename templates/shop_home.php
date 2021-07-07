<?php
/**
 * Template name: Store Home
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VGC
 */
get_header('shop');
?>

<section class="shop-slider">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
        <?php $args = [
          'post_type' => 'shop_slider',
          'post_per_page' => -1,
          'showposts' => -1
        ];
        $query = new WP_Query($args);
        ?>
        <!-- Shop page bootstrap slider -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php $i = 0; ?>
            <?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>
              <div class="carousel-item <?php echo $i == 0 ? 'active' : ""; ?>">
                <?php the_post_thumbnail('full'); ?>
              </div>
              <?php $i++; ?>
            <?php endwhile; endif; ?>
            <?php $query = null; ?>
            <?php $args = null; ?>
            <?php wp_reset_postdata(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_template_part('/template-parts/shop/usp', 'strip'); ?>
<!-- Start shop main description -->
<section class="shop-main pb-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center font-weight-medium">
        <!-- Output the shop page content -->
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php
  // Get all the woocommerece categories
  $productCats = get_terms('product_cat', [
    'hide_empty' => false
  ]);
?>
<!-- Show product categories -->
<h2 class="w-100 clearfix text-center font-weight-bold pb-5 font-colour-primary">Popular Products</h2>
<section class="product-category-nav pb-6 section-gutters">
  <div class="container-fluid">
    <div class="row product__list">
      <?php
        // Lets loop through the woocommerece product cats
        foreach($productCats as $terms) { ?>
          <?php $popular = get_field('popular_category', 'product_cat_'.$terms->term_id); ?>
          <?php if($popular) { ?>
            <div class="col-lg-2 col-md-4 col-sm-4 text-center p-3">
              <?php $thumbnail_id = get_woocommerce_term_meta( $terms->term_id, 'thumbnail_id', true ); ?>
              <?php $image = wp_get_attachment_url($thumbnail_id); ?>
              <?php empty($image) ? $image = get_template_directory_uri() . "/images/category-placeholder.jpg" : $image = $image; ?>
              <a href="/product-category/<?php echo $terms->slug ?>" title="View category <?php echo $terms->name ?>">
                <img src="<?php echo $image; ?>" alt="<?php echo $terms->name ?>">
              </a>
              <h3 class="font-weight-bold pt-2 w-100"><a href="/product-category/<?php echo $terms->slug ?>" class="text-decoration-none font-colour-primary" title="View category <?php echo $terms->name ?>"><?php echo $terms->name ?></a></h3>
            </div>
          <?php } ?>
        <?php } ?>
    </div>
  </div>
</section>
<!-- Setup args to query for products on sale -->
<?php
$args = array(
   'post_type'      => 'product',
   'posts_per_page' => 2,
   'meta_query'     => array(
     'relation' => 'OR',
     array( // Simple products type
       'key'           => '_sale_price',
       'value'         => 0,
       'compare'       => '>',
       'type'          => 'numeric'
     ),
     array( // Variable products type
       'key'           => '_min_variation_sale_price',
       'value'         => 0,
       'compare'       => '>',
       'type'          => 'numeric'
     )
   )
 );
?>
<!-- If there are any products on sale - Display them here -->
<?php
  $query= new WP_Query($args);
  if ($query->have_posts()) : ?>
  <h2 class="w-100 clearfix text-center font-weight-bold pb-5 font-colour-primary">Sale Special Offers</h2>
  <section class="section-special-offers section-gutters pb-6">
    <div class="container-fluid">
      <div class="row">
        <?php while ($query->have_posts() ) : $query->the_post(); ?>
          <div class="col-lg-6 product-view">
            <div <?php wc_product_class(); ?>>
              <?php wc_get_template_part('content-product', 'view'); ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <?php
endif;
$query = null;
$args = null;
wp_reset_postdata();
?>
<!-- If there are any products in the best sellers category - list them here -->
<?php
  $args = [
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'showposts' => 3,
		'product_cat' => 'best-sellers'
  ];
  $query = new WP_Query($args);
  if ($query->have_posts()) :
?>
<h2 class="w-100 clearfix text-center font-weight-bold pb-5 font-colour-primary">Best Sellers</h2>
<section class="section-best-sellers section-gutters pb-6">
  <div class="container-fluid">
    <div class="row">
      <?php while ($query->have_posts() ) : $query->the_post(); ?>
        <div class="col-lg-4 product-view">
          <div <?php wc_product_class(); ?>>
            <?php wc_get_template_part('content-product', 'view'); ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif;
$query = null;
$args = null;
wp_reset_postdata();
?>
<?php
  $args = [
    'post_type'       => 'brands',
    'posts_per_page'  => -1,
    'showposts'       => -1,
  ];
  $query = new WP_Query($args);
  if ($query->have_posts()) :
?>
<h2 class="w-100 clearfix text-center font-weight-bold pb-5 font-colour-primary">Brands</h2>
<section class="section-brands section-gutters pb-6">
  <div class="container-fluid">
    <div class="row">
      <?php while ($query->have_posts() ) : $query->the_post(); ?>
        <div class="col-lg-2 col-md-3 col-sm-6 brand-logo">
          <?php the_post_thumbnail('full'); ?>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif;
$query = null;
$args = null;
wp_reset_postdata();
?>
<!-- If there are any products in the discontinued category - list them here -->
<?php
  $args = [
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'showposts' => 3,
		'product_cat' => 'discontinued-ex-display-buildings'
  ];
  $query = new WP_Query($args);
  if ($query->have_posts()) :
?>
<h2 class="w-100 clearfix text-center font-weight-bold pb-5 font-colour-primary">Discontinued Ex-Display Buildings</h2>
<section class="section-discontinued-products section-gutters pb-6">
  <div class="container-fluid">
    <div class="row">
      <?php while ($query->have_posts() ) : $query->the_post(); ?>
        <div class="col-lg-4 product-view">
          <div <?php wc_product_class(); ?>>
            <?php wc_get_template_part('content-product', 'view'); ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif;
$query = null;
$args = null;
wp_reset_postdata();
?>
<?php get_footer('shop');
