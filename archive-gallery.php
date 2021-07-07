<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VGC
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

        <div class="row">		
        <div class="col-12 pl-0 pr-0">
            <div class="owl-carousel owl-theme intro">
                <div class="item" style="background-image: url('/wp-content/uploads/2018/11/landscaping-hampshire.jpg');">							
                    <img src="/wp-content/uploads/2018/11/landscaping-hampshire.jpg" />	
                    <div class="html">
                    <h2>Past Work<br> <i>Take a look around</i></h2>
                        <div class="two_buttons">
                            <a href="/contact/" class="btn btn_secondary" tabindex="0">Get In Touch With The Experts</a>
                        </div>
                    <p>or call us <i>01730 893999</i>
                    </div>
                </div>
            </div>
        </div>	
        </div>
        
        
        <div class="row">
            <div class="col text-center p-4">
                <h2>View all work or filter by...</h2>                
            </div>
        </div>
        

        
        
        <form id="fiterform">
        <div class="row">
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="892"  type="checkbox" checked><strong>Garden design</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="566"  type="checkbox" checked><strong>Walling and terracing </strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="867"  type="checkbox" checked><strong>Paving and circular features</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="799"  type="checkbox" checked><strong>Decking including Millboard composite decking </strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="838"  type="checkbox" checked><strong>Driveways and courtyards</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="912"  type="checkbox" checked><strong>Ponds, lakes, waterfalls and water features</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
        </div> 
        <div class="row">                    
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="829"  type="checkbox" checked><strong>Fencing and gates</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="927"  type="checkbox" checked><strong>Creative planting, turfing and irrigation systems</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="939"  type="checkbox" checked><strong>Specialist Stonework</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="1332" type="checkbox" checked><strong>Swimming pools, Groundworks, drainage and excavation</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="1343" type="checkbox" checked><strong>Pergolas, archways and bridges</strong><span><span>hide</span><span>✓</span><a></a></span></label></div>
            <div class="col col-sm-4 text-center toggle-switch"><label class="switch-light switch-candy"> <input data-post="781"  type="checkbox" checked><strong>Artificial grass  </strong><span><span>hide</span><span>✓</span><a></a></span></label> </div>     
        </div> 
        </form>       
        
        
         <div class="post-loader row">
             <div class="sizer"></div>
         
			<?php
            $args = array('post_type' => 'post');
            $query = new WP_Query($args);


			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
                
                
                the_content();
                
                
			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
        
         </div>
        
		</main><!-- #main -->
	</div><!-- #primary -->



<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript">

    
    // init Masonry
    var $grid = jQuery('.post-loader').masonry({
      itemSelector: '.gallery-item',
      columnWidth: '.sizer',
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress( function() {
      $grid.masonry();
    });  
    
    

    
    
    jQuery('#fiterform input:checkbox').change(function(){
        
        
            jQuery('#fiterform :checkbox:checked').each(function () {
                    
                    var p = jQuery(this).data("post");
                    jQuery(".galleryid-"+p+" figure.gallery-item").show(); 

            });        

            jQuery('#fiterform :checkbox').not(':checked').each(function () {
                    
                    var p = jQuery(this).data("post");
                    
                    console.log(p);
                    
                    jQuery(".galleryid-"+p+" figure.gallery-item").hide();   
                   
            });  
            
            
             $grid.masonry();  

   
    });  
    
       
        
</script>
<?php

get_footer();
