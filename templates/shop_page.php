<?php
/**
 * The template for displaying all pages
 * 
 * Template name: Shop Inner Page
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

get_header('shop'); 

while ( have_posts() ) : the_post();
    
    	the_content();

        $footerImage = get_field("footer_image");
        if($footerImage)
        {
            echo '<style>';
            echo '.cta-bottom{background-image: url("'.$footerImage["url"].'");}';
            echo '</style>';
        }
        
endwhile; // End of the loop.


get_footer('shop');
