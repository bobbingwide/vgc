<?php
/**
 * The template for displaying the shop footer
 * Contains the closing of the #content div and all content after.
 */

$page_id = get_queried_object_id();
                	
if($page_id !=5769)
{
?>    
<div class="container-fluid cta-bottom-shop cta-bottom">
  <div class="row" >
    <div class="inner">
      <img src="/wp-content/uploads/2018/08/leaf.svg" alt="Transform your Garden" class="img">
      <div class="in">
        <?php if(is_active_sidebar('footer-shop-1')) : dynamic_sidebar('footer-shop-1'); endif; ?>
      </div>
    </div>
  </div>
</div>
<?php
}
?>
<footer id="colophon" class="site-footer container-fluid">
  <div class="site-info row">
    <div class="col">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 1 Shop") ) : ?><?php endif;?>
        <script src="https://assurance.sysnetgs.com/assurancecard/be8e7fbc4499573fe4e52dc3153f648e515ed06aced4418e06d383d6dcb998e1/cardJs" type="text/javascript"></script>        
		</div>
		<div class="col">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 2 Shop") ) : ?><?php endif;?>
		</div>
		<div class="col">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 3") ) : ?><?php endif;?>
		</div>
		<div class="col">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 4") ) : ?><?php endif;?>
		</div>
  </div>
  
  
  
</footer>
</div>
</div>
<!-- Pushy Menu -->
<nav class="pushy pushy-left" data-focus="#first-link">
	<?php
	wp_nav_menu( array(
		'theme_location' => 'menu-5',
		'menu_id'        => 'mob-menu',
		'container_class'=> 'pushy-content',
	));
    ?>
</nav>
<div class="site-overlay"></div>
<?php wp_footer(); ?>
</body>
</html>
