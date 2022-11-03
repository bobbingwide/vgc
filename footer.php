<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VGC
 */

?>

	</div><!-- #content -->
	
	
	<div class="container-fluid cta-bottom">
    	<div class="row" >
        	
        	<div class="inner">
        	    <img src="/wp-content/uploads/2018/08/leaf.svg" alt="Transform your Garden" class="img">
        	    <div class="in">
            	 <?php 
                	$page_id = get_queried_object_id();
                	
                	if($page_id==26)
                	{
                    	?><h2>Maintaining Your Standards</h2><?php
                    	
                	} 
                	else
                	{
                    	
                    	?><h2>Transform your Garden</h2><?php
                    	
                	}
                	
                	
                	
                	if($page_id==32)
                	{
                    	?><h3>Let Us Help</h3>
                        <div class="two_buttons">
                            <div class="hov">
                            <a href="/store/" class="btn btn_secondary" tabindex="0">Online Shop</a>
                            </div>
                            <div class="hov">
                            <a href="/contact" class="btn btn_primary" tabindex="0">Visit our show site</a>
                            </div>
                        </div>        	
                 	
                    	
                    	
                    	
                    	<?php
                    	
                	} 
                	else
                	{
                    	
                    	?><h3>Book your consultation</h3>
                        <div class="two_buttons">
                            <div class="hov">
                            <a href="/gallery" class="btn btn_secondary" tabindex="0">Our Portfolio</a>
                            </div>
                            <div class="hov">
                            <a href="/contact" class="btn btn_primary" tabindex="0">Book</a>
                            </div>
                        </div>        	
                   	
                    	
                    	<?php
                    	
                	}                	
                	
                	
                	
                	
                    ?>
        	    
        	    
        	    
        	    

        	    


            	 <?php 
                	$page_id = get_queried_object_id();
                	
                	if($page_id==20)
                	{
                    	?>
                    	<div class="footer--phone hide-mob"><p><a href="tel:+441730893999">01730 893999</a></p></div><?php
                    	
                	} 
                	?>
        	    </div>
        	</div>
        	
    	</div>
	</div>
	

	<footer id="colophon" class="site-footer container-fluid">
		<div class="site-info row">
			
		<div class="col">	
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 1") ) : ?><?php endif;?>
		</div>
		
		<div class="col">	
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 2") ) : ?><?php endif;?>
		</div>
		
		<div class="col">	
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 3") ) : ?><?php endif;?>
		</div>
		
		<div class="col">	
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer 4") ) : ?><?php endif;?>
        
        
        <p style="padding-top: 20px"><a href="https://www.hotboxstudios.co.uk/website-design/surrey-website-design/" title="Surrey Website Design">Surrey Website Design</a>&nbsp;&nbsp;by&nbsp;&nbsp; <a href="http://www.hotboxstudios.co.uk/" title="Hotbox Studios">Hotbox Studios</a></p>
        
		</div>
			
        </div><!-- .site-info -->
	</footer><!-- #colophon -->
    </div><!-- #container -->
</div><!-- #page -->

<!-- Pushy Menu -->
<nav class="pushy pushy-left" data-focus="#first-link">

	<?php
	wp_nav_menu( array(
		'theme_location' => 'menu-1',
		'menu_id'        => 'mob-menu',
		'container_class'=> 'pushy-content',
	));
	 
	wp_nav_menu( array(
		'theme_location' => 'menu-2',
		'menu_id'        => 'mob-menu2',
		'container_class'=> 'pushy-content',
	));			
	 
    ?>
</nav>
<div class="site-overlay"></div>

<?php wp_footer(); ?>



<script type="text/javascript">
    /*
    jQuery('.intro').owlCarousel({
        loop:true,
        margin:0,
        nav:false,
        dots:true,    
    	items:1,
    	autoplay:true,
    	animateOut: 'fadeOut'
    });
    
    
    jQuery('.houses').owlCarousel({
        loop:true,
        margin:50,
        nav:true,
        dots:false,    
    	items:4.2,
    	autoplay:true,
		responsive:{
	        0:{
	            items:1.2,
	            margin:10
	        },
	        600:{
	            items:2.2
	        },
	        1000:{
	            items:4.2
	        }
	    }    	
    });  
    
    */
    
    jQuery('.intro').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
    	autoplay:true,
    	animateOut: 'fadeOut',
    	pauseOnFocus: false,
    	pauseOnHover: false        
    }); 
    
    jQuery('.houses').slick({
        centerMode: false,
        slidesToShow: 3.4,
        slidesToScroll: 2,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 550,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false
              }
            }
        ]
        
        
    });  
    
    
    function togglesearch()
    {
        jQuery('.searchform').toggleClass('hidden');
    }   
            
    
    
</script>
<script>
    var wew = new Wew();
    wew.init();
</script>
</body>
</html>
