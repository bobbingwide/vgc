<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package VGC
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function vgc_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'vgc_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function vgc_woocommerce_scripts() {
	

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'vgc-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'vgc_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function vgc_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'vgc_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function vgc_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'vgc_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function vgc_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'vgc_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function vgc_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'vgc_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function vgc_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'vgc_woocommerce_related_products_args' );

/**
 * Displays up-sells in 3-columns.
 *
 * @param $columns
 * @return int
 */
function vgc_woocommerce_upsells_columns( $columns ) {
    $columns = 3;
    return $columns;
}
add_filter( 'woocommerce_upsells_columns','vgc_woocommerce_upsells_columns');


if ( ! function_exists( 'vgc_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function vgc_woocommerce_product_columns_wrapper() {

		$columns = vgc_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
//add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
//add_action( 'woocommerce_before_shop_loop', 'vgc_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'vgc_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function vgc_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
//add_action( 'woocommerce_after_shop_loop', 'vgc_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'vgc_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function vgc_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'vgc_woocommerce_wrapper_before' );

if ( ! function_exists( 'vgc_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function vgc_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'vgc_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'vgc_woocommerce_header_cart' ) ) {
			vgc_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'vgc_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function vgc_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		vgc_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'vgc_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'vgc_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function vgc_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'vgc' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'vgc' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'vgc_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function vgc_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php vgc_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}




remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 10 );



add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

unset( $tabs['description'] ); // Remove the description tab
unset( $tabs['reviews'] ); // Remove the reviews tab
unset( $tabs['additional_information'] ); // Remove the additional information tab

return $tabs;

}

add_action( 'woocommerce_right_basics', 'my_custom_action', 25 );
function my_custom_action() {
    global $post;
    // Product description output
    echo '<div class="product-post-content">' . the_content() . '</div>';
    
    
    
}



add_action( 'wp', 'bbloomer_remove_sidebar_product_pages' );
 
