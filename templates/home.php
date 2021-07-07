<?php
/**
 * The template for displaying all pages
 * 
 * Template name: Home
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VGC
 */

get_header(); ?>

	
    	
		
		<?php
		while ( have_posts() ) : the_post();
		?>
        <div class="row">		
		<div class="col-12 pl-0 pr-0">
			<div class="owl-carousel owl-theme intro">
			<?php
				if(have_rows('slides')):
				while ( have_rows('slides') ) : the_row();
				
				$img = get_sub_field('image');
		
					if( !empty($img) ):
					
						$slide = $img['url'];
						$alt = $img['alt'];
						
						?>
						<div class="item" style="background-image: url('<?php echo($slide);?>');">							
							<img src="<?php echo($slide);?>" alt="<?php echo($alt);?>" />	
							<div class="html">
    							<?php the_sub_field('html');?>
							</div>						
						</div>
					<?php
					endif;
				endwhile;
				endif;
			?>
			</div>
		</div>	
        </div>
        
        <div class="row align-items-center ctas">
            
            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/garden-maintenance/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/12/garden-maintenance-services-hampshire-west-sussex-surrey.jpg')">
                        <span>Garden Maintenance</span>
                    </div>
                    </a>
                </div>                
            </div>
            
            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/landscaping/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/12/landscaping-services-hampshire-west-sussex-surrey-1.jpg')">
                        <span>Landscaping</span>
                    </div>
                    </a>
                </div>                
            </div>
            
            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/commercial-grounds-care/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/12/commercial-grounds-care.jpg')">
                        <span>Commercial Grounds Care</span>
                    </div>
                    </a>
                </div>                
            </div>                        

            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/tree-surgery/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/08/ideas01_12.jpg')">
                        <span>Tree Surgery</span>
                    </div>
                    </a>
                </div>                
            </div>
            
            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/garden-buildings/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/08/ideas01_14.jpg')">
                        <span>Garden Buildings</span>
                    </div>
                    </a>
                </div>                
            </div>
            
            <div class="col-md-4 col-6">
                <div class="parent">
                    <a href="/artificial-grass/">
                    <div class="child" style="background-image: url('/wp-content/uploads/2018/11/artificial-grass-image.jpg');background-position: 0 20%">
                        <span>Artificial Grass</span>
                    </div>
                    </a>
                </div>                
            </div>
        </div>        


    		
   		<div class="row justify-content-md-center">
       		<div class="col-md-8">
           		<div class="about text-center ">
               		<div class="wew fadeIn">
            			<?php
            				the_content();
            			?>
               		</div>
        		</div>
    		</div>
        </div>
        <div class="row justify-content-md-center ">
            <div class="col-md-7 col-lg-5 text-center ">
                    <div class="wew fadeIn into">
            			<?php
            				
            				the_field('extra');
            			?>
                    </div>
        		</div>
    		</div>    		
        </div>
        
        
        <section class="house">
        <div class="houses owl-theme owl-carousel">
            
			<?php
				if(have_rows('houses')):
				while ( have_rows('houses') ) : the_row();
				
				$img = get_sub_field('image');
		
					if( !empty($img) ):
					
					    $alt = $img['alt'];
						$slide = $img['sizes']['houses'];
						$slide2 = $img['sizes']['woocommerce_thumbnail'];
						
						
						?>
						<div class="item">	
    						<div class="inner">						
							<img class="tall" src="<?php echo($slide);?>" alt="<?php echo($alt);?>" />
							<img class="short"  style="display:none;" src="<?php echo($slide2);?>" alt="<?php echo($alt);?>" />	
							<div class="html">
    							
							</div>	
                            <h2><?php the_sub_field('heading');?></h2>
                            <p><?php the_sub_field('info');?></p>												
    						</div>
						</div>
					<?php
					endif;
				endwhile;
				endif;
			?>   
			
			
			      
            
            
        </div>
          <p class="text-center"><a class="btn btn_secondary" href="/garden-buildings/">View all Buildings</a></p> 
        </section>
        

	
	
		<?php
		endwhile; // End of the loop.

get_footer();



