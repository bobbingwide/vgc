=== VGC ===
Contributors: automattic, Hotbox Studios, bobbingwide
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready
Requires at least: 4.5
Tested up to: 6.1
Stable tag: 1.3.3
License: GNU General Public License v2 or later
License URI: LICENSE

Theme for gardevista.co.uk

== Description ==

VGC is the theme for gardenvista.co.uk. 

- It uses/supports Elementor with Elementor-Pro for some of the main pages
- and WooCommerce for the online shop.
- Some of the templates include hardcoded logic which refer to background images.
- The stylesheet also refers to hardcoded background images
- Some of these images are now delivered as part of the theme; instead of being located in wp-content/uploads

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Changelog ==
= 1.3.4 = 
* Fixed: Replace /shop_test by /store to resolve 404 on mobile/tablet #46

= 1.3.3 =
* Fixed: Re-enable houses slick slider for WordPress 6.1 and new jQuery 3.6.1 #45
* Tested: With WordPress 6.0.3
* Tested: With PHP 8.0
* Tested: With WooCommerce 7.0.0

= 1.3.2 =
* Fixed: Correct logic to adjust price. #43,#19
* Tested: With WordPress 6.0.3
* Tested: With PHP 8.0
* Tested: With WooCommerce 7.0.-

= 1.3.1 =
* Changed: Updated myaccount/form-login for WooCommerce 7.0.0 and Bootstrap CSS conflict #43
* Fixed: Warnings and Fatal ( with PHP 8 ) discovered when testing with WooCommerce 7.0.0 #43
* Tested: With WordPress 6.0.3
* Tested: With PHP 8.0
* Tested: With WooCommerce 7.0.0

= 1.3.0 = 
* Changed: Enable Bootstrap.js v5.1.3, then disable again #30
* Changed: Hide price of 0.00 on Optional Upgrades #40
* Changed: Don't display Installation options when optional upgrade for Installation is being displayed #40
* Tested: With WordPress 6.0.0
* Tested: With PHP 8.0
* Tested: With WooCommerce 6.6.1

= 1.2.1 = 
* Fixed: number_format() doesn't work with 3 parameters on PHP 7.4. #36

= 1.2.0 = 
* Changed: Reduce width of main menu item links. Style Onlie Shop link. Reduce floating links image size
* Changed: Don't display product quantity; it can't be adjusted. #35
* Changed: Don't apply options discount where price is percentage of starting price #19
* Changed: Correct calculate_price for multi- options. #32
* Fixed: Cater for badly defined options - with no price #32
* Fixed: Format price with 2 decimal places eg 1,234.50
* Added: Style Online Shop in the main menu as red
* Fixed: Avoid Fatal when delivery_cost not numeric #27
* Changed: Support options-discount #19. Change CSS classes for bootstrap 5 #30
* Changed: Support options discount #19. Support offer_base_options field #27
* Added: Add Google site verification code #26
* Changed: Don't enqueue typescript CSS or bootstrap CSS or JS. #30 Change /shop_test to /store #26
* Changed: Change CSS classnames for bootstrap 5 #30
* Added: Apply options_discount to all optional addon types #19
* Fixed: Avoid Warning if term_id property is not set. Probably unnecessary code #22
* Added: Start to apply options_discount #19
* Changed: Format product price with 2 decimal places #19
* Added: Don't offer Base options for Deponti or Lugarde #27
* Fixed: Avoid notices #22. Experiment with supporting variations #17. Trim postcode #25
* Added: Support options_discount on single choice addons #19
* Added: Support options_discount #19. Display Product short description #17
* Changed: Add vgc_option_select() #23
* Fixed: Use $product->get_id() to avoid Notices #22
* Changed: Update with changes in v5.2.0 #16
* Fixed: Pragmatically up the version to 4.7.0 #16

= 1.1.0 = 
* Changed: Replace rand() with harcoded value. #12 
* Changed: Don't enqueue wc-atc #13
* Changed: Merge woocommerce/content-single-product.php from Hotbox #12
* Changed: Don't import an empty CSS file from p.typekit.net/p.css #4
* Changed: Replace more images with .webp versions from the theme #8
* Changed: Add theme.json #11
* Changed: Merge smartwp_disable_new_user_notifications() #12
* Changed: Replace CTA images with .webp versions from the theme #8
* Changed: Use WebP background images. Issue #10
* Changed: Switch to WebP images. Set loading=lazy, width and height #8
* Fixed: Use wc_get_cart_url() Fixes #7 
* Fixed: Set width and height attributes for logo Fixes #6
* Fixed: Improve header.php Fixes #5
* Fixed: Cater for WooCommerce being deactivated. Fixes #2 
* Fixed: Load separate core block assets. Fixes #3 
* Fixed: Enqueue typekit and bootstrap CSS locally. Fixes #4
* Fixed: remove support for the Widgets block editor. Fixes #1
* Tested: With PHP 8.0
* Tested: With WordPress 5.8.2

= 1.0.0 =
* Version extracted from gardenvista.co.uk on 2021/06/25

= 1.0 - May 12 2015 =
* Initial release - of Underscores

== Credits ==

* Based on Underscores https://underscores.me/, (C) 2012-2017 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css https://necolas.github.io/normalize.css/, (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](https://opensource.org/licenses/MIT)
