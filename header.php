<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VGC
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="google-site-verification" content="DH8-CVNP-ey-ZBBhL2RR75aBET8E2WGxBNJyiQdxgCQ" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://www.google-analytics.com">
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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'vgc' ); ?></a>
    <div id="container">
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$vgc_description = get_bloginfo( 'description', 'display' );
			if ( $vgc_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $vgc_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
        <div class="fixed-top mob-nav">
        <ul class="mob-only mob-nav row">
            <li class="col align-self-center pl-1 pr-1">
            <a class="menu" href="/">
                <img class="mob-logo" src="/wp-content/themes/vgc/images/webp/vgc_logo_2019-25_white-300x169.webp" height="44" /></a>
            </li>
            <li class="col">
                    <a href="#" class="menu-btn" tabindex="0">
                    <img src="/wp-content/uploads/2018/08/menu.svg" width="20" height="20">
                    <br>Menu</a>
            </li>
            <li class="col">
                <a href="/finance-options/">
                    <div style="font-size: 26px; font-weight:bold; line-height: 0.7; margin-bottom: 2px">£</div>
                    Finance Options</a>
            </li>
            <li class="col">
                    <a href="/contact/">
                    <img src="/wp-content/uploads/2018/08/loc.svg" width="20" height="20" style="position: relative;top: -2px;">
                    <br>Visit Us</a>
            </li>
            <li class="col">
                    <a href="javascript:togglesearch();">
                    <img src="/wp-content/uploads/2018/08/search.svg" width="20" height="20" style="position: relative;top: -2px;">
                    <br>Search
                    </a>
                    <div class="hidden searchform">
                        <?php get_search_form();?>
                    </div>
            </li>
            <li class="col">
                <a href="tel:+441730893999">
                    <img src="/wp-content/uploads/2018/09/phone.svg" width="20" height="20" style="position: relative;top: -2px;">
                    <br>Call Us</a>
            </li>
            <li class="col">
                <a href="/store/">
                    <img src="/wp-content/uploads/2018/08/basket.svg" width="20" height="20" style="position: relative;top: -2px;">
                    <br>Shop</a>
            </li>
        </ul>
        </div>

		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			wp_nav_menu( array(
				'theme_location' => 'menu-2',
				'menu_id'        => 'sub',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container-fluid">
