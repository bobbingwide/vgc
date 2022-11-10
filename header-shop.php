<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package VGC
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
  <!-- INCLUDE FONT AWESOME -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-12709496-1"></script>


    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-12709496-1');
  </script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="floating-links d-flex absolute">
    <div><a href="/contact_us/" title="#"><img src="/wp-content/themes/vgc/images/floating-link-person-icon.jpg" alt="Person Icon" /></a></div>
    <div><a href="tel:+441730893999" title="#"><img src="/wp-content/themes/vgc/images/floating-link-phone-icon.jpg" alt="Phone Icon" /></a></div>
    <div><a href="mailto:sales@gardenvista.co.uk" title="#"><img src="/wp-content/themes/vgc/images/floating-link-mail-icon.jpg" alt="Mail Icon" /></a></div>
    <div><a href="/contact_us/#location" title="#"><img src="/wp-content/themes/vgc/images/floating-link-location-icon.jpg" alt="Location Icon" /></a></div>
</div>
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'vgc' ); ?></a>
<header id="masthead" class="site-header shop-header">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-2 mw">
        <?php $themeLogo = get_header_image(); ?>
        <a href="/store" title="Garden Vista Group | Go to the Homepage"><img src="/wp-content/uploads/2019/10/vgc_logo_2019-25.png" alt="Logo" style="max-width: 140px"></a>
      </div>
      <div class="col-lg-6 mobeshop">
        <?php echo do_shortcode('[wcas-search-form]'); ?>
      </div>
      <div class="col-lg-4 pt-2 pb-2 mw">
        <?php if(is_active_sidebar(dynamic_sidebar('header-1'))) : dynamic_sidebar('header-1'); endif; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 p-0">
        <div class="fixed-top shop-mob-nav">
            <div style="background:#efefef; color: #3e606f; font-size: 12px; padding: 5px;  font-weight: 600; display: flex ">
                <div>
                <a href="tel:+441730893999" style="color: #3e606f; text-decoration: none; display: inline-block; padding: 2px">01730 893999 Lines open 9:00am to 5:30pm</a>
                </div>
                
                <div style="margin-left: auto">
                <a href="/my-account/" style="color: #3e606f; text-decoration: none">   
                Login
                <img src="/wp-content/themes/vgc/images/icons/sign-in-icon-vgc.png" width="20" height="20"> 
                </a>
                </div>
                
            </div>

          <ul class="shop-mob-only shop-mob-nav row">
              <li class="col align-self-center pl-1 pr-1">
              <a class="menu" href="/store">
                  <img class="mob-logo" src="/wp-content/uploads/2019/10/vgc_logo_2019-25_white.png" height="30" width="53" /></a>
              </li>
              <li class="col">
                      <a href="#" class="menu-btn" tabindex="0">
                      <img src="/wp-content/uploads/2018/08/menu.svg" width="20" height="20">
                      <br>Menu</a>
              </li>
              <li class="col">
                      <a href="/contact_us/">
                      <img src="/wp-content/uploads/2018/08/loc.svg" width="20" height="20" style="position: relative;top: -2px;">
                      <br>Visit Us</a>
              </li>
              <li class="col">
                      <a href="javascript:toggle_mob_search();">
                      <img src="/wp-content/uploads/2018/08/search.svg" width="20" height="20" style="position: relative;top: -2px;">
                      <br>Search
                      </a>                                        
              </li>
              <li class="col">
                  <a href="tel:+441730893999">
                      <img src="/wp-content/uploads/2018/09/phone.svg" width="20" height="20" style="position: relative;top: -2px;">
                      <br>Call Us</a>
              </li>
              <li class="col">
                      <a href="/cart/">
                      <img src="/wp-content/uploads/2018/08/basket.svg" width="20" height="20" style="position: relative;top: -2px;">
                      <br>Basket
                      </a>
              </li>
          </ul>
          </div>
      		<nav id="site-navigation" class="main-navigation shop-main-navigation shop-navigation">
      			<?php
      			wp_nav_menu( array(
      				'theme_location' 	=> 'menu-4',
      				'menu_id'        	=> 'sub',
      				'container_class'	=> 'menu-sub-container'
      			) );
      			?>
      		</nav><!-- #site-navigation -->
        </div>
      </div>
    </div>
	</header><!-- #masthead -->
