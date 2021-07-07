<?php

class calculate_price {
	
	private $choosen = null;
	private $addons = null;
  	private $productPrice = null;
  	private $productLength;
  	private $productWidth;
  	private $productId;
  	private $deliveryCost;
  	private $customPrice;  	
  
  function __construct(
  	$choosen, 
  	$addons, 
  	$productPrice = null,
  	$productLength = null, 
  	$productWidth = null, 
  	$productId = null,
  	$deliveryCost = null) {
    // The inputted postcode to determine the returned options
    if(!empty($choosen)) : $this->choosen = $choosen; endif;
    // The provided data from the product global array
    if(!empty($addons)) {
	  $tmpArray = array();
	  foreach($addons as $key => $value) {
		  $tmpArray[vgc_sm_replace($key)] = $value;
	  } 
	  $this->addons = $tmpArray;   
    }
    // The inputted postcode to determine the returned options
    if(!empty($productPrice)) : $this->productPrice = $productPrice; endif; 
    // Set the products length
    if(!empty($productLength)) : $this->productLength = (float) $productLength; endif;
    // Set the products width
    if(!empty($productWidth)) : $this->productWidth = (float) $productWidth; endif;
    // Set the product ID
    if(!empty($productId)) : $this->productId = $productId; endif;
    // Set the delivery Price
    if(!empty($deliveryPrice)) : $this->deliveryPrice = $deliveryPrice; endif;
    // Start calculating the price
    $this->calculatePrice();
  }

  /*
  * Calculate the price before checkout
  
    We've moved the below out of calculate_price_on_cart_addition
    and int here as we wat the title fo the itme AND the price in a niceley lined up title
  
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
  
  

  
  
  
  
  
  
  
  
  */
  
