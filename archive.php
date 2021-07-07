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



    <div class="row">		
            <div class="col-12 pl-0 pr-0">
                <div class="owl-carousel owl-theme intro">
                    <div class="item" style="background-image: url('/wp-content/uploads/2018/11/vgc-news.jpg');">							
                        <img src="/wp-content/uploads/2018/11/vgc-news.jpg">	
                        <div class="html">
                         <h2> News<br><i>Take a look around</i></h2>
                        <div class="two_buttons">
                            <a href="/contact/" class="btn btn_secondary" tabindex="0">Get in touch with the experts</a>
                        </div>
                        <p>or call us <i>01730 893999</i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>	

    <div class="row">	
        <div class="col-md-8">
        	<div id="primary" class="content-area">
        		<main id="main" class="site-main row">
        
        		<?php if ( have_posts() ) : ?>
        
        			<?php
        			/* Start the Loop */
        			while ( have_posts() ) :
        				the_post();
        
        				/*
        				 * Include the Post-Type-specific template for the content.
        				 * If you want to override this in a child theme, then include a file
        				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
        				 */
        				get_template_part( 'template-parts/content-news', get_post_type() );
        
        			endwhile;
        
        			the_posts_navigation();
        
        		else :
        
        			get_template_part( 'template-parts/content', 'none' );
        
        		endif;
        		?>
        
        		</main><!-- #main -->
        	</div><!-- #primary -->
        	
        	
        </div>
        <div class="col-md-4 ">
            <div class="sidebar">
            <?php get_sidebar(); ?>
            </div>
        </div>        
    </div>
    
    
    
    <style>.cta-bottom{background-image: url("/wp-content/uploads/2018/11/news.jpg");}</style>
    
<?php

get_footer();
