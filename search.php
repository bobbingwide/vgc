<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package VGC
 */

if(isset($_GET['post_type']) && $_GET['post_type'] == 'products') {
	get_header('shop');
}
else {
	get_header();
}
?>
<?php
	if(isset($_GET['post_type']) && $_GET['post_type'] == 'products') {
		$query = "product";
	}
	else {
		$query = ["page", "post"];
	}
?>
<?php
	$args = [
		'post_type' => $query,
		'posts_per_page' => 12,
		'show_posts' => 12,
		'post__not_in' => [2344, 2278, 2193, 2020, 1817, 6, 7, 8, 107, 104, 102, 100, 87, 3]
	];
?>
<?php $query = new WP_Query($args); ?>
<section id="primary" class="content-area pb-5">
	<main id="main" class="site-main search-page">
		<div class="container-fluid pl-5 pr-5">
			<div class="row">
				<h1 class="page-title w-100 clearfix pb-5">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'vgc' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
					<?php if ($query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
						<div class="col-lg-4 pb-3">
							<div class="thumbnail">
								<?php the_post_thumbnail('full'); ?>
							</div>
							<div class="post-details">
								<h3 class="font-weight-bold font-colour-primary"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo substr(get_the_excerpt(), 0, 250).' [..]' ?></p>
								<?php if(isset($_GET['post_type']) && $_GET['post_type'] == 'products') { ?>
									<h4 class="mb-1 font-colour-primary font-weight-bold w-100 text-right pt-3"><small>From:</small> £<?php echo get_post_meta(get_the_ID(), '_regular_price', true); ?></h4>
								<?php } ?>
							</div>
						</div>
					<?php endwhile; endif; ?>
			</div>
		</div>
	</main><!-- #main -->
</section><!-- #primary -->

<?php
if(isset($_GET['post_type']) && $_GET['post_type'] == 'products') {
	get_footer('shop');
}
else {
	get_footer();
}
?>
