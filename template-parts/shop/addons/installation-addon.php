<?php
$installCost = get_query_var('installCost');
$installationStatus = get_query_var('installationStatus');
$ppq = get_query_var('ppq');
$productLength = get_query_var('productLength');
$productWidths = get_query_var('productWidth');

// price is per sq ft
//$installCost = floatval($installCost) * ( floatval($productLength) * floatval($productWidths) );

// set manually
$installCost = get_field('installation_cost', $product->ID);




if ($installationStatus == true && isset($installCost)) : ?>
  <?php //$installCost = $ppq->getInstallationCost(); ?>
  <!-- Lets give them the option -->
    <div class="section-addon-wrap">
      <div class="section-options pb-4 pt-4 addon-select-required addon-select-radio">
        <h3 class="w-100 clearfix font-weight-bold mb-0 h5 font-colour-primary text-center toggle-next">
        <?php the_field('installation_title','options'); ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/down-arrow-blue.png" alt="icon" class="ml-4">          
        </h3>
        <div class="section-addon-wrap__inner"> 
            
        <div style="text-align: center; padding-top: 1rem">
        <?php the_field('installation','options'); ?>
        </div>              
                   
        <div class="d-flex flex-wrap">
            <?php
            if($installCost == 0) {
            ?>
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="/wp-content/uploads/2020/01/installation.png" style="padding: 20px;" />
              </div>
              <div class="addon-details">
                <p class="font-weight-bold mb-0 addon-name"><?php the_field('installationf','options'); ?></p>
                <div class="addon-price d-flex pb-4">
                  <div>FREE</div>
                  <div class="price" style="opacity: 0">
                    0
                  </div>
                </div>
                <label for="size" class="checkbox-container">
                  <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="installation" value="yes" checked>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>            
            <?php } else { ?>
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="/wp-content/uploads/2020/01/installation.png" style="padding: 20px;" />
              </div>
              <div class="addon-details">
                <p class="font-weight-bold mb-0 addon-name"><?php the_field('installationn','options'); ?></p>
                <div class="addon-price d-flex pb-4">
                  <div>+ £</div>
                  <div class="price">
                    0
                  </div>
                </div>
                <label for="size" class="checkbox-container">
                  <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" name="installation" value="no" checked>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>
            <div class="p-5 block text-center">
              <div class="thumbnail">
                <img src="/wp-content/uploads/2020/01/installation.png" style="padding: 20px;" />
              </div>
              <div class="addon-details">
                <p class="font-weight-bold mb-0 addon-name"><?php the_field('installationy','options'); ?></p>
                <div class="addon-price d-flex pb-4">
                  <div>+ £</div>
                  <div class="price">
                    <?php
                       echo number_format($installCost, 2);
                       ?>
                  </div>
                </div>
                <label for="size" class="checkbox-container">
                  <input type="checkbox" onclick="addAddonToCart(event, 'checkbox')" onclick="addAddonToCart(event, 'checkbox')" name="installation" value="yes">
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>
            <?php 
            }
            ?>
        </div>
        </div>
      </div>
    </div>
    <?php endif; ?>