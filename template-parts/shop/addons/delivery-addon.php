<?php 
$deliveryStatus = get_query_var('deliveryStatus');
$ppq = get_query_var('ppq');

if ($deliveryStatus) :
	$delivery = $ppq->getDeliveryCost();        
?>
<div class="section-addon-wrap">
	<div class="section-options pb-4 pt-4 addon-select-required addon-select-radio">
		<h3 class="w-100 clearfix font-weight-bold mb-0 h5 font-colour-primary text-center toggle-next">
         <?php the_field('delivery_title','options'); ?>
        </h3>
        <div style="text-align: center">
        <?php 
            the_field('delivery_options','options'); 
        ?>
        </div>
      <div>
      	<div class="d-flex flex-wrap">
      		<?php
            if($delivery != 0) {
            ?>              
            <!--
            Click and Collect
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="https://www.gardenvista.co.uk/wp-content/uploads/2020/01/delivery.png" style="width: 100%;height: auto;padding: 20px;" />
              </div>
              <div class="addon-details">
                <p class="font-weight-bold mb-0 addon-name"><?php the_field('no_delivery','options');?></p>
                <div class="addon-price d-flex pb-4">
                  <div>+ £</div>
                  <div class="price">
                    0
                  </div>
                </div>
                <label for="size" class="checkbox-container">
                  <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="delivery" value="no" checked>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>
            -->
            <?php
            }
            ?>
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="https://www.gardenvista.co.uk/wp-content/uploads/2020/01/delivery.png" style="width: 100%;height: auto;padding: 20px;" />
              </div>
              <div class="addon-details">
                <p class="font-weight-bold mb-0 addon-name"><?php the_field('add_delivery','options');?></p>
                <div class="addon-price d-flex pb-4">
                    <?php
                    // If delivery is free
                    if($delivery == 0)   
                    {
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
                <label for="size" class="checkbox-container">
                  <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" onclick="addAddonToCart(event, 'checkbox')" name="delivery" value="<?php echo($ppq->getDeliveryType());?>">
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  <?php endif; ?>