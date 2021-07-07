<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package VGC
 */

get_header();
?>

<div class="row">
    <div class="col-md-8">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );



		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
    </div>
    <div class="col-md-4">
        <div class="pt-4 sidebar">
        <?php                
        get_sidebar();
        ?>
        </div>
    </div>
</div>

<?php
    
    
    

get_footer();
