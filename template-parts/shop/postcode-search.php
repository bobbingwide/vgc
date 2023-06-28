<section class="postcode-search">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 text-center bg-brand-secondary">
				<?php if(is_active_sidebar('postcode-search-text')) : dynamic_sidebar('postcode-search-text'); endif; ?>
						<form action="#options_area" method="post">
							<input type="text" name="postcode" id="postcode" placeholder="Enter here..." maxlength="4" value="<?php echo isset($_POST['postcode']) ? filter_var($_POST['postcode'], FILTER_SANITIZE_STRING) : ""; ?>">
							<input type="submit" value="VIEW OPTIONS" class="submit_pc">
						</form>
					</div>
					<div class="col-lg-2 text-center">
						<?php if(is_active_sidebar('single-product-sidebar-top')) : dynamic_sidebar('single-product-sidebar-top'); endif; ?>
					</div>
				</div>
			</div>
		</section>