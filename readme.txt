=== VGC ===
Contributors: automattic, Hotbox Studios, bobbingwide
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready
Requires at least: 4.5
Tested up to: 6.8.2
Stable tag: 2.0.0-beta3
License: GNU General Public License v2 or later
License URI: LICENSE

Theme for gardevista.co.uk

== Description ==

VGC is the theme for gardenvista.co.uk. 

- It uses/supports Elementor with Elementor-Pro for some of the main pages
- and WooCommerce for the online shop.
- Aadvanced Custom Fields Pro for custom fields (incl. repeater fields) and a global options page 
- Search and Filter Pro v2.5 for WooCommerce filters
- or Search and Filter Pro v3.1 for WooCommerce filters and Load more pagination
- Some of the templates include hardcoded logic which refer to background images.
- The stylesheet also refers to hardcoded background images
- Some of these images are now delivered as part of the theme; instead of being located in wp-content/uploads

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Changelog ==
= 2.0.0-beta4 = 
* Changed: With S&F Pro v3.2.0-beta-6 we no longer need to force the search-filter-query--id-1 div #95

= 2.0.0-beta3 =
* Fixed: Correct full_width-image subfield name #96
* Changed: Enable Filter Search heading and default sorting to be seen on mobile #94
* Changed: Ensure the first and last classes in the product list are adjusted #95

= 2.0.0-beta2 =
* Changed: Revert Sales banner and Popular Categories move #93

= 2.0.0-beta1 =
* Changed: Update version for WooCommerce 9.9.0 #83
* Changed: Support S&F Pro v3.1 on product-category display #95
* Changed: Support S&F Pro v3.1 #71
* Changed: Move sales banner and popular categories below products list #93
* Changed: Add Sort Order drop down #94
* Changed: Add support for 3 part sales banner #87
* Changed: Set sidebar background colour to light grey, was dark bluey green #71
* Changed: Support Search & Filter Pro v3 using Load more rather than pagination #71
* Fixed: Don't invoke the old copy optional upgrades logic #24
* Changed: Add support for Search & Filter Pro v3 while still supporting v2 #71
* Changed: Add support for Search & Filter Pro v3 #71
* Changed: Add new Javascript for Search & Filter Pro v3.1.7
* Changed: First attempt to use MutationObserver to reduce duplicate products with S&F Pro v3 #71
* Fixed: No longer enqueue vgc_copy.js #24
* Tested: With WordPress 6.8.2
* Tested: With WooCommerce 10.0.2
* Tested: With PHP 8.3

= 1.9.3 = 
* Fixed: Test for empty before testing for negative #92

= 1.9.2 =
* Changed: Disable the Installation option on a per product basis #92

= 1.9.1= 
* Changed: Treat Glass rooms, Verandas & Gazebos the same as Log Cabins.  gardenvista issue 37
* Fixed: Remove ineffectively commented out code that's bee replaced by the searchandfilter shortcode #36
* Fixed: Defer adding of ACF options page to `init` #89
* Changed: Update versions for WooCommerce 9.8.1 #83
* Tested: With WooCommerce 9.8.1

= 1.9.0 = 
* Changed: Improve support for Brands which offer nationwide delivery #88
* Changed: Add action to display the store sales banner on the home page #85
* Added: Add template part for Nationwide delivery, where the delivery price is the same for each post code band #88
* Changed: Cater for potential to display up to 8 brands in a row #86
* Changed: Reduce size of brand links - allow 6 per row #86
* Changed: Add logic to display the sales banner image on the home page #85
* Changed: Change slider values for pauseOnFocus and pausOnHover to true #85
* Changed: Shop page: display 2 columns on narrow mobile devices #84
* Changed: Remove the negative bottom settings for .slick-dots #85
* Tested: With WordPress 6.8-RC3
* Tested: With PHP 8.3
* Tested: With WooCommerce 9.7.0

= 1.8.7 = 
* Changed: Update version on woocommerce/myaccount/form-login.php #82
* Tested: With WordPress 6.7-RC3
* Tested: With PHP 8.3
* Tested: With WooCommerce 9.3.3 

= 1.8.6 = 
* Changed: Add name attribute to fontFamilies to avoid warning from WooCommerce #81
* Changed: Add Finance Options to mobile menus #80
* Tested: With WordPress 6.6.1
* Tested: With PHP 8.3
* Tested: With WooCommerce 9.1.4

= 1.8.5 = 
* Fixed: Avoid Warning when select option has no options #79
* Changed: Update to cater for security improvements in ACF / ACF Pro #78
* Changed: Update archive-product template version to 8.6.0 for WooCommerce 9.0.1 #77
* Fixed: Avoid warning when the addons array is empty #76
* Tested: With WordPress 6.5.5
* Tested: With PHP 8.3
* Tested: With WooCommerce 9.0.1

= 1.8.4 =
* Changed: Reduce primary menu item width from 10% to 9% to allow for Finance Options #75
* Tested: With WordPress 6.5.3

= 1.8.3 =
* Changed: Update support for the deposits-partial-payments-for-woocommerce plugin #74
* Tested: With WordPress 6.5.2

= 1.8.2 =
* Changed: Change 'To Most Of The UK' to 'On Most Products' #73

= 1.8.1 = 
* Fixed: Use textContent rather than innerText to cater for iOS devices #72

= 1.8.0 = 
* Changed: Display Installation after post code entry for brands which vary delivery charges by brand #70
* Changed: Ensure add to cart disabled before post code band has been determined. #69

= 1.7.3 = 
* Fixed: Correct spelling of available_options #68
* Tested: With WordPress 6.4.1

= 1.7.2 = 
* Fixed: Cater for null values for Brands fields #59
* Fixed: Support PHP 8.1 #62
* Changed: Improve screenshot 
* Tested: With WordPress 6.4-RC3

= 1.7.1 = 
* Fixed: Correctly support delivery cost of 0. #59

= 1.7.0 =
* Fixed: Avoid Warning undefined array key _square_meter from in redundant code #65
* Fixed: Avoid messages when product is not connected to a brand #64
* Fixed: Support PHP 8.1 and PHP 8.2 #62
* Changed: Update version to keep WooCommerce 8.2.1 happy #44
* Changed: Post code related options for delivery, installation, removal and base #59
* Fixed: Warning Undefined variable $base. Replace by $row #61
* Changed: Enable gvg_product_range's duplicate filter and dropdown logic #60
* Changed: Round baseSqFeet before checking key #49
* Changed: Don't exclude WooCommerce hidden products from the AIOSEO Sitemap #58
* Tested: With WordPress 6.4-RC2
* Tested: With PHP 8.0, PHP 8.2 and PHP 8.2
* Tested: With WooCommerce 8.2.1

= 1.6.0 =
* Changed: Style up-sells and related products on the single product page #54
* Changed: Display up-sells and related products #54
* Changed: Display up-sells in 3 columns #54
* Fixed: Don't display cross sells on the shopping cart #38
* Added: Display product range buttons on the single product page #56
* Fixed: Format regular price to 2 decimal places #57
* Tested: With WordPress 6.2.2
* Tested: With PHP 8.0
* Tested: With WooCommerce 7.8.0

= 1.5.1 =
* Changed: Enable two options for add to cart - deposit or full payment #29

= 1.5.0 = 
* Added: Add popular categories below banner on store page #51 
* Added: Add brand categories below products #52 
* Fixed: don't invoke woocommerce_sidebar action #53
* Fixed: Correct spelling in a comment
* Changed: Support SCRIPT_DEBUG constant to cache bust CSS files
* Added: Add sort by dropdown to product category archive #48
* Changed: Prevent hovered images covering the sort by dropdown #48
* Tested: With WordPress 6.2-RC2
* Tested: With PHP 8.0
* Tested: With WooCommerce 7.4.1

= 1.4.0 =
* Changed: Support new ranges for global base options #49
* Changed: Add logic to display a banner image on the shop home page #47
* Changed: Tested with WooCommerce 7.4.0 #44
* Fixed: Change Continue shopping link from shop_test to store #46
* Changed: Add sort by drop box on product page #48
* Changed: Add suppport for Deposits and Partial Payments for WooCommerce by Acowebs #29 

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
