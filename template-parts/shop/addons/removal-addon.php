<?php 
//$terms = get_the_terms(get_the_ID(), 'product_cat');
//$baseOptions = showProductBases($terms);

$ppq = get_query_var('ppq');

// Get the data from the global options table
$globalOptionsTable = get_field('buildings', 'options');
?>

<div class="section-addon-wrap delivery delivery_band_not_set" id="removal_wrapper">
    <div class="section-options pb-4 pt-4">
        <h3 class="w-100 clearfix fw-bold mb-0 h5 font-colour-primary text-center toggle-next">
            <?php the_field('building_removal_title','options'); ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/down-arrow-blue.png" alt="icon" class="ml-4">
        </h3>

        <div class="section-addon-wrap__inner">
            <div class="delivery delivery_band_1 delivery_band_2 delivery_band_3">
            
            <div style="padding: 2rem 2rem 0 2rem">
             <?php the_field('building_removal','options'); ?>
            </div>
            
            <div class="d-flex flex-wrap">
            
                <?php 
                    
                    
                    foreach($globalOptionsTable as $row)
                    {
                    // Get the right price from the table
                    $smallest = 4;
                    $biggest = 20;                        
                    ?>
                    <div class="p-5 block text-center">
                    <div class="thumbnail">
                          <img style='width:100%; height: auto;padding: 2rem 10px' src="<?php echo $row["image"]["url"]; ?>" alt="<?php echo $row["title"]; ?>" />
                    </div>
                    <div class="addon-details ">
                    <p class="fw-bold mb-0 addon-name"><?php echo $row["title"]; ?></p>                    
                        <p class="options__select">
                        <select name="building_removal_<?php echo(sanitize_title($row["title"]));?>" onchange="addAddonToCart(event, 'select')">
                            <option value="" data-price="0" selected="">Please choose</option>    
                            <?php 
                            while($smallest <= $biggest)
                            {   
                                $inner_smallest = $smallest;
                                
                                while($inner_smallest <= $biggest)
                                {                                
                                    $cost = 0;
                                    $sqft = $smallest * $inner_smallest;
                                    
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
                                    
                                    $cost = number_format((float)$cost, 2, '.', '');
                                    ?>                                
                                    <option value="<?php echo $row["title"]; ?> <?php echo($smallest);?> x <?php echo($inner_smallest);?> " data-price="<?php echo($cost);?>"><?php echo($smallest);?> x <?php echo($inner_smallest);?> removal</option>                                
                                <?php
                                $inner_smallest++;        
                                }    
                                $smallest++;
                            }
                            ?>                          
                        </select>
                        </p>
                        
                        <div style="padding: 2rem 1rem 1rem 1rem"> 
                        <p class="w-100 clearfix font-colour-primary" style="font-size: 0.85rem">
                            <?php echo $row["description"]; ?>
                        </p>
                        </div>                        
                        
                        </div>
                    </div>                    
                    <?php    
                    }
                ?>
            </div>
            </div>
            <div class="delivery delivery_band_not_set">

            <p class="text-center">Please enter the first part of your postcode (e.g. GU33) to check removal options.</p>

        </div>
        </div>


    </div>
</div>

