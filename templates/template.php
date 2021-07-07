<?php
/**
 * The template for displaying all pages
 * 
 * Template name: Landing Page
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

get_header(); 

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


<?php
    
    		the_content();
    		

        $footerImage = get_field("footer_image");
        if($footerImage)
        {
            echo '<style>';
            echo '.cta-bottom{background-image: url("'.$footerImage["url"].'");}';
            echo '</style>';
            
            
        }
        

    		
    
    
// check if the flexible content field has rows of data
if( have_rows('content') ):

    // loop through the rows of data
    while ( have_rows('content') ) : the_row();


        // FULL WIDTH IMAGE
        if( get_row_layout() == 'full_width_image' ):
        
            $image = get_sub_field('image');
            $alt = $image["alt"];
            
            ?>
            <div class="row">
                <div class="col-lg-12">		
                    <img src="<?php echo($image["url"]);?>" style="width: 100%;" alt="<?php echo($alt);?>" />
                </div>
            </div>
            <?php
        endif;


        // QUOTES
        if( get_row_layout() == 'quotes' ):
        ?>
        <div class="quote">
            <div class="wrap"> 
                <div class="quote-slide"> 
                    <ul class="quotes"> 
                        <?php
                        if(have_rows('quote')):
                            while ( have_rows('quote') ) : the_row();
                                ?>
                                <li>
                                    <p><?php the_sub_field('quote');?></p>
                                    <p class="author"><?php the_sub_field('author');?></p>
                                <li>
                                <?php
                                endwhile;
                        endif;?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        endif;


        // AWARDS
        if( get_row_layout() == 'awards' ):
        ?>
        <div class="awards">
            <?php
            if(have_rows('awards')):
                while ( have_rows('awards') ) : the_row();
                
                    $image = get_sub_field('award');
                    $alt = $image["alt"];
                    ?>
                    <ul>
                    <li><img src="<?php echo($image["url"]);?>" style="width: 100%;" alt="<?php echo($alt);?>" /></li>                            
                    <li><?php the_sub_field('name');?></li>
                    <li><?php the_sub_field('location');?></li>                            
                    <li><?php the_sub_field('category');?></li>
                    </ul>
                    <?php
                    endwhile;
            endif;?>
        </div>
        <?php
        endif; 


        // TITLE
        if( get_row_layout() == 'title' ):
        ?>
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php the_sub_field("title");?></h2>
            </div>
        </div>
        <?php
        endif;
        

        

endwhile; // End of the loop.




                  
                    
                    
                    
                    
                    
else :
// no layouts found
endif;            	

endwhile; // End of the loop.




get_footer();
