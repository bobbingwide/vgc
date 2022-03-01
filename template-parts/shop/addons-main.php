<?php 
    
$product = get_query_var('product');
$addons = get_query_var('addons');
$ppq = get_query_var('ppq');
$installCost = get_query_var('installCost');
$installationStatus = get_query_var('installationStatus');
$deliveryStatus = get_query_var('deliveryStatus');
$length = $product->get_length();
$width = $product->get_width();
$record = [];
?>

<?php foreach ($addons as $addon) : ?>
  <div class="section-addon-wrap">
    <div class="section-options pb-4 pt-4 <?php echo $addon['required_addon'] == true ? "addon-select-required" : "addon-select addon-non-required"; ?>  <?php echo $addon['allow_only_one_choice_eg_if_choosing_a_colour'] == true ? "addon-select-radio" : "" ; ?>">
      <h3 class="w-100 clearfix font-weight-bold mb-0 h5 font-colour-primary text-center toggle-next">
        <?php echo $addon['title_of_area']; ?>
        <?php echo $addon['required_addon'] == true ? "*" : ""; ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/down-arrow-blue.png" alt="icon" class="ml-4">
          </h3>
          <div class="section-addon-wrap__inner">
            <?php if(!empty($addon['optional_description'])) { ?>
              <div style="padding: 0 1rem 1rem 1rem">                
                <p class="w-100 clearfix font-colour-primary">
                  <?php echo $addon['optional_description']; ?>
                </p>
              </div>
            <?php } ?>
            <div class="d-flex flex-wrap">
              <?php $options = $addon['available_options']; ?>
              <?php $count = count($options); ?>
              <?php for($i = 0; $i < $count; $i++) { ?>
                <div class="p-5 block text-center">
                  <div class="thumbnail">
    	            <?php
    		        $cl = "";    
                if(!empty($addon["scale_images"])) {
    			       if($addon["scale_images"] == true) {
    					     $cl = "cover";     
    			       }		       
    		        }
                ?>  
                <img class="<?php echo($cl);?>" src="<?php echo !empty($options[$i]['image']) ? $options[$i]['image'] : get_template_directory_uri() . "/images/placeholder-image.jpg"; ?>" />
                  </div>
                  <div class="addon-details">
                    <p class="font-weight-bold mb-0 addon-name">
                      <?php echo $options[$i]['name']; ?>
                    </p>
                    <?php $key_bit = getKeyForStart($options[$i]);
                    if($options[$i]['single_choice_or_multi_choice'] == "single") {
      	              $length = $product->get_length();
      	              $width = $product->get_width();	              
      	              $base_price = $product->get_price();
      	              $price = calc_vgc_price($options[$i], $length, $width, $base_price,NULL);
                      ?>
                      <div class="addon-price d-flex pb-4">
                        <div>+ £</div>
                        <div class="price"><?php echo $price ?></div>
                      </div>
                      <!-- Define the value for the checkbox -->
                      <?php $inputValue = "single-".$key_bit."-addon-".strtolower(str_replace(' ','-', vgc_sm_replace($addon['title_of_area']) . ':' . vgc_sm_replace($options[$i]['name']))); ?>
                      <label for="size" class="checkbox-container">
                        <!-- Lets check to make sure we are not duplicating the checkbox name -->
                        <?php $inputValue = checkForDuplicateValue($inputValue, $record); ?>
                        <!-- Keep record of the value -->
                        <?php $record[] = $inputValue; ?>
                        <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="<?php echo $inputValue; ?>" value="true" <?php if($addon['required_addon'] == true && $i == 0) : echo "checked"; endif; ?>>
                        <span class="checkmark"></span>
                      </label>
                      <?php 
                    } else { 
                      ?>
                      <!-- Define the value for the checkbox -->
                      <?php $inputValue = "multi-".$key_bit."-addon-".strtolower(str_replace(' ','-', vgc_sm_replace($addon['title_of_area']) . ':' . vgc_sm_replace($options[$i]['name']))); ?>
                      <p class="options__select">
                      <!-- Lets check to make sure we are not duplicating the checkbox name -->
                      <?php $inputValue = checkForDuplicateValue($inputValue, $record); ?>
                      <!-- Keep record of the value -->
                      <?php 
                        $record[] = $inputValue;	              
                        $base_price = $product->get_price();
                        echo vgc_option_select( $inputValue, $product, $options[$i] );
                      ?>
                      </p>
                      <?php } ?>
                      <?php if(!empty($options[$i]['description'])) { ?>
                    <div style="padding: 3rem 1rem 1rem 1rem"> <p class="w-100 clearfix font-colour-primary"><?php echo $options[$i]['description']; ?></p></div>
                    <?php } ?>                
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
<?php endforeach; ?>

<input type="hidden" name="base_extra" id="base_extra" value="0" />

<!-- Get the section for removal addons -->
<?php 
set_query_var('ppq', $ppq);
get_template_part('/template-parts/shop/addons/removal', 'addon');
?>

<!-- Get the section for installation addons -->
<?php 
set_query_var('ppq', $ppq);
set_query_var('installCost', $installCost);
set_query_var('productLength', $length);
set_query_var('productWidth', $width);
set_query_var('installationStatus', $installationStatus);
get_template_part('/template-parts/shop/addons/installation', 'addon');
?>

<!-- Get the section for base addons -->
<?php
set_query_var('ppq', $ppq);
set_query_var('productLength', $length);
set_query_var('productWidth', $width);
get_template_part('/template-parts/shop/addons/base', 'addon');
?>
  
<!-- Get the section for delivery addons -->
<?php
set_query_var('ppq', $ppq);
set_query_var('deliveryStatus', $deliveryStatus);
get_template_part('/template-parts/shop/addons/delivery', 'addon');


