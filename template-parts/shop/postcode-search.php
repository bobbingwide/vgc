<section class="postcode-search">

		<div class="row">
             <div class="col text-center bg-brand-secondary">
			<?php if(is_active_sidebar('postcode-search-text')) : dynamic_sidebar('postcode-search-text'); endif; ?>
			<form action="#options_area" method="post">
				<input type="text" name="postcode" id="postcode" placeholder="Enter here..." maxlength="4" value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode'] ) : ""; ?>">
				<input type="submit" value="VIEW OPTIONS" class="submit_pc">
			</form>
             </div>

		</div>

</section>