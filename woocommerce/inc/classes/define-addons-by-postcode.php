<?php
/**
 * @copyright Bobbing Wide 2023
 *
 * Notes regarding to Post code related options for VGC 2.0.0
 *
 * This class used to contain methods that determined the availability / price of addons based on the postcode band.
 * The logic to determine availability / price is now implemented in the browser.
 * But there are still methods that are required for the server code to deliver the required information for the templates.
 * These templates now produce HTML which is displyed or hidden based on the postcode band.
 * Functions which used to check the postcode band need to be rewritten to provide the values for each postcode band.
 * The array of prices starts from 0, which is the postcode band for 'rest of the UK'.
 * Templates can extract the right value from these arrays.
 *
 * @TODO Some of the methods in this class are now redundant and should be deleted.
 */

class define_addons_by_postcode
{

  private $deliveryAccepted = false;
  private $postcodeBand = 0;
  private $baseAccepted = false;
  private $installAccepted = false;
  private $removalAccepted = false;      
  private $canOrder = false;    
  private $postcode = null;
  private $options_allowed = null;  
  private $acceptedPostcodes = [];
  private $baseWoodCosts = 0;
  private $baseConcreteCosts = 0;
  private $deliveryCost = 0;

  function __construct($postcode, $options_allowed) {
    // The inputted postcode to determine the returned options
    //  bw_trace2();
    if(!empty($postcode)) : $this->postcode = $postcode; endif;
    if(!empty($options_allowed)) : $this->options = $options_allowed; endif;         
    $this->runCheck();
    $this->enqueue_script();
  }

  function enqueue_script() {
      wp_enqueue_script('vgccodes', get_template_directory_uri() . '/inc/js/vgccodes.js', array(), null , true);
      $data = 'const vgccodes = ';
      $data .= json_encode( [ "postcodes" => $this->acceptedPostcodes,
        "excluded" => $this->excludedPostcodes] );
      /*
          const vgccodes = {
          "postcodes": [['GU1'], ['GU2'], ['PO9'], ['PO30']],
    "excluded": ['AB10'],
    "delivery_band_costs": [0, 0, 0, 0, 0]
};
      */
      wp_add_inline_script( 'vgccodes', $data, 'before');
  }

  /*
  * Start the process
  */
  public function runCheck() : void {
    // Define the accepted postcodes
    $this->setAcceptedPostcodes();
    // Define the excluded postcodes
    $this->setExcludedPostcodes();

    $this->calculateInstallationAddon();
  }
  
  /*
  * Set excluded postcodes
  */
  private function setExcludedPostcodes() : void {
      $this->excludedPostcodes = [];
      //bw_trace2( $this->options['postcode_excluded'], "postcode_excluded" );
      if ( ( isset( $this->options['postcode_excluded'])  )) {
          $this->excludedPostcodes = array_map('trim', explode("\n", $this->options["postcode_excluded"]));
      }
  }
  
  /*
  * Set accepted postcodes.
   *
   * Any postcode that's not in bands 1 to 4 will be treated as band 0,
   * as long as it's not in the excluded postcodes array.
  */
  private function setAcceptedPostcodes() : void {
  	$postcodes_1 = array();
  	$postcodes_2 = array();
  	$postcodes_3 = array();
  	$postcodes_4 = array();			
  	if($this->options["postcode_bands"][0]) {
  		$postcodes_1 = array_map('trim', explode("\n", $this->options["postcode_bands"][0]));		
  	}
  	if($this->options["postcode_bands"][1]) {
  		$postcodes_2 = array_map('trim', explode("\n", $this->options["postcode_bands"][1]));
  	}
  	if($this->options["postcode_bands"][2]) {
  		$postcodes_3 = array_map('trim', explode("\n", $this->options["postcode_bands"][2]));
  	}
  	if($this->options["postcode_bands"][3]) {
  		$postcodes_4 = array_map('trim', explode("\n", $this->options["postcode_bands"][3]));	
  	}
    $this->acceptedPostcodes = array(
      $postcodes_1,
      $postcodes_2,
      $postcodes_3,
      $postcodes_4
    );
  }
  
  /*
  * Check the postcode to workout which band the customer is from
  */
  private function checkPostcode() : void {
    //which postcode nad are they in?
    if(in_array(strtoupper($this->postcode), $this->acceptedPostcodes[0])) {
        $this->postcodeBand = 1;
    }
    if(in_array(strtoupper($this->postcode), $this->acceptedPostcodes[1])) {
        $this->postcodeBand = 2;     
    }
    if(in_array(strtoupper($this->postcode), $this->acceptedPostcodes[2])) {
        $this->postcodeBand = 3;     
    }
    if(in_array(strtoupper($this->postcode), $this->acceptedPostcodes[3])) {
        $this->postcodeBand = 4;     
    }
    // so not in a postcode band and not delivery cost global set it can't be ordered
    if($this->postcodeBand==0 && !(isset($this->options["delivery_cost"][0])))
    {
        //tney can't order sorry
        $this->canOrder = false;
    }
    
    if(isset($this->options["delivery_cost"][0]))
    {
        if($this->options["delivery_cost"][0]=="" && $this->postcodeBand==0)
        {
            $this->canOrder = false;  
        }
    }
    
    
    
    
  }
  
