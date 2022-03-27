<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;
global $product;

// Ensure visibility.
if (empty($product) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class(); ?>>
   <div class="product-thumbnail-wrap">
	    <a href="<?php the_permalink(); ?>" title="View product: <?php the_title() ?>"><?php the_post_thumbnail('large'); ?></a>
  </div>
  <div class="product-attributes">
    <h3 class="pt-3 pb-0 mb-0 h5"><a href="<?php the_permalink(); ?>" class="fw-bold font-colour-primary text-decoration-none" title="View product: <?php the_title() ?>"><?php the_title(); ?></a></h3>
    <?php
    // If custom fields plugin is active
    if(function_exists('the_field')) {
      $type = get_field('building_type');
      if(!empty($type)) { ?>
        <p class="mb-1 font-colour-primary fw-medium">Building Type: <?php echo $type; ?></p>
      <?php }
    } ?>
    
    <?php
    if ( $product->is_on_sale() )  {
    ?>
    <p class="mb-1 font-colour-primary fw-medium" style="font-size: .9rem"><span style='background:#c31313;color:#fff;padding: 3px; display:inline-block;'>SALE</span> from: £<?php echo $product->get_sale_price(); ?></p>
    <?php
    } else {                        
    ?>
    <p class="mb-1 font-colour-primary fw-medium" style="font-size: .9rem">Price from: £<?php echo get_post_meta(get_the_ID(), '_regular_price', true); ?></p>
    <?php
    }
    ?>    
    
    

  </div>
</li>
