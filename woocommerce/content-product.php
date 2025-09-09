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
 * @version 9.4.0
 */


defined( 'ABSPATH' ) || exit;
global $product;

// Ensure visibility.
if (empty($product) || ! $product->is_visible() ) {
	return;
}
/**
 * Enable replacement of product title by product range.
 * When invoked, gvg_product_range hooks into `the_title` filter to implement the replacement.
 */
do_action( 'set_product_range_title' );
?>
<li <?php wc_product_class(); ?>>
   <div class="product-thumbnail-wrap">
	    <a href="<?php the_permalink(); ?>" title="View product: <?php the_title() ?>"><?php the_post_thumbnail(); ?></a>
  </div>
  <div class="product-attributes">
    <h3 class="pt-3 pb-0 mb-0 h5"><a href="<?php the_permalink(); ?>" class="fw-bold font-colour-primary text-decoration-none" title="View product: <?php the_title() ?>"><?php the_title(); ?></a></h3>

    <?php
    /**
     * Display the product range dropdown. Implemented by gvg_product_range.
     * Note: this includes displaying of the price / SALE price
     */
    do_action( 'display_gvg_product_range_dropdown', $product );
    ?>
  </div>
</li>