  /*
  * Definne if the user can order
  */
  private function canOrder() : void {
    // If the postcode is found in the excluded postcode list NO SALE
    if(in_array(strtoupper($this->postcode), $this->excludedPostcodes)) {
        $this->canOrder = false;
    }
    else
    {
       $this->canOrder = true; 
    }
    
    //also we need to check if the posstcode IS IN a band... as may not be able to order

    
  }

  
  /*
  * Handle delivery costs
  */
  private function calculateDeliveryAddon() : void {
  	if(isset($this->options["delivery_cost"][0])) {
  		$this->deliveryCost = $this->options["delivery_cost"][0];
  		$this->deliveryAccepted = true;
  		$this->deliveryType = 0;
  	}
  	if($this->postcodeBand == 1) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][1];
      	$this->deliveryAccepted = true;
      	$this->deliveryType = 1;
      	}
    }
  	if($this->postcodeBand == 2) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][2];
      	$this->deliveryAccepted = true;
      	$this->deliveryType = 2;
      	}
    }
  	if($this->postcodeBand == 3) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][3];
      	$this->deliveryAccepted = true;
      	$this->deliveryType = 3;
      	}
    }
  	if($this->postcodeBand == 4) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][4];
      	$this->deliveryAccepted = true;
      	$this->deliveryType = 4;
      	}
    }
  }   
  
  /*
  * Handle installation costs
  */
  private function calculateInstallationAddon() : void {
	  if(isset($this->options["installation_cost"]))
	  {   
		  $this->installCosts = intval($this->options["installation_cost"]);
		  $this->installAccepted = true;
 	  }
  }	    
  
  /*
  * Handle removal costs
  * Make sure it is in a valid postcode band
  */
  private function calculateRemovalAddon() : void {
      if($this->postcodeBand!=0)
      {
    	  if(isset($this->options["removal"])) {
    		  $this->removalCosts = $this->options["removal"];
    		  $this->removalAccepted = true;
     	  }
 	  }	  
  }	  
  

  /*
  * Object getters
  */
  public function getCanOrder() : bool {
    return $this->canOrder;
  }      
  public function getDeliveryStatus() : bool {
    return $this->deliveryAccepted;
  }
  public function getDeliveryType() : int {
    return $this->deliveryType;
  }  
  public function getInstallationStatus() : bool {
    return $this->installAccepted;
  }
  public function getRemovalStatus() : bool {
    return $this->removalAccepted;
  } 
  public function getPostcodeBand() : int {
    return $this->postcodeBand;
  }   
  public function getDeliveryCost() : int {
    if ( is_numeric( $this->deliveryCost ) ) {
        return $this->deliveryCost;
    }
    return 0;

  }
  public function getBaseCostConcrete() : int {
    return $this->baseConcreteCosts;  
  }
  public function getBaseCostWood() : int {
    return $this->baseWoodCosts;  
  }  
  public function getInstallationCost() : int {
    return $this->installCosts;
  }
  public function getRemovalCost() : array {
    return $this->removalCosts;
  }

  /**
   * Returns the delivery band price.
   *
   * Should cater for delivery band 0 which doesn't allow
   * delivery when the price isn't set.
   *
   * @param integer $band 0 to 4
   * @return integer|null Delivery band price
   */
  public function deliveryBandPrice( $band ) {
	  //bw_trace2( $this->options["delivery_cost"], "delivery_cost" );
      if (isset( $this->options["delivery_cost"][$band] )) {
          $delivery_band_price = $this->options["delivery_cost"][$band];
		  $delivery_band_price = trim( $delivery_band_price );
		  if ( '' === $delivery_band_price ) {
			  $delivery_band_price = null;
		  }
       } else {
          $delivery_band_price = null;
      }
      //bw_trace2( $delivery_band_price, "delivery_brand_price");
      return $delivery_band_price;
  }

  /**
   * Returns true when Installation should be before Post code section
   *
   * If any delivery price is set for bands 1 to 4 then the Installation section
   * goes after the post code section.
   *
   * @return bool true for installation before, false otherwise
   */
  public function displayInstallationBeforePostcode() :bool {
      $installationBefore = true;
      for ( $band = 1; $band <= 4; $band++ ) {
          $price = $this->deliveryBandPrice( $band );
          if ( $price !== null ) {
              $installationBefore = false;
          }
      }
      return $installationBefore;
  }

}