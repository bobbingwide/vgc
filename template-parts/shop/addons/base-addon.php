<?php 
$terms = get_the_terms(get_the_ID(), 'product_cat');

//this tries to limit the bases based on category
// I think we can ignore that as dany bollox
// instead now par of the code itself....
//$baseOptions = showProductBases($terms);


$ppq = get_query_var('ppq');
$productLength = get_query_var('productLength');
$productWidths = get_query_var('productWidth');

$postcodeBand = $ppq->getPostcodeBand();
//if($baseOptions['show']) {

//this returns an array of bases allowed based on length, width, options
$baseSizes = getBaseTypePriceFromGlobalOptions($productLength, $productWidth, $postcodeBand, $terms);
$bandcodes = 'delivery';
$start_band = 0;
for ( $band = $start_band; $band<= 4; $band++ ) {
    //$delivery = $ppq->deliveryBandPrice( $band);
    $bandcodes .= ' delivery_band_' . $band;
}
?>
<div class="section-addon-wrap delivery delivery_band_not_set" id="base_wrapper">
    <div class="section-options pb-4 pt-4 delivery delivery_band_not_set">
        <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
            <?php the_field('base_title','options'); ?>
        </h3>
        <p class="text-center">Please enter the first part of your postcode (e.g. GU33) to check base options.</p>

    </div>
    <div class="section-options pb-4 pt-4 delivery delivery_excluded">
        <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
            <?php the_field('base_title','options'); ?>
        </h3>
        <p class="text-center">Base options not available.</p>

    </div>

  <div class="section-options pb-4 pt-4 addon-select-required addon-select-radio <?php echo $bandcodes;?> ">
    <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
          <?php the_field('base_title','options'); ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/down-arrow-blue.png" alt="icon" class="ml-4">
      </h3>
      <div class="section-addon-wrap__inner">
          
        <div style="text-align: center; padding-top: 1rem">
        <?php the_field('base_intro','options'); ?>
        </div>          
          
        <div class="d-flex flex-wrap"> 
            <?php 
              foreach($baseSizes as $base) { ?>
                <div class="p-5 block text-center">
                  <div class="thumbnail"> 
                    <img style='width:100%; height: auto;padding: 2rem 10px' src="<?php echo $base["image"]; ?>" alt="<?php echo $base["title"]; ?>" />
                  </div>
                  <div class="addon-details">
                    <p class="fw-bold mb-0 addon-name">
                     <?php echo $base["title"]; ?>
                    </p>
                    <div class="addon-price d-flex pb-4">
                        <div>+ £</div>
                        <?php
                        $start_band = 0;
                        for ( $band = $start_band ; $band<= 4; $band++ ) {
                            //bw_trace2( $base, "base", false );
                            $baseBandPrice = $base['costs'][$band];
                            $bandcode = ' delivery delivery_band_' . $band;
                            echo '<div class="price' . $bandcode . '">';
                            echo $baseBandPrice;
                            echo '</div>';
                        }
                        ?>
                  </div>


                    <label for="base-type" class="checkbox-container">
                      <input 
                        type="checkbox" 
                        onclick="addAddonToCart(event, 'checkbox')"  
                        name="base-type" 
                        value="<?php echo strtolower($base["title"]); ?>">
                      <span class="checkmark"></span>
                    </label>
                    
                    <div style="padding: 2rem 1rem 1rem 1rem"> 
                    <p class="w-100 clearfix font-colour-primary" style="font-size: 0.85rem">
                    <?php echo $base["description"]; ?>
                    </p>
                    </div>
                    
                  </div>
                </div>
            <?php } ?>
          </div>
          <input type="hidden" name="b" value="<?php echo $postcodeBand; ?>" />
        </div>
      </div>
    </div>
<?php 
//}