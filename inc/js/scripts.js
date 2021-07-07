jQuery(document).ready(function() {

  var carousel = document.querySelector('.carousel');
  if(carousel) {
    jQuery('.carousel').carousel();
  }

  var flexslider = document.querySelector('.flexslider');
  if(flexslider) {
    jQuery('#carousel').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: true,
      slideshow: false,
      itemWidth: 230,
      itemMargin: 32,
      asNavFor: '#slider'
    });

    jQuery('#slider').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: true,
      slideshow: true,
      sync: "#carousel"
    });
  }
  
  if ( jQuery(window).width() < 992 ) {

    if ( jQuery(window).width() < 992 ) {
      var win_width = (jQuery(window).width()/3);       
    }
    if ( jQuery(window).width() < 780 ) {
      var win_width = (jQuery(window).width()/2);       
    }
    jQuery('#uspstrip').flexslider({
      animation: "slide",
      controlNav: false,
      directionNav: false,
      itemWidth: win_width
    }); 

  }
  
  
});

