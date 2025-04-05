<?php
/**
 * Delivery is the same price for all destinations.
 * We don't need to set delivery_band classes.
 *
 * But we need to tell the server which delivery band has been set
 * and the delivery value.
 */

//$deliveryStatus = get_query_var('deliveryStatus');
$ppq = get_query_var('ppq');

$delivery = $ppq->deliveryBandPrice( 0 );
$ppq->defineNationwideDeliveryConst();

?>
<div class="section-addon-wrap main " >


	<div class="section-options pb-4 pt-4 addon-select addon-select-radio ">
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
              <div class="addon-details">

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

                        if( $brand_name && isset( $brand_name[0] ) && $brand_name[0]->post_title == "Eden Greenhouses")
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
                    <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="regardless" value="<?php echo $delivery; ?>"/>
                  <span class="checkmark"></span>
                </label>
                  <input type="hidden" name="delivery_band" value="delivery_band_not_set" id="delivery_band" />

            </div>


            </div>
        </div>
        </div>
    </div>



</div>