  public function calculatePrice() : void {

	    // Get the base price
	    $this->customPrice = $this->productPrice;
	    $this->customBasket = array();
	   	
	    foreach($this->choosen as $key => $value) {
	    	/*
			*  Handle the multi price addons
			*/
			$value = str_replace("\\","",$value);
			
			
			if(substr($key, 0, 5) == "multi") {	
				// Make sure the addon is an array / multi options field
				if(is_array($this->addons[$key])) {
					// Loop through the options and get the price for the addon that has been choosen
					foreach($this->addons[$key] as $option) {
    					
    					//echo($option['name']);
    					//echo("--");    					
    					//echo($value);    					
    					
						if($option['name'] == $value) {
							if(substr($key, 0, 12) == "multi-single") {
								$this->customPrice += $option['price'];
								$this->customBasket[] = "<div><strong>".$value."</strong> <span class='addon__cost'>£".to_decimal($option['price'])."</span></div>";  
							}
							if(substr($key, 0, 13) == "multi-squared") {
								$price = ($option['price'] * ($this->productLength * $this->productWidth));
								$this->customPrice += $price;
								$this->customBasket[] = "<div><strong>".$value."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>"; 
							}
							if(substr($key, 0, 12) == "multi-length") {
								$price = $option['price'] * $this->productLength;
								$this->customPrice += $price;
								$this->customBasket[] = "<div><strong>".$value."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>"; 
							}
							if(substr($key, 0, 13) == "multi-percent") {
								$price = ($option['price'] / 100) * $this->productPrice;
								$this->customPrice += $price;
								$this->customBasket[] = "<div><strong>".$value."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>"; 
							}
						}
						else
						{
    						//throw new Exception("Error Processing Request", 1);
						}
					}
					
					//die();
					
				} else {
					// Stop the process if the options are not an array, something has gone wrong
					throw new Exception("Error Processing Request", 1);
				}
			} else {
				/*
				*  Handle the single price addons
				*/
				$title = cleanKey2($key, $value);
				
				if(substr($key, 0, 13) == "single-single" && $value == "true") {
    				
					$this->customPrice += (float) $this->addons[$key];
					$this->customBasket[] = "<div><strong>A".$title."</strong> <span class='addon__cost'>£".to_decimal($this->addons[$key])."</span></div>";  
				}
				if(substr($key, 0, 13) == "single-length" && $value == "true") {
					$price = $this->addons[$key] * ($this->productLength);					
					$this->customPrice += $price;
					$this->customBasket[] = "<div><strong>B".$title."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>";  
				}
				if(substr($key, 0, 14) == "single-squared" && $value == "true") {
					$price = $this->addons[$key] * ($this->productLength * $this->productWidth);
					$this->customPrice += $price;
					$this->customBasket[] = "<div><strong>C".$title."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>";  
				}	
				if(substr($key, 0, 14) == "single-percent" && $value == "true") {
					$price = ($this->addons[$key] / 100) * $this->productPrice;
					$this->customPrice += $price;
					$this->customBasket[] = "<div><strong>D".$title."</strong> <span class='addon__cost'>£".to_decimal($price)."</span></div>";  
				}
			}

			// Handle the base price
			if(substr($key, 0, 9) == "base-type") {
    			
    			//get options from optiosn arrea
                $globalOptionsTable = get_field('bases', 'options');
                
                //sq footage
                $baseSqFeet = ($this->productLength * $this->productWidth);
                $origionalBaseSqFeet = $baseSqFeet;

                //base size is inceased do to veranada or something 
                $base_extra = filter_var($_POST['base_extra'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); 
                
                //var_dump($base_extra);
                //die();
                //string(2) "24"  so exta 24
                
                //string(2) "10" ddddstring(1) "4" ddstring(1) "3" ddstring(1) "2" ddfloat(72) dd
                //var_dump($baseSqFeet);   // 48             

                //add extra sq ft if porch or similar
                $baseSqFeet = $baseSqFeet + $base_extra;
                
                //var_dump($baseSqFeet); // now 72
                //die();                
                
                //posted value... TODO 
                $postcodeBand = (int) filter_var($_POST['b'], FILTER_SANITIZE_NUMBER_INT);
                
                
                //loop it
                foreach($globalOptionsTable as $row)
                {   

                    if(trim($value) == trim(strtolower($row["title"])))
                    {   
                        if($origionalBaseSqFeet < 17) {
                          $key_temp = "under_16";
                    	}
                    	if($origionalBaseSqFeet >= 17 && $origionalBaseSqFeet <=47) {
                          $key_temp = "17_47";
                    	}
                    	if($origionalBaseSqFeet >= 48 && $origionalBaseSqFeet <=71) {
                          $key_temp = "48_71";
                    	}
                    	if($origionalBaseSqFeet >= 72 && $origionalBaseSqFeet <=120) {
                          $key_temp = "72_120";
                    	}
                    	if($origionalBaseSqFeet >= 121) {
                          $key_temp = "over_121";
                    	}   
                    	
                        // price per sq ft                     	
                    	$price_per_ft = $row[$key_temp];                  	
                    	
                    	//the cost based on per sq ft..
                    	$cost = $price_per_ft * $baseSqFeet;   
                    	
                        //additioanl postcode band costs
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
                        
                        //var_dump($cost);
                        $this->customPrice += $cost; 
                 		$this->customBasket[] = "<div><strong>".ucwords($value)."</strong> <span class='addon__cost'>£".to_decimal($cost)."</span></div>";                         
                    } 
                    

                }
                //echo("<br>");                
      			//echo("end base....");
      			//die();
			}
			

			// Handle installation costs
			// this is here ad we dont trust costs being passed
			// so need t0 recalculate here too......
    		if($key == "installation" && $value == "yes") {
         		
        		$installCost = get_field('installation_cost', $this->productId);
        
        		// $installCost = get_field('install_cost_per_sq_ft','options');
                // 
        		// //from the brand we can get the brand speicifci override cost
        		// //step 1 - get the brand
        		// $brand = get_field('brand',$this->productId);
                // 
                // //step 2 - 
                // // is there a brand specific install cost
                // $brandInstallCost  = get_field('installation_cost_override', $brand[0]->ID); 
                // 
                // if($brandInstallCost)
                // {
                //     $installCost = $brandInstallCost;
                // }          		
                // 
                // // price is per sq ft
                // $installCost = floatval($installCost) * ($this->productLength * $this->productWidth);       		

        		$this->customPrice += $installCost;
        		$this->customBasket[] = "<div><strong>Installation:</strong> <span class='addon__cost'>£".to_decimal($installCost)."</span></div>";
            }
            
            //2 type now
            //building_removal_removal-of-greenhouses
            //building_removal_removal-and-taking-away-of-timber-building
            
            if(substr($key, 0, 16) == "building_removal" && $value != "") {
                
                //var_dump($value); // == Removal of Greenhouses 4 x 8 
                //var_dump($key); //== building_removal_removal-of-greenhouses
                //die();
                
                $globalOptionsTable = get_field('buildings', 'options');
                $temp_key = str_replace("building_removal_", "", $key);
                
                foreach($globalOptionsTable as $row)
                {
                    if($temp_key == sanitize_title($row["title"]))
                    {
                        $temp_name = str_replace($row["title"],"", $value);
                        $temp_name = trim($temp_name);
                        $pieces = explode("x", $temp_name);
                        
                        $width = trim($pieces[0]) * 1;
                        $height = trim($pieces[1]) * 1;

                        $sqft = $width * $height;
                        
                        if($sqft <= 16)
                        {
                           $cost = $row["under_16"] * $sqft;  
                        }
                        if($sqft >= 17 && $sqft <= 47)
                        {
                            $cost = $row["17_47"] * $sqft;
                        }
                        if($sqft >= 48 && $sqft <= 71)
                        {
                            $cost = $row["48_71"] * $sqft;
                        }
                        if($sqft >= 72 && $sqft <= 120)
                        {
                            $cost = $row["72_120"] * $sqft;
                        }                                                
                        if($sqft >= 121)
                        {
                            $cost = $row["over_121"] * $sqft;
                        } 
                        
                        //$cost = number_format((float)$cost, 2, '.', '');                        
                        $this->customPrice += $cost;
                        $this->customBasket[] = "<div><strong>".$value.":</strong> <span class='addon__cost'>£".to_decimal($cost)."</span></div>";
                    }
                }                
            }

      		/* Handle building removal csots
	      	if($key == "building_removal" && $value != "") {
	        	$removal_costs = get_field('removal_costs','option');
	        	foreach($removal_costs as $removal) {
    	        	if(trim($removal["building_size"]) == trim($value)) {
	          			$this->customPrice += ($removal["cost"]*1);
	          		}
	        	}
	      	}
	      	*/

	      	// Handle delivery costs
	      	if($key == "delivery" && $value != "no") {
	      		$brandRelation = get_field('brand', $this->productId);
	      		if(!empty($brandRelation)) {
		            if($value == 0) {
		                $delivery_cost = get_field('delivery_cost', $brandRelation[0]->ID);   
		            }
		            if($value == 1) {
		               $delivery_cost = get_field('delivery_cost_band_1', $brandRelation[0]->ID); 
		            }
		            if($value == 2) {
		               $delivery_cost = get_field('delivery_cost_band_2', $brandRelation[0]->ID); 
		            }
		            if($value == 3) {
		               $delivery_cost = get_field('delivery_cost_band_3', $brandRelation[0]->ID); 
		            }
		            if($value == 4) {
		              $delivery_cost = get_field('delivery_cost_band_4', $brandRelation[0]->ID);  
		            }
	            	$this->customPrice += ($delivery_cost*1);
	            	$this->customBasket[] = "<div><strong>Delivery:</strong> <span class='addon__cost'>£".to_decimal($delivery_cost).'</span></div>';
	    		}        
	      	}
  		}
  	}

  /*
  * Getters
  */
  public function getCustomPrice() : float {
    return (float) $this->customPrice;
  }
  
  public function getCustomCartDescriptions() : array {
    return (array) $this->customBasket;
  }  
}