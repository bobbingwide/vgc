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
 * This is a modified version of the archive-product.php file.
 * It is no longer similar to the woocommerce template called taxonomy-product-cat
 * and can't be replaces by it due to the changes that were implemented in the if $yn test.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.7.0
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
          // Get the child terms of the current category page
          $term_id = get_queried_object()->term_id;
          $post_id = 'product_cat_'.$term_id;
          the_field('content_above_category_title', $post_id);
          $yn = get_field('hide_description', $post_id);
          
          
          ?>
          </div>
          

      
      <div class="search_results pl-5 pr-5" id="search__results">
        <div class="spinnner_loading" style="display: none"><img src="/wp-content/themes/vgc/images/spinner.gif" alt="loading"></div>          
        

        <?php
        if($yn == true)
        {

            // Function get_term_parent in functions.php file
            $currentTerm = get_queried_object();                      
            if(!empty($currentTerm->term_taxonomy_id)) {
              //$parentTerm = get_term_top_parent($currentTerm->term_taxonomy_id); ?>
              
              <?php
              $a = term_description($currentTerm->term_taxonomy_id, 'product_cat'); 
              if($a!="")
              {?>
              <div class="text-center font-weight-medium pb-5">
                <p><?php echo($a); ?></p>
              </div>
              <?php
              }
            }
                
        }
        else        
        {
            // Function get_term_parent in functions.php file
            $currentTerm = get_queried_object();                      
            if(!empty($currentTerm->term_taxonomy_id)) {
              //$parentTerm = get_term_top_parent($currentTerm->term_taxonomy_id); ?>
              <h1 class="w-100 clearfix text-center font-weight-bold font-colour-primary"><?php woocommerce_page_title(); ?></h1>
              <?php
              $a = term_description($currentTerm->term_taxonomy_id, 'product_cat'); 
              if($a!="")
              {?>
              <div class="text-center font-weight-medium pb-5">
                <p><?php echo($a); ?></p>
              </div>
              <?php
              }
            }
        }  
          
          ?>
          <?php
          if(woocommerce_product_loop()) {
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
          	do_action( 'woocommerce_after_shop_loop' );
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
          do_action( 'woocommerce_after_main_content' );

          /**
           * Hook: woocommerce_sidebar.
           * @hooked woocommerce_get_sidebar - 10
           */
          //do_action( 'woocommerce_sidebar' );
        
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
