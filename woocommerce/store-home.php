<?php
/**
 * Template name: Shop Homepage
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package VGC
 */
get_header('shop');
?>



<!-- Start shop main description -->
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
  <?php the_content(); ?>
<?php endwhile; endif; ?>


<?php get_footer('shop');