function bbloomer_remove_sidebar_product_pages() {
if ( is_product() ) {
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
}



remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_right_basics', 'woocommerce_template_single_price', 10 );


add_action( 'woocommerce_right_basics', 'custom_button_after_product_summary', 15 );

function custom_button_after_product_summary() {
  global $product;
  echo "<a class=\"btn btn_primary frb\" href='".$product->add_to_cart_url()."'>add to cart</a>";
}


/**
 * Hook: woocommerce_single_product_summary.
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 * @hooked WC_Structured_Data::generate_product_data() - 60
 */
//do_action( 'woocommerce_single_product_summary' );

/**
 * Prevent the count of products in the category from being displayed
 */
add_filter( 'woocommerce_subcategory_count_html', '__return_null');
/**
 * Displays a banner image and popular categories on the shop page.
 *
 * The banner image is the full sized featured image attached to the page that's identified as the shop page.
 * It should be the same shape as the banner image used for categories,
 * which is defined in the `content_above_category_title` field.
 *
 * @return void
 */
function vgc_maybe_display_shop_banner() {
    if ( is_search() ) {
        return;
    }
    $is_shop = is_shop();
    if ( $is_shop ) {
        $banner_done = vgc_maybe_display_banner_page();
        if ( !$banner_done ) {
            $id = wc_get_page_id('shop');
            echo get_the_post_thumbnail($id, 'full');
        }
        // Manual solution to display the popular categories replaced by automatic solution
        // that uses the ACF popular_category field.
        //vgc_shop_page_content( $id );
        if ( vgc_show_popular_categories() ) {
            $categories = vgc_get_popular_categories();
            vgc_display_popular_categories($categories);
        }

    } else {
        //echo "no shop banner";
    }
}

function vgc_maybe_display_banner_page( $banner_field='banner_page') {
    $banner_page = get_field( $banner_field, 'options' );
    bw_trace2( $banner_page, "$banner_field", false);
    if ( $banner_page ) {
        vgc_shop_page_content( $banner_page );
    }
    return $banner_page;
}

function vgc_show_popular_categories() {
    $show_popular_categories = get_field( 'show_popular_categories', 'options' );
    //bw_trace2( $show_popular_categories, 'show_popular_categories', false);
    return $show_popular_categories;
}

function vgc_show_brands() {
    $show_brands = get_field( 'show_brands', 'options' );
    //bw_trace2( $show_brands, 'show_brands', false);
    return $show_brands;
}

/**
 * Show USP Banner on the store page?
 */
function vgc_show_usp_banner() {
    $show_usp_banner = get_field( 'show_usp_banner', 'options' );
    return $show_usp_banner;
}

/**
 * Show slides on the home page?
 */
function vgc_show_slides() {
    $show_slides = get_field( 'show_slides', 'options' );
    return $show_slides;
}

/**
 * Show CTA links on the home page?
 */
function vgc_show_cta_links() {
    $show = get_field( 'show_cta_links', 'options' );
    return $show;
}

/**
 * Show houses slider on the home page?
 */
function vgc_show_houses() {
    $show = get_field( 'show_houses', 'options' );
    return $show;
}

/**
 * Display the content of the shop page.
 *
 * This assumes that the shop page has not been created with Elementor.
 * It's intended that the page contains a [product_categories] shortcode
 * with the ids of the 4 or 8 most important categories.
 *
 * @param $id
 * @return void
 */
function vgc_shop_page_content( $id ) {
    $content = get_the_content( null, false, $id );
    bw_trace2( $content, 'content');
    $content = do_blocks( $content ); // apply_filters( 'the_content', $content);
    bw_trace2( $content, 'filtered content', false );
    echo $content;
}

/**
 * Displays Brand categories after the main content.
 *
 * - Term ID 634 is our-brands.
 * - We need full sized images, not cropped thumbnails
 * - No real need to display the title
 *
 * @return void
 */
function vgc_woocommerce_after_main_content() {
    //vgc_maybe_display_shop_banner();
	add_filter( 'subcategory_archive_thumbnail_size', 'vgc_subcategory_archive_thumbnail_size' );
    remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
    if ( vgc_show_brands() ) {
        $content = do_shortcode('[product_categories parent=634 hide_empty=1 number=0 columns=6]');
        echo $content;
    }
    remove_filter('subcategory_archive_thumbnail_size', 'vgc_subcategory_archive_thumbnail_size' );
}

/**
 * Filters archive thumbnail to full size.
 * @param $thumbnail
 *
 * @return string
 */
function vgc_subcategory_archive_thumbnail_size( $thumbnail ) {
    return 'full';
}

/**
 * Get the popular categories
 *
 * @return void
 */
function vgc_get_popular_categories() {
	$productCats = get_terms([ 'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'meta_query' => array(
		    array(
			    'key'       => 'popular_category',
			    'value'     => true,
			    'compare'   => '='
			     )
		)]);
    //bw_trace2( count( $productCats) , "count product cats" );
    $popular_cats = [];
	foreach( $productCats as $term ) {
        // Discard any Brand categories
        if ( $term->parent !== 634) {
	        $popular_cats[]=$term->term_id;
        }
    }
    return $popular_cats;
}

/**
 * Displays the popular product categories, if there are any.
 *
 * Note: If the `ids` attribute is null then the shortcode returns all product categories.
 * We don't want this to happen.
 *
 * @param $categories
 * @return void
 */
function vgc_display_popular_categories( $categories ) {
    if ( count( $categories )) {
	    $category_ids=implode( ',', $categories );
	    $content = do_shortcode( "[product_categories ids=$category_ids hide_empty=0]" );
	    echo $content;
    }
}

/**
 * Support S&F Pro's Load more on product-category archives.
 *
 * This code was needed for v3 up to Search and Filter Pro v3.2.0-beta-6
 *
 * @return void
 */
function vgc_open_classic_shop_results_container( ) {
    // bw_trace2();
    // use Search_Filter\Integrations\Woocommerce as WooCommerce_Integration;
    echo '<div class="search-filter-query search-filter-query--id-' . absint( Search_Filter\Integrations\Woocommerce::get_active_query_id() ) . '">';
}

function vgc_close_classic_shop_results_container() {
    echo '</div>';
}