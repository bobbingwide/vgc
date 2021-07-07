<?php

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

  function __construct($postcode, $options_allowed) {
    // The inputted postcode to determine the returned options
    if(!empty($postcode)) : $this->postcode = $postcode; endif;
    if(!empty($options_allowed)) : $this->options = $options_allowed; endif;         
    $this->runCheck();
  }

  /*
  * Start the process
  */
  public function runCheck() : void {
    // Define the accepted postcodes
    $this->setAcceptedPostcodes();
    // Define the excluded postcodes
    $this->setExcludedPostcodes();
    //so can we orrde this?
    $this->canOrder();
  	//no point moving forward if cant order at this point.......
  	if($this->canOrder == true) {
  	   // Check if the postcode in question is in ONE of the accepted postcodes array
  		$this->checkPostcode();
  		// so what is the delivery cost?
  		$this->calculateDeliveryAddon();
  		// so what is instllation cost
  		$this->calculateInstallationAddon();			
  		// so what is removal cost
  		$this->calculateRemovalAddon();
      }
  }
  
  /*
  * Set excluded postcodes
  */
  private function setExcludedPostcodes() : void {  
    $this->excludedPostcodes = array_map('trim', explode("\n", $this->options["postcode_excluded"]));
  }
  
  /*
  * Set accepted postcodes
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
      	$this->deliveryCost = $this->options["delivery_cost"][1]; $this->deliveryAccepted = true;
      	$this->deliveryType = 1;
      	}
    }
  	if($this->postcodeBand == 2) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][2]; $this->deliveryAccepted = true;
      	$this->deliveryType = 2;
      	}
    }
  	if($this->postcodeBand == 3) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][3]; $this->deliveryAccepted = true;
      	$this->deliveryType = 3;
      	}
    }
  	if($this->postcodeBand == 4) {
      	if($this->options["delivery_cost"][1]) {
      	$this->deliveryCost = $this->options["delivery_cost"][4]; $this->deliveryAccepted = true;
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
    return $this->deliveryCost;
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
}