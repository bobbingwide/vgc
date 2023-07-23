<?php 
//$deliveryStatus = get_query_var('deliveryStatus');
$ppq = get_query_var('ppq');

//if ($deliveryStatus) :
//	$delivery = $ppq->getDeliveryCost();
?>
<div class="section-addon-wrap delivery delivery_band_not_set" id="delivery_wrapper">
    <div class="section-options pb-4 pt-4 delivery delivery_band_not_set">
        <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
            <?php the_field('delivery_title','options'); ?>
        </h3>
        <p class="text-center">Please enter the first part of your postcode (e.g. GU33) to check delivery options.</p>

    </div>

    <div class="section-options pb-4 pt-4 delivery delivery_excluded">
        <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
            <?php the_field('delivery_title','options'); ?>
        </h3>
        <h2 style="padding: 40px;text-align: center;font-weight: bold;">Sorry we cannot supply this to your location, please call us to discuss your options
        </h2>
    </div>

    <?php
    // Don't support delivery to band 0 when the price is not set.
    // But we will deliver to all other bands as if the price were 0.
    $delivery = $ppq->deliveryBandPrice( 0 );
    $start_band = 0;
    if ( null === $delivery ) {
        $start_band = 1;

        ?>
        <div class="section-options pb-4 pt-4 delivery delivery_band_0">
            <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
                <?php the_field('delivery_title','options'); ?>
            </h3>
            <h2 style="padding: 40px;text-align: center;font-weight: bold;">Sorry we cannot supply this to your location, please call us to discuss your options</h2>
        </div>
    <?php
    }

    $bandcodes = 'delivery';
    for ( $band = $start_band; $band<= 4; $band++ ) {
        //$delivery = $ppq->deliveryBandPrice( $band);
        $bandcodes .= ' delivery_band_' . $band;
    }
    ?>
	<div class="section-options pb-4 pt-4 baddon-select-required addon-select-radio <?php echo $bandcodes;?> ">
		<h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
         <?php the_field('delivery_title','options'); ?>
        </h3>
        <div style="text-align: center">
        <?php 
            the_field('delivery_options','options'); 
        ?>
        </div>
        <div>
      	<div class="d-flex flex-wrap">
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="https://www.gardenvista.co.uk/wp-content/uploads/2020/01/delivery.png" style="width: 100%;height: auto;padding: 20px;" />
              </div>
                <?php
                    //$start_band = ( null === $delivery) ? 1: 0;
                    for ( $band = $start_band ; $band<= 4; $band++ ) {
                        $delivery = $ppq->deliveryBandPrice( $band);
                        $bandcode = ' delivery delivery_band_' . $band;
                        echo '<div class="addon-details' . $bandcode . '">';
              ?>
                <p class="fw-bold mb-0 addon-name"><?php the_field('add_delivery','options');?></p>
                <div class="addon-price d-flex pb-4">
                 <?php
                    // If delivery is free, or null
                    if ($delivery == 0 ) {
                        bw_trace2( $delivery, "delivery", false);
                    ?>    
                    <div>
                        <?php 
                        $brand_name = get_field('brand');
                        
                        if($brand_name[0]->post_title == "Eden Greenhouses")
                        {
                            echo("FREE delivery to mainland UK and Northern Ireland");                           
                        }
                        else
                        {
                            the_field('free_delivery','options');
                        }
                        ?>
                    </div>
                    <div class="price" style="opacity: 0">
                    0
                    </div>                        

                    <?php                        
                    }
                    else
                    {
                    ?>                        
                    <div>+ £</div>
                    <div class="price">  
                        <?php echo $delivery; ?>                      
                    </div>

                    <?php
                    }
                    ?>
                </div>
                <label class="checkbox-container">
                    <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="delivery" >
                  <span class="checkmark"></span>
                </label>

            </div>
                <?php
                }

                    ?>

            </div>
        </div>
        </div>
    </div>



</div>
