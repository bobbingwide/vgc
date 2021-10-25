<?php 


add_action( 'woocommerce_before_calculate_totals', 'update_custom_price', 1, 1 );

function update_custom_price( $cart_object ) {
	if( !WC()->session->__isset( "reload_checkout" )) {
	  	foreach ( $cart_object->cart_contents as $cart_item_key => $value ) {
	      	$value['data']->set_price($value['custom_price']);
	  	}
	}
}




// This gets the addons and add them aas meta fields to the product_____

add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);

if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
  	global $woocommerce, $wpdb;
    $user_custom_values = $values["addon_titles"];
    if(!empty($user_custom_values)) {
    	foreach($user_custom_values as $uc)
    	{
    		wc_add_order_item_meta($item_id,'Option',$uc);  
    	}
    }
  }
}

add_filter( 'woocommerce_add_cart_item_data', 'calculate_price_on_cart_addition', 10, 2 );

/**
 * Calculate price when user moves to checkout
 */
function calculate_price_on_cart_addition($cart_item_data, $product_id) {
    // Include the necessary objects to run the calculations
    require 'wp-content/themes/vgc/woocommerce/inc/classes/calculate-price.php';
    // Get the product
    $product = wc_get_product($product_id);
    // Get the size of the product in square meter
    $productLength = $product->get_length();
    $productWidth = $product->get_width();
    // Get the optional addons acf field array to get the prices from
    $addonsFieldArray = get_field('optional_upgrades', $product_id);
    // Format the optional addons acf field array to compare against the posted data
    $addonsFieldArray = formatAddonsArray($addonsFieldArray);
    // Get the postcode band
    $postcodeBand = (int) filter_var($_POST['b'], FILTER_SANITIZE_NUMBER_INT);
    // Get the base price from the global options table if a base has been choosen
    $baseType['bases'] = array(
        ucwords($_POST['base-type']),
    );
    // Get the base material name
    $baseMaterial = strtolower($baseType['bases'][0]);
    // If a base has been choosen get the price and add it to the addonsFieldArray to later calculate the price
    if($baseType['bases'][0] !== "No") {
        $array = getBaseTypePriceFromGlobalOptions($productLength, $productWidth, $baseType, $postcodeBand);
        $addonsFieldArray['single-price-base-type-'.$baseMaterial.''] = array_shift($array);
    }
    // Unset the add-to-cart array element and also any empty fields
    unset($_POST['add-to-cart']);
    // Unset empty values
    foreach($_POST as $key => $value) {
        if($value == "") {
        	unset($_POST[$key]);
        }
    }
    // Then get the product price
    $productPrice = $product->get_price();
    // Get the delivery cost from the flat rate shipping method
    $delivery = WC_Shipping_Zones::get_shipping_method(3);
    $deliveryCost = $delivery->cost;
    // Run calculations to get the custom price / get the prices from the addons array  
    $calculator = new calculate_price($_POST, $addonsFieldArray, $productPrice, $productLength, $productWidth, $product_id, $deliveryCost);
    // Fetch the calculated custom price
    $customPrice = $calculator->getCustomPrice();
    // Set unique meta data for the cart addition
    $unique_cart_item_key = md5(microtime().rand());
    // Make sure each item is added to the cart seperately
    $cart_item_data['unique_key'] = $unique_cart_item_key;
    //the price
    $cart_item_data['custom_price'] = $customPrice;
    // ge the meta addon bits.....
    $cart_item_data['addon_titles'][] = "<div><strong>".$product->get_title()." : </strong> <span>£".$productPrice."</span></div>";
    $cart_item_data['addon_titles'] = array_merge($cart_item_data['addon_titles'],$calculator->getCustomCartDescriptions());
    // Format the addon titles in a readable way read to be used in the cart
    // foreach($_POST as $key => $value) {
    //     if($key !== "b" && $key !== "building_removal" && $key !== "building_removal_removal-and-taking-away-of-timber-building" && $key !== "building_removal_removal-of-greenhouses" && $key !== "base_extra") {
    //         $newkey = cleanKey($key, $value);
    //         if(($newkey != "") && trim($value != "")) {   
    //             $cart_item_data['addon_titles'][] = $newkey;
    //         }
    //     }
    //     if($key == "building_removal_removal-of-greenhouses" && $value != "no") {
    //         $cart_item_data['addon_titles'][] = "<div><strong>Greenhouse Removal: </strong> ".$value."</div>";
    //     }
    //     if($key == "building_removal_removal-and-taking-away-of-timber-building" && $value != "no") {
    //         $cart_item_data['addon_titles'][] = "<div><strong>Garden Building Removal: </strong> ".$value."</div>";
    //     }
    // }
    
    
    //var_dump($cart_item_data['addon_array']);	
    //this doesnt do anything.........hmmmmmmmm
    $cart_item_data['addon_array'] = $addons;
    
    //this is still the origional price :) 
    //var_dump($productPrice);	
    //die();
    
    return $cart_item_data;
}

/**
 * Redirect users after add to cart.
 */

add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );

function my_custom_add_to_cart_redirect( $url ) {
	//$url = WC()->cart->get_cart_url();
    $url = wc_get_cart_url();
	return $url;
}


function to_decimal($num)
{
    if($num == 0)
    {
        $num = "0.00";
    }
    else
    {
        $num = number_format((float)$num, 2, '.', '');
    }
    return $num;
}  


/*
* Create a human readable addon title from the choosen posted array keys
*/
function cleanKey2($key, $value) {			    	
	// Remove the first part of the array key which is no longer needed
	switch($key) {
		case substr($key, 0, 19) == "single-single-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 19, strlen($key)));
			break;
		case substr($key, 0, 20) == "single-percent-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 20, strlen($key)));
			break;
		case substr($key, 0, 20) == "single-squared-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 20, strlen($key)));
			break;
		case substr($key, 0, 19) == "single-length-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 19, strlen($key)));
			break;
		case substr($key, 0, 18) == "multi-single-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 18, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 19) == "multi-percent-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 19, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 19) == "multi-squared-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 19, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 18) == "multi-length-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 18, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case $key == "base-type" :
			$cleanKey = "Base type: " . $value;
			break;
		case $key == "installation" :
			$cleanKey = "Installation: " . $value;
			break;
		case $key == "delivery" :
			$cleanKey = "Delivery: Yes"; 
			break;	
		default : 
			$cleanKey = $key;
	}
	$array = explode(':', $cleanKey);
	if(!empty($array[0])) {
		$first = ucwords($array[0]).": ";
	}
	else {
		$first = "";
	}
	return $first." ".ucwords($array[1]);
}

/*
* Create a human readable addon title from the choosen posted array keys
*/
function cleanKey($key, $value) {			    	
	// Remove the first part of the array key which is no longer needed
	switch($key) {
		case substr($key, 0, 19) == "single-single-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 19, strlen($key)));
			break;
		case substr($key, 0, 20) == "single-percent-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 20, strlen($key)));
			break;
		case substr($key, 0, 20) == "single-squared-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 20, strlen($key)));
			break;
		case substr($key, 0, 19) == "single-length-addon" :
			$cleanKey = str_replace('-',' ', substr($key, 19, strlen($key)));
			break;
		case substr($key, 0, 18) == "multi-single-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 18, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 19) == "multi-percent-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 19, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 19) == "multi-squared-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 19, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case substr($key, 0, 18) == "multi-length-addon" :
			$keyFirst = str_replace('-',' ', substr($key, 18, strlen($key)));
			$cleanKey = $keyFirst . ' - ' . $value;
			break;
		case $key == "base-type" :
			$cleanKey = "Base type: " . $value;
			break;
		case $key == "installation" :
			$cleanKey = "Installation: " . $value;
			break;
		case $key == "delivery" :
			$cleanKey = "Delivery: Yes"; 
			break;	
		default : 
			$cleanKey = $key;
	}
	$array = explode(':', $cleanKey);
	if(!empty($array[0])) {
		$first = ucwords($array[0]).": ";
	}
	else {
		$first = "";
	}
	return "<div><strong>".$first." </strong>".ucwords($array[1]) . "</div>";
}

/*
* Deal with how the addon info is displayed in the shopping cart
*/
add_filter( 'woocommerce_get_item_data', 'display_addon_info_in_cart', 10, 2 );

function display_addon_info_in_cart( $item_data, $cart_item ) {
    if (empty($cart_item['addon_titles'])) {
			return $item_data;
    }
    $item_data[] = array(
			'key'     => __( 'Product Addons', 'vgc' ),
			'value'   => implode(' ', $cart_item['addon_titles']),
			'display' => '',
    );
    return $item_data;
}

/*
* Format the addons array so it can be used throughout the addons application
*/
function formatAddonsArray($addons) {
	$array = [];
	// Turn the array into a s tandard addon array
	foreach($addons as $options) {
		foreach($options['available_options'] as $choices) {

			/*
			*	Deal with Single priced addons
			*/
			if(strtolower($choices['single_choice_or_multi_choice']) == "single") {
				// Handle price based on single price
				if(strtolower($choices['pricing_route']) == "single") {
					$tag = "single-single";
					$priceField = "single_price";
				}
				// Handle a price based on percentage
				if(strtolower($choices['pricing_route']) == "percentage of stating price") {
					$tag = "single-percent";
					$priceField = "price_per_percentage";
				}
				// Handle a price based on length
				if(strtolower($choices['pricing_route']) == "based on size length") {
					$tag = "single-length";
					$priceField = "price_per_length";
				}
				// Handle a price based on size squared
				if(strtolower($choices['pricing_route']) == "based on size squared") {
					$tag = "single-squared";
					$priceField = "price_per_sq_m";
				}
				$title = vgc_sm_replace(strtolower(str_replace(' ', '-', $options["title_of_area"].':'.$choices['name'])));
				$key = $tag."-addon-".$title;
				$uniqueKey = checkForDuplicateKey($key, $array);
				$array[$uniqueKey] = $choices[$priceField];

			}

			/*
			*	Deal with Multi priced addons
			*/
			if($choices['single_choice_or_multi_choice'] == "multi") {
				// Define the array price tag by the pricing route
				if(strtolower($choices['pricing_route']) == "single") {
					$tag = "single";
				}
				if(strtolower($choices['pricing_route']) == "percentage of stating price") {
					$tag = "percent";
				}
				if(strtolower($choices['pricing_route']) == "based on size squared") {
					$tag = "squared";
				}
				if(strtolower($choices['pricing_route']) == "based on size length") {
					$tag = "length";
				}
				$key = "multi-".$tag."-addon-".strtolower(str_replace(' ', '-', $options["title_of_area"].':'.$choices['name']));
				$uniqueKey = checkForDuplicateKey($key, $array);
				$array[$uniqueKey] = $choices['options'];
			}
		}
	}
	return $array;
}

/*
* Function to check for duplicate addon names in the addon.php template
*/
function checkForDuplicateValue($key, $array) {
	// If the key is found in the array
  if(in_array($key, $array)) {
    $i = 1;
		// add +1 until we find a unique array key
    while(in_array($key, $array)) {
      $key = $key."-".$i;
      $i++;
    }
  }
  return $key;
}

/*
* Function to check for duplicate addon names in the addon.php template
*/
function checkForDuplicateKey($key, $array) {
	// If the key is found in the array
  if(array_key_exists($key, $array)) {
    $i = 1;
		// add +1 until we find a unique array key
    while(array_key_exists($key, $array)) {
      $key = $key."-".$i;
      $i++;
    }
  }
  return $key;
}


/*
* Add the square meter custom field to woocommerece product admin page
*/
function addSquareMeterToProductPageAdmin() {

	global $woocommerce, $post;
	echo "<div class='product-square-meter'>";
	woocommerce_wp_text_input(
		array(
			'id'          => '_square_meter',
			'value'       => get_post_meta($post->ID, '_square_meter', true),
			'label'       => __( 'Product Size:', 'woocommerce' ),
			'placeholder' => 'Enter the Products Size in Square Meter',
			'desc_tip'    => true,
			'description' => __( 'Products Size: Square Meter', 'woocommerce' ),
			'type'        => 'text',
			'data_type'   => 'decimal',
		)
	);
	echo "</div>";

}


/*
* Deal with saving the product size custom field
*/
add_action('woocommerce_process_product_meta', 'woocommerceProcessCustomFields');

function woocommerceProcessCustomFields($post_id) {

	$sizeInSqM = (float) esc_attr($_POST['_square_meter']);
	if(!empty($sizeInSqM)) {
		update_post_meta($post_id, '_square_meter' , $sizeInSqM);
	}

}

/*
* Enqueue admin scripts
*/
add_action('admin_enqueue_scripts', 'my_enqueue');

function my_enqueue($hook) {
    wp_enqueue_script('my_custom_script', get_template_directory_uri() . '/vgc_copy.js');
}

/*
* Add description
*/
function calc_vgc_price($options,$length,$width,$base_price,$price_override) {
	$pricing_model = $options["pricing_route"];
	if($pricing_model === "Single")
	{
		if(isset($price_override))
		{
			$price = $price_override;
		}
		else
		{
	    	$price = $options['single_price'];
	    }
	}              
	//based on size squared..... (width x length in ft....)	              
	if($pricing_model === "Based on size squared")
	{	  
	    if(!empty($width) && !empty($length))
	    {
			if(isset($price_override))
			{
				$base = $price_override;
			}
			else
			{
				$base = $options['price_per_sq_m'];			
			}
	        $price = $base * (($length) * ($width));
	        $price = number_format((float)$price, 2, '.', '');
	    }
	    else
	    {
	        $price = "ERROR";
	    }		              
	}
	//based on length
	if($pricing_model === "Based on size length")
	{	
	    if(!empty($length))
	    {
		  if(isset($price_override))
		  {
		  	$base = $price_override;
		  }
		  else
		  {
		  	$base = $options['price_per_length'];			
		  }		    
		    
	      //convert inches to feet as priced per ft in length
	  	  //$price = ($length/ 12) * $base;
	  	  $price = ($length) * $base;
	  	  $price = number_format((float)$price, 2, '.', '');
	    }
	    else
	    {
	        $price = "ERROR";
	    }
	}	              
	//Percentage of stating price
	if($pricing_model === "Percentage of stating price")
	{		  
		if(isset($price_override))
		{
		  $base = $price_override;
		}
		else
		{
		  $base = $options['price_per_percentage'];			
		}	
	    $price = $base_price * ($base/100);
	    $price = number_format((float)$price, 2, '.', ''); 
	}	
	return $price;

}


/*
* Removes any unwanted characters
*/
function vgc_sm_replace($string)
{
	$string = preg_replace("/[^a-zA-Z0-9 :-]/", "", $string);	
	return $string;
}

function getKeyForStart($options)
{
	$pricing_model = $options["pricing_route"];
	if($pricing_model === "Single")
	{
		$key = "single";
	}	              
	//based on size squared..... (width x length in ft....)	              
	if($pricing_model === "Based on size squared")
	{	  
		$key = "squared";
	}
	//based on length
	if($pricing_model === "Based on size length")
	{	
		$key = "length";		
	}	              
	//Percentage of stating price
	if($pricing_model === "Percentage of stating price")
	{		  
		$key = "percent";		
	}	
	return $key;	
}

/*
* Handle allowing bases to be displayed 
*/
function showProductBases($terms = array()) : array {

	$showBase = false;
	$baseType = array();
	foreach($terms as $term) {
		if(strtolower($term->slug) == "summerhouses" || strtolower($term->slug) == "garden-offices" || strtolower($term->slug) == "log-cabin" || strtolower($term->slug) == "garages-carriage-houses") {
			$showBase = true;
			$baseType[] = 'Concrete';
		}
		if(strtolower($term->slug) == "sheds" || strtolower($term->slug) == "workshops") {
			$showBase = true;
			$baseType[] = 'Concrete';
			$baseType[] = 'Wooden';
		}
		if(strtolower($term->slug) == "greenhouses" || strtolower($term->slug) == "potting-sheds") {
			$showBase = true;
			$baseType[] = 'Concrete';
			$baseType[] = 'Brick';
		}
	}
	return array(
		'show' => $showBase,
		'bases' => array_unique($baseType),
	);
}


/*
* Calculate base size

function getBaseTypePriceFromGlobalOptions($productLength, $productWidth, $baseTypes = array(), $postcodeBand) : array 
{
	// Calculate the square feet of the base
	$baseSqFeet = $productLength * $productWidth;
	// If the base sq feet is above 48 we get the higher price tier
	if($baseSqFeet > 48) {
		$key = "48 sq ft +";
	} else {
		$key = "Under 48 sq ft";
	}
	// Get the data from the global options table
	$globalOptionsTable = get_field('product_bases', 'options');
	// Set the band by the postcode
	$band = "band_".$postcodeBand."_price";
	// Get the right price from the table
	$basePrices = array();
	// For each of the base types available
	foreach($baseTypes['bases'] as $baseType) {
		// Loop through the table and locate the price
		foreach($globalOptionsTable as $index => $value) {
			if($value['base_material'] == $baseType) {
				if($value['base_size'][0] == $key) {
    				// single set prices for a base .... 
    				// it's price pr sq ft
					// $basePrices[$baseType] = $globalOptionsTable[$index][$band];					
					$basePrices[$baseType] = $globalOptionsTable[$index][$band]*$baseSqFeet;
				}
			}
		}
	}
	return $basePrices;
}
*/
function getBaseTypePriceFromGlobalOptions($productLength, $productWidth, $postcodeBand, $terms) : array 
{
	// Calculate the square feet of the base
	$baseSqFeet = $productLength * $productWidth;
    
    //which price are we going to use
	if($baseSqFeet < 17) {
      $key = "under_16";
	}
	if($baseSqFeet >= 17 && $baseSqFeet <=47) {
      $key = "17_47";
	}
	if($baseSqFeet >= 48 && $baseSqFeet <=71) {
      $key = "48_71";
	}
	if($baseSqFeet >= 72 && $baseSqFeet <=120) {
      $key = "72_120";
	}
	if($baseSqFeet >= 121) {
      $key = "over_121";
	}				
	
	//check our terms	
    $isGreenHouse = false;
    $isLogCabin = false;    
	
    foreach($terms as $term) {
        if(strtolower($term->slug) == "log-cabin") {
            $isLogCabin = true;
        }	
        if(strtolower($term->slug) == "greenhouses") {
            $isGreenHouse = true;
        }   
    }
	
	//greenhouse_only
	//everything_except_greenhouses_and_log_cabins		
		
	// Get the data from the global options table
	$globalOptionsTable = get_field('bases', 'options');

	// Get the right price from the table
	$bases = array();
	
    if( $globalOptionsTable ) {
        foreach( $globalOptionsTable as $row ) {
            
            $inc = true;
            
            if(($row['greenhouse_only']==true) && ($isGreenHouse != true))
            {
                $inc = false;
            }
            if(($row['everything_except_greenhouses_and_log_cabins'] == true) && ($isLogCabin || $isGreenHouse))
            {
                $inc = false;
            }

            if($inc == true) {
                
                $cost = 0;
                
                //work out cost in sq ft.
                $cost = $row[$key] * $baseSqFeet;
                
                if($postcodeBand == 2)
                {
                    //add the band_2_surcharg
                	$cost = $cost + $row['band_2_surcharge'];
                }
                if($postcodeBand == 3)
                {
                    //add the band_3_surcharg
                    $cost = $cost + $row['band_3_surcharge'];
                }     
                
                //var_dump($row);
                //die();      
                
                $bases[] = array(
                    'title' => $row['title'],
                    'image' => $row['image']['url'],                
                    'description' => $row['description'],
                    'cost' => number_format((float)$cost, 2, '.', '')                
                );
            }
        }        
    }	

	return $bases;
}

/*
* Make product dimensions required
*/

add_action( 'admin_head', 'wc_require_product_dimensions' );

function wc_require_product_dimensions() {
	$screen         = get_current_screen();
	$screen_id      = $screen ? $screen->id : ''; 
	if ( $screen_id == 'product' ) {
?>

<script>
	jQuery(document).ready(function(jQuery) {
		jQuery('#product_length').prop('required', true);
		jQuery('#product_width').prop('required', true);
		jQuery('#publish').on( 'click', function() {
			var pLength = jQuery.trim(jQuery('#product_length').val());
			var pWidth = jQuery.trim(jQuery('#product_width').val());
			// Dont allow shipping dimensions to be empty or 0
			if ( pLength == '' || pLength == 0 || pWidth == '' || pWidth == 0 ) {
				alert( 'Shipping dimensions cannot be empty');
				jQuery( '.shipping_tab > a' ).click();  // Click on 'Shipping' tab.
				jQuery( '#mceu_91' ).focus();
				return false;
			}
		});
	});
</script>

<?php
	}
}

// Removes the BR in the order emails
add_filter( 'woocommerce_order_item_name', 'wooRemoveBRInOrderEmails', 20, 3 );

function wooRemoveBRInOrderEmails( $item_name, $item, $is_visible ) {

    return str_replace('<br>', '', $item_name);
}




add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 4; // 3 products per row
	}
}


