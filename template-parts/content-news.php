<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VGC
 */

?>

<div class="col-12 col-md-6">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="news-bg">
        <a href="<?php the_permalink();?>" rel="bookmark">
    	<?php the_post_thumbnail("medium"); ?>   
        </a>     
    </div>



	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
        ?>

	</header><!-- .entry-header -->



	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'vgc' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );


		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
    	<?php
		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				vgc_posted_on();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>
