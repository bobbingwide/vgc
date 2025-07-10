<sidebar class="shop-filter p-4 d-block mb-5">
  <h2 class="fw-bold h5">Filter Search</h2>


    <?php
    if ( !defined( 'SEARCH_FILTER_PRO_VERSION')) {
        echo do_shortcode('[searchandfilter id="6288"]');
    } else {
        echo '<div class="searchandfilter">';
        echo do_shortcode('[searchandfilter field="Submit Button"]');
        echo do_shortcode('[searchandfilter field="Brand"]');
        echo do_shortcode('[searchandfilter field="Product Building Type"]');
        echo do_shortcode('[searchandfilter field="Material"]');
        echo do_shortcode('[searchandfilter field="Size"]');
        echo do_shortcode('[searchandfilter field="Reset"]');
        echo do_shortcode('[searchandfilter field="Submit Button"]');
        echo '</div>';
    }
    ?>
</sidebar>
