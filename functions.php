<?php
/**
 * VGC functions and definitions
 */

// Include all the functions used in the woocommerece shop
require 'inc/custom-woo-functions.php';


if ( ! function_exists( 'vgc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vgc_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on VGC, use a find and replace
		 * to change 'vgc' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vgc', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
        remove_theme_support( 'widgets-block-editor' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'vgc' ),
			'menu-2' => esc_html__( 'Sub', 'vgc' ),
			'menu-3' => esc_html__( 'Mobile mini', 'vgc' ),
			'menu-4' => esc_html__('Shop menu', 'vgc'),
			'menu-5' => esc_html__('Shop mobile menu', 'vgc'),			
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'vgc_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_image_size( 'houses', 400, 480, true );
		add_image_size( 'woocommerce_thumbnail', 300, 300, true );

    register_sidebar(array(
      'name' => 'Footer 1',
      'id' => 'footer-1',
      'before_widget' => '<div class="footer-4">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
    register_sidebar(array(
      'name' => 'Footer 1 Shop',
      'id' => 'footer-S',
      'before_widget' => '<div class="footer-1">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );    
    register_sidebar(array(
      'name' => 'Footer 2',
			'id' => 'footer-2',
      'before_widget' => '<div class="footer-2">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    	)
    );
    register_sidebar(array(
      'name' => 'Footer 2 Shop',
      'id' => 'footer-2S',
      'before_widget' => '<div class="footer-2">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    	)
    );    
    register_sidebar(array(
    	'name' => 'Footer 3',
			'id' => 'footer-3',
    	'before_widget' => '<div class="footer-3">',
    	'after_widget' => '</div>',
    	'before_title' => '<h3>',
    	'after_title' => '</h3>',
      )
    );
    register_sidebar(array(
      'name' => 'Footer 4',
			'id' => 'footer-4',
      'before_widget' => '<div class="footer-4">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Header Right',
			'id' => 'header-1',
      'before_widget' => '<div class="header-1">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Shop Page USP Strip',
			'id' => 'shop-usp-1',
      'before_widget' => '<div class="shop-usp-1">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Footer Shop',
			'id' => 'footer-shop-1',
      'before_widget' => '<div>',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Single Product - Sidebar Top',
			'id' => 'single-product-sidebar-top',
      'before_widget' => '<div class="text-white text-center">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Postcode Search Text',
			'id' => 'postcode-search-text',
      'before_widget' => '<div class="text-white">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="w-100 text-center clearfix fw-bold">',
      'after_title' => '</h3>',
      )
    );
		register_sidebar(array(
      'name' => 'Single Bottom',
			'id' => 'widget-single-end',
      'before_widget' => '<div class="text-white">',
      'after_widget' => '</div>',
      'before_title' => '',
      'after_title' => '',
      )
    );
	}
endif;
add_action( 'after_setup_theme', 'vgc_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vgc_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'vgc_content_width', 640 );
}
add_action( 'after_setup_theme', 'vgc_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vgc_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'vgc' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'vgc' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'vgc_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vgc_scripts()
{
	if ( defined( 'SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
		$ver = time();
	} else {
		$ver = '2131231235';
	}
    wp_enqueue_style('use-typekit-net-vyh3vpj', get_template_directory_uri() . '/use-typekit-net-vyh3vpj.css', [], null, 'all');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap.min.css', [], '5.1.3', 'all');

	wp_enqueue_style( 'vgc-animate', get_template_directory_uri(). '/animate.css', array(), $ver, 'all' );
	wp_enqueue_style( 'vgc-style', get_stylesheet_uri(), array(), $ver, 'all' );
	wp_enqueue_script( 'vgc-navigation', get_template_directory_uri() . '/inc/js/navigation.js', array(), $ver, true );
    wp_enqueue_script('vgc-pushy', 'https://cdnjs.cloudflare.com/ajax/libs/pushy/1.1.2/js/pushy.js', array(), $ver, true);
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), $ver, true);
    wp_enqueue_script('vgc-skip-link-focus-fix', get_template_directory_uri() . '/inc/js/skip-link-focus-fix.js', array(), $ver, true);

    if (!function_exists('is_shop')) {
        return;
    }
    if (is_shop() || is_product() || is_woocommerce()) {
		wp_enqueue_style('flex-css', get_template_directory_uri(). '/inc/css/flexslider.css', array(), $ver, 'all' );
		wp_enqueue_script('scripts', get_template_directory_uri() . '/inc/js/scripts.js', array(), $ver, true);
		//wp_enqueue_script('wc-atc', get_template_directory_uri() . '/inc/js/wc-ajax-add-to-cart.js', array(), $ver, true);
        //wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap.js', [], '5.1.3', 'all');
    }

    if (is_woocommerce() || is_page(2278)) {
		wp_enqueue_script('flex-slider', get_template_directory_uri() . '/inc/js/jquery.flexslider.js', array(), $ver, true);
		wp_enqueue_style( 'vgc-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), $ver, 'all'  );
    }
    if (is_product()) {
		wp_enqueue_script('addon-scripts', get_template_directory_uri() . '/inc/js/addon-scripts.js', array(), $ver, true);
    }

	/** We don't want the Deposits for WooCommerce frontend stylesheet  */
	wp_dequeue_style( 'awcdp-frontend');

}
add_action( 'wp_enqueue_scripts', 'vgc_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;
        }
    return $title;
});

/*********** GET THE TERM PARENT ID ----------------*/

function get_term_top_parent($termID) {
	while($termID) {
		$term = get_term_by('id', $termID, 'product_cat', 'OBJECT');
		$termID = $term->parent;
	}
return $term;
}

//******** Alter the query for any news category page **************************************

function alter_product_archive_query($query) {

	global $wp_query;

	if($query->is_home()) {
		return;
	}
	if(is_admin() || !$query->is_main_query()) {
		return;
	}
	if(!is_tax('product_cat')) {
		return;
	}

	$query->set( 'posts_per_page', 32 );

	remove_all_actions('__after_loop');

}
add_action('pre_get_posts', 'alter_product_archive_query');


/*********** Add options page ----------------*/

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}

add_filter( 'woocommerce_billing_fields', 'woo_filter_state_billing', 10, 1 );
add_filter( 'woocommerce_shipping_fields', 'woo_filter_state_shipping', 10, 1 );

function woo_filter_state_billing( $address_fields ) { 
  $address_fields['billing_state']['required'] = true;
  //$address_fields['billing_state']['label'] = 'TTTT';  
	return $address_fields;
}

function woo_filter_state_shipping( $address_fields ) { 
	$address_fields['shipping_state']['required'] = true;
    //$address_fields['shipping_state']['label'] = 'TTTT';
    
    //var_dump($address_fields['shipping_state']);
    //die();
    	
	return $address_fields;
}

add_filter( 'woocommerce_get_country_locale', 'mp_change_locale_field_defaults');
 
function mp_change_locale_field_defaults($countries) {
    $countries['GB']['state']['required'] = true;
    return $countries;
}

// add_filter( 'woocommerce_billing_fields', 'formulare_filter_billing_state', 10, 999 );
// function formulare_filter_billing_state( $address_fields ) {
// 	$address_fields['billing_state']['required'] = true;
//     var_dump($address_fields['billing_state']);
//     die();	
//     $address_fields['billing_state']['label'] = 'County <abbr class="required" title="required">*</abbr>';
//     
// 	return $address_fields;
// }

add_filter( 'should_load_separate_core_block_assets', '__return_true' );


//Disable the new user notification sent to the site admin
function smartwp_disable_new_user_notifications() {
	//Remove original use created emails
	remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );
	//Add new function to take over email creation
	add_action( 'register_new_user', 'smartwp_send_new_user_notifications' );
	add_action( 'edit_user_created_user', 'smartwp_send_new_user_notifications', 10, 2 );
}
function smartwp_send_new_user_notifications( $user_id, $notify = 'user' ) {
	if ( empty($notify) || $notify == 'admin' ) {
	  return;
	}elseif( $notify == 'both' ){
    	//Only send the new user their email, not the admin
		$notify = 'user';
	}
	wp_send_new_user_notifications( $user_id, $notify );
}
add_action( 'init', 'smartwp_disable_new_user_notifications' );

/**
 * Don't exclude WooCommerce hidden products from the AIOSEO Sitemap
 */
add_filter( 'aioseo_sitemap_woocommerce_exclude_hidden_products', '__return_false');
