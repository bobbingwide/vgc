<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.6.0
 */
 
session_start();
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<!-- Start Icon Strip -->
<?php get_template_part('/template-parts/shop/usp', 'strip'); ?>

<div class="mob__filter" style="display: none">Filter <img src="/wp-content/themes/vgc/images/filter.svg" alt="filter"></div>

<section class="product-category">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 pull-left">
          <?php get_sidebar('shop'); ?>
      </div>
      
      <div class="col-lg-10">
          <div class="top__banner">
          <?php
          $yn = true;
          // Get the child terms of the current category page
          $queried_object = get_queried_object();
          if ( property_exists( $queried_object, 'term_id ')) {
              // This only works on a category archive page, not the store page.

              $term_id = $queried_object->term_id;
              $post_id = 'product_cat_' . $term_id;
              the_field('content_above_category_title', $post_id);
              $yn = get_field('hide_description', $post_id);
          }
          
          ?>
          </div>
          

      
      <div class="search_results pl-5 pr-5" id="search__results">
        <div class="spinnner_loading" style="display: none"><img src="/wp-content/themes/vgc/images/spinner.gif" alt="loading"></div>          
        
        
        <?php
        if($yn == true)
        {
            // It's not obvious why we need this paragraph
            // <p>&nbsp;</p>
            if ( !isset( $_REQUEST['sf_paged'])) {
                vgc_maybe_display_shop_banner();
            }
            ?>

            <?php
                
        }
        else        
        {
            // Function get_term_parent in functions.php file
            $currentTerm = get_queried_object();                      
            if(!empty($currentTerm->term_taxonomy_id)) {
              $parentTerm = get_term_top_parent($currentTerm->term_taxonomy_id); ?>
              <h1 class="w-100 clearfix text-center fw-bold font-colour-primary"><?php echo $parentTerm->name; ?></h1>
              <?php
              $a = term_description($parentTerm->term_id, 'product_cat'); 
              if($a!="")
              {?>
              <div class="text-center fw-medium pb-5">
                <p><?php echo($a); ?></p>
              </div>
              <?php
              }
              }
        }  
          
          ?>
          <?php
          if ( defined( 'SEARCH_FILTER_PRO_VERSION') ) {
              // Don't use woocommmerce_catalog_ordering
              remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
          }
          do_action( 'woocommerce_before_shop_loop');
          if(woocommerce_product_loop()) {
            echo '<div class="vgc_products">';
          	woocommerce_product_loop_start();
          	if(wc_get_loop_prop( 'total' )) : while (have_posts()) : the_post();
          	/**
          	* Hook: woocommerce_shop_loop.
          	* @hooked WC_Structured_Data::generate_product_data() - 10
          	*/
          	do_action('woocommerce_shop_loop'); ?>
            <?php wc_get_template_part('content', 'product');
          	endwhile; endif;
          	woocommerce_product_loop_end();
            /**
             * Hook: woocommerce_after_shop_loop.
             * @hooked woocommerce_pagination - 10
             */
            if ( defined( 'SEARCH_FILTER_PRO_VERSION') ) {
                echo do_shortcode('[searchandfilter field="Load more"]');
                // don't use woocommerce pagination
                remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
            }
            do_action( 'woocommerce_after_shop_loop' );

            echo '</div>';
          } else {
          	/**
          	 * Hook: woocommerce_no_products_found.
          	 * @hooked wc_no_products_found - 10
          	 */
          	do_action( 'woocommerce_no_products_found' );
          }
          /**
           * Hook: woocommerce_after_main_content.
           * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
           */
          add_action( 'woocommerce_after_main_content', 'vgc_woocommerce_after_main_content');
          do_action( 'woocommerce_after_main_content' );

          /**
           * Hook: woocommerce_sidebar.
           * @hooked woocommerce_get_sidebar - 10
           */
          //do_action( 'woocommerce_sidebar' );
          //woocommerce_get_sidebar();
        
        ?>

      </div>
      </div>      
    </div>
  </div>
</div>
<?php
// Loose the search terms incase the user has left the page and returns
$_SESSION['search_terms'] = []; ?>
<?php
get_footer( 'shop' );
