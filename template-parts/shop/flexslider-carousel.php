<?php
	// Get the featured image and the product gallery images and store in the carousel array
	global $product;
	$galleryIDs = $product->get_gallery_image_ids();
	$carousel = [];
	$carouselThumbs = [];
	$carouselCaption = [];
	$id = get_the_ID();
	array_push($carousel, get_the_post_thumbnail_url($id, 'shop_single'));
	array_push($carouselThumbs, get_the_post_thumbnail_url($id, 'woocommerce_thumbnail'));
	array_push($carouselCaption, wp_get_attachment_caption(get_post_thumbnail_id()));
	foreach($galleryIDs as $id) {
		array_push($carouselThumbs, wp_get_attachment_image_src($id, 'woocommerce_thumbnail')[0]);
		array_push($carousel, wp_get_attachment_image_src($id, 'shop_single')[0]);
		array_push($carouselCaption, wp_get_attachment_caption($id));
	}
	?>
	<div id="slider" class="flexslider">
		<ul class="slides">
			<?php
			for($i = 0; $i < count($carousel); $i++) { ?>
				<li>
					<img src="<?php echo $carousel[$i]; ?>" />
					<p class="caption" style="font-size: .9rem;padding-top: 10px"><?php echo $carouselCaption[$i]; ?></p>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div id="carousel" class="flexslider">
		<ul class="slides">
			<?php
			for($i = 0; $i < count($carouselThumbs); $i++) { ?>
				<li>
					<img src="<?php echo $carouselThumbs[$i]; ?>" />
				</li>
			<?php } ?>
		</ul>
	</div>