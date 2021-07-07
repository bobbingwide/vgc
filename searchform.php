<?php
/**
 * Template for displaying search forms in VGC
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s"><i class="fas fa-search pr-2"></i></label>
		<input type="hidden" name="post_type" value="products">
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search...', 'vgc' ); ?>" />
	</form>
