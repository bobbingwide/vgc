<?php
/*
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header('shop');

include_once('inc/classes/define-addons-by-postcode.php');

if (post_password_required()) {
	echo get_the_password_form();
	return;
}

// Retreive the global $product variable to use throughout the template
global $product;

$options_allowed = array();

if(function_exists('get_field')) {
	// Get the optional upgrades
	$addons = get_field('optional_upgrades');
	// Get the brand relation
	$brandRelation = get_field('brand');
	if(!empty($brandRelation)) {
		
		$delivery_cost 	  = get_field('delivery_cost', $brandRelation[0]->ID);
		$delivery_band_1  = get_field('delivery_cost_band_1', $brandRelation[0]->ID);
		$delivery_band_2  = get_field('delivery_cost_band_2', $brandRelation[0]->ID);
		$delivery_band_3  = get_field('delivery_cost_band_3', $brandRelation[0]->ID);
		$delivery_band_4  = get_field('delivery_cost_band_4', $brandRelation[0]->ID);
		$options_allowed["delivery_cost"] = array(
			$delivery_cost, 
			$delivery_band_1, 
			$delivery_band_2, 
			$delivery_band_3, 
			$delivery_band_4
		);

		$postcode_excluded = get_field('postcodes_excluded', $brandRelation[0]->ID);
		$options_allowed["postcode_excluded"] = $postcode_excluded;

        // Global Install cost (number)
        $installCost = get_field('install_cost_per_sq_ft','options');
        // Brand specific install cost
        $brandInstallCost  = get_field('installation_cost_override', $brandRelation[0]->ID); 
        if($brandInstallCost)
        {
           $installCost = $brandInstallCost;
        }
        $options_allowed["installation_cost"] = $installCost;

	}
	// If removal is available (BOOL)
	$removal_availalble = get_field('removal_available');
	$options_allowed["removal_available"] = $removal_availalble;
	// Removal costs
	$removal_costs = get_field('removal_costs','option');
	$options_allowed["removal"] = $removal_costs;	
	// Postcodes by band - may be for delivery, base, install and removal....
	$postcode_band_1 = get_field('postcodes_1','option');
	$postcode_band_2 = get_field('postcodes_2','option');
	$postcode_band_3 = get_field('postcodes_3','option');
	$postcode_band_4 = get_field('postcodes_4','option');
	$options_allowed["postcode_bands"] = array(
		$postcode_band_1,
		$postcode_band_2,
		$postcode_band_3,
		$postcode_band_4
	);
}

// When a postcode is entered
if(isset($_POST['postcode'])) {
	// Hide the section no-search-default
	$display = "display:none;";
	$postcode = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);
	// Return the addon fields to display based on the provided data and the postcode
	$ppq = new define_addons_by_postcode($postcode, $options_allowed);
	// Now we know if delivery is allowed
	$canOrder = $ppq->getCanOrder();
	$deliveryStatus = $ppq->getDeliveryStatus();
	$installationStatus = $ppq->getInstallationStatus();
	$removalStatus = $ppq->getRemovalStatus();	
}
else {
	// Show the placeholder section
	$display = "display:block;";
}
?>

<!-- Get USP Icon Strip -->
<?php get_template_part('/template-parts/shop/usp', 'strip'); ?>

    <?php
     if ( $product->is_on_sale() )  {    ?>
     <div style='background: #c31313;margin-bottom: 10px; margin-top: -10px;padding: 10px;'> 
     <p style="color:#ffffff;font-size: 25px;margin: 0px;text-align:center;">ON SALE FROM: £<?php echo number_format($product->get_sale_price(),2); ?></p>                      
     </div>
     <?php
     } 
     ?>	

<!-- Start product single main -->
<section class="product-single">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 d-flex">
    			<div class="brand__logo">
					<?php if(function_exists('get_field')) {
						// Get the brand logo
						if(!empty($brandRelation)) {
							echo get_the_post_thumbnail($brandRelation[0]->ID, 'medium');
						}
					}
					?>
    			</div>
				<h1 class="font-weight-bold font-colour-primary">
    				<?php the_title(); ?><br>
                    <?php
                    if ( $product->is_on_sale() )  {    ?>
                   <span style="color:rgb(62, 96, 111);font-size: 23px;margin-top: 0px;display: inline-block;"> <strike><?php echo "From: £" . $product->get_regular_price(); ?></strike></span>
                    <span style="color:red;font-size: 25px;margin-top: 0px;display: inline-block;">SALE <?php echo "From: £" . number_format($product->get_sale_price(),2); ?></span>                      
                    <?php
                    } else {                        
                    ?>
                    <span style="color:rgb(62, 96, 111);font-size: 23px;margin-top: 0px;display: block;"><?php echo "From: £" . $product->get_regular_price(); ?></span>
                    <?php
                    }
                    ?>
                </h1>
			</div>
		</div>
		<div class="row pb-5" id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
			<div class="col-lg-5" style="overflow: hidden">
				<?php get_template_part('/template-parts/shop/flexslider', 'carousel') ?>
			</div>
			<div class="col-lg-6 offset-lg-1">
				<h3 class="w-100 clearfix font-weight-bold mb-2 font-colour-primary">Standard Features</h3>
				<?php
					if(function_exists('get_field')) { ?>
						<div class="row">
							<div class="col-lg-6">
								<?php echo the_field('standard_features_1'); ?>
							</div>
							<div class="col-lg-6">
								<?php echo the_field('standard_features_2'); ?>
							</div>
						</div>
					<?php } ?>
					<h3 class="w-100 clearfix font-weight-bold mb-4 font-colour-primary">Product Description</h3>
					<p><?php echo nl2br($product->get_description()); ?></p>
				</div>
			</div>
		</div>
	</section>


    <?php
     if ( $product->is_on_sale() )  {    ?>
     <div style='background: #c31313;margin-bottom: -40px;padding: 10px;'> 
     <p style="color:#ffffff;font-size: 25px;margin-top: 0px;text-align:center;">ON SALE FROM: £<?php echo number_format($product->get_sale_price(),2) ?></p>                      
     </div>
     <?php
     } 
     ?>	
	<a name="options_area" id="options_area"></a>

	<!-- Start the postcode search input field section if addons have been added -->
	<?php //if($addons) { ?>
		<?php get_template_part('/template-parts/shop/postcode', 'search'); ?>
		<!-- No search default area - waiting for postcode search -->
		<section class="no-search-default options" style="<?php echo $display; ?>">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-10 text-center">
						<img src="/wp-content/themes/vgc/images/icons/shed_500x500.png" alt="House icon">
						<h2 class="w-100 clearfix font-weight-bold mb-4 font-colour-primary text-center">Enter your postcode above to see the options available for this product</h2>
					</div>
					<div class="col-lg-2 bg-brand-third text-center sidebar-checkout">
						<div class="sticky-cart">
							<div class="hov w-100">
								<a href="/checkout" class="btn-primary btn bg-brand-secondary font-weight-bold" style="margin-bottom:100px;">Checkout</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php //} ?>
	
 

	<!-- INCLUDE THE ADDON OPTIONS SELECTOR WHEN THE POSTCODE INPUT FIELD IS POSTED -->
	<?php if(isset($_POST['postcode'])) : ?>
		<form action="" method="post" id="select-addons">
			<section class="options">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-10">
							<?php 
    							
    							
    							
    							if($canOrder) {
								set_query_var('product', $product);
								set_query_var('addons', $addons);
								set_query_var('ppq', $ppq);
								set_query_var('installCost', $installCost);
								set_query_var('installationStatus', $installationStatus);
								set_query_var('deliveryStatus', $deliveryStatus);
								get_template_part('/template-parts/shop/addons', 'main');
							} else {
								?>
								<h2 style="padding: 40px;text-align: center;font-weight: bold;">Sorry we cannot supply this to your location, please call us to discuss your options
								</h2>
							<?php }?>
						</div>
						<div class="col-lg-2 bg-brand-third text-center sidebar-checkout">
							<div class="sticky-cart">
								<div class="current-cart-session text-white text-left">


                                        <div class="text-left w-100 clearfix"><div class="d-flex minilist"><div class="minilist__name">
                      Starting at                     </div><div class="price minilist__price"> £<?php echo $product->get_price(); ?></div></div></div>

									<h3 class="pb-2" style="margin-top: 20px">Current Cart</h3>
									<div class="items">
									</div>
									<strong class="pt-3 d-block">Cart Total:</strong>
									<div class="d-flex">
										<div>£</div>
										<div class="baseprice"><?php echo $product->get_price(); ?></div>
									</div>
								</div>
								<button 
									id="btn-add-to-cart"
									type="submit" 
									name="add-to-cart" 
									value="<?php echo $product->get_ID(); ?>" 
									class="btn btn-secondary font-colour-primary">Add to cart</button>
							</div>
						</div>
					</div>
				</div>
			</section>
		 </form>
	<?php endif; ?>

<?php get_template_part('/template-parts/shop/product-single', 'end'); ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
