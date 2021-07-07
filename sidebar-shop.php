<sidebar class="shop-filter p-4 d-block mb-5">
  <h2 class="font-weight-bold h5">Filter Search</h2>


    <?php 
        echo do_shortcode('[searchandfilter id="6288"]')
    ?>
  <!--
  <div>
    

    <?php
    // Get the child terms of the current category page
    $currentTerm = get_queried_object();
    // Function get_term_parent in functions.php file
    if(!empty($currentTerm->term_taxonomy_id)) {
        
        $parentTerm = get_term_top_parent($currentTerm->term_taxonomy_id);
        
        $childTerms = get_terms([
          'taxonomy' => 'product_cat',
          'child_of' => $parentTerm->term_id,
          'hide_empty' => false,
          'hierarchical' => true,
          'orderby' => 'menu_order',
          'order' => 'ASC'
        ]);
        
        if(!empty($childTerms)) { ?>
          <form action="<?php echo get_template_directory_uri() ?>/woocommerce/inc/shop-filter.php" method="POST" id="filterform">
            <input type="hidden" name="base_term" value="<?php echo $parentTerm->slug ?>">
            <input type="submit" name="filter" value="Apply filter">
            <ul>
              <?php
                foreach($childTerms as $term) {
                  if($term->parent == $parentTerm->term_id) { ?>

                    </ul>
                    </div>

                    <div class='cat__wrap'>
                    <h3 class="h5 font-weight-bold"><?php echo $term->name; ?></h3>
                    <ul>
                  <?php }
                  else { ?>
                    <?php
                    $status = "";
                      if(!empty($_SESSION['search_terms'])) {
                        if(in_array($term->slug, $_SESSION['search_terms'])) {
                          $status = "checked";
                        }
                      }
                    ?>
                    <li>
                        <label class="d-flex" style="margin-bottom: 0">  
                        <div><input style="position: relative;top: -3px" onchange="ajaxSearchNow()" type="checkbox" name="product_cat[]" value="<?php echo $term->slug ?>" <?php echo $status; ?>></div>
                        <div style="font-size: 1rem">&nbsp;&nbsp;<?php echo $term->name ?></div>
                        </label>
                    </li>
                  <?php } ?>
                <?php } ?>
            </ul>   
          </form>
        <?php } ?>
      <?php }
      else {
        echo "<p>No categories to display</p>";
      }
      ?>
  </div>
  -->
</sidebar>
