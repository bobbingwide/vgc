<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VGC
 */

get_header('shop');
?>
<?php get_template_part('woocommerce/inc/usp', 'strip') ?>
<?php //var_dump(WC()); ?>
<section class="cart-page pb-5">
	<div class="container-fluid pl-5 pr-5">
	<div class="row">
      <div class="col-lg-12">
				<h1 class="fw-bold pt-2 w-100">Your Basket</h1>
	  		<?php
	  			if(have_posts()) : while (have_posts()) : the_post();
	  				the_content();
	  			endwhile; endif;
	  		?>
			</div>
      </div>
		</div>
</section>
<?php
get_footer('shop');
