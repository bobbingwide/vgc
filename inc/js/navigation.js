/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */


/*! wew.js v1.0.0 | (c) 2016 Alex Ledak | https://github.com/aljs/wew.js */
!function(t,i){"function"==typeof define&&define.amd?define(function(){return i(t)}):"object"==typeof exports?module.exports=i:t.Wew=i(t)}(this,function(t){"use strict";var i=function(i){var e=t.document.createElement("fakeelement"),n={animatedClass:"js-animated",animateLibClass:"animated",offset:0,target:".wew",keyword:"wew",reverse:!1,debug:!1,onLoad:!0,onScroll:!0,onResize:!1,callbackOnInit:function(){},callbackOnAnimate:function(){}};this.throttledEvent=this._debounce(function(){this.render()}.bind(this),15),this.supports="querySelector"in t.document&&"addEventListener"in t&&"classList"in e,this.options=this._extend(n,i||{}),this.elements=t.document.querySelectorAll(this.options.target),this.initialised=!1};return i.prototype._debounce=function(t,i,e){var n;return function(){var o=this,s=arguments,a=function(){n=null,e||t.apply(o,s)},r=e&&!n;clearTimeout(n),n=setTimeout(a,i),r&&t.apply(o,s)}},i.prototype._extend=function(){for(var t={},i=arguments.length,e=function(i){for(var e in i)t[e]=i[e]},n=0;i>n;n++){var o=arguments[n];this._isType("Object",o)?e(o):console.error("Custom options must be an object")}return t},i.prototype._whichAnimationEvent=function(){var i,e=t.document.createElement("fakeelement"),n={animation:"animationend",OAnimation:"oAnimationEnd",MozAnimation:"animationend",WebkitAnimation:"webkitAnimationEnd"};for(i in n)if(void 0!==e.style[i])return n[i]},i.prototype._getElemDistance=function(t){var i=0;if(t.offsetParent)do i+=t.offsetTop,t=t.offsetParent;while(t);return i>=0?i:0},i.prototype._getElemOffset=function(t){var i=parseFloat(t.getAttribute("data-"+this.options.keyword+"-offset"));return isNaN(i)?isNaN(this.options.offset)?void 0:this.options.offset<=1?Math.max(t.offsetHeight*this.options.offset):this.options.offset:1>=i?(0>i&&(i=0),Math.max(t.offsetHeight*i)):i},i.prototype._getScrollPosition=function(i){return"bottom"===i?Math.max((t.scrollY||t.pageYOffset)+(t.innerHeight||t.document.documentElement.clientHeight)):t.scrollY||t.pageYOffset},i.prototype._isInView=function(t){var i=function(){return this._getScrollPosition("bottom")>this._getElemDistance(t)+this._getElemOffset(t)?!0:!1}.bind(this),e=function(){return this._getScrollPosition("top")>this._getElemDistance(t)+this._getElemOffset(t)?!0:!1}.bind(this);return i()&!e()?!0:!1},i.prototype._isVisible=function(t){return"visible"===t.style.visibility},i.prototype._hasAnimated=function(t){var i=t.getAttribute("data-animated");return"true"===i},i.prototype._isType=function(t,i){var e=Object.prototype.toString.call(i).slice(8,-1);return null!==i&&void 0!==i&&e===t},i.prototype._addAnimation=function(i){var e=i.className.split(" ");e.push(this.options.animateLibClass),i.getAttribute("data-"+this.options.keyword+"-duration")&&(i.style.animationDuration=i.getAttribute("data-"+this.options.keyword+"-duration")),i.getAttribute("data-"+this.options.keyword+"-delay")&&(i.style.animationDelay=i.getAttribute("data-"+this.options.keyword+"-delay")),i.className="",setTimeout(function(){this.options.debug&&t.console.debug&&console.debug("Animation added"),i.setAttribute("data-visibility",!0),i.style.visibility="visible",e.forEach(function(t){i.classList.add(t)})}.bind(this),1),this._completeAnimation(i)},i.prototype._removeAnimation=function(t){t.setAttribute("data-visibility",!1),t.removeAttribute("data-animated"),t.style.visibility="hidden",t.classList.remove(this.options.animateLibClass)},i.prototype._completeAnimation=function(i){var e=this._whichAnimationEvent();i.addEventListener(e,function(){this.options.debug&&t.console.debug&&console.debug("Animation completed");i.getAttribute("data-"+this.options.keyword+"-remove");i.classList.add(this.options.animatedClass),i.setAttribute("data-animated",!0),this.options.callbackOnAnimate&&this._isType("Function",this.options.callbackOnAnimate)?this.options.callbackOnAnimate(i):console.error("Callback is not a function")}.bind(this))},i.prototype.init=function(){if(this.options.debug&&t.console.debug&&console.debug("Animate.js successfully initialised. Found "+this.elements.length+" elements to animate"),this.supports){this.options.onLoad&&t.document.addEventListener("DOMContentLoaded",function(){this.render()}.bind(this)),this.options.onResize&&t.addEventListener("resize",this.throttledEvent,!1),this.options.onScroll&&t.addEventListener("scroll",this.throttledEvent,!1),this.options.callbackOnInit&&this._isType("Function",this.options.callbackOnInit)?this.options.callbackOnInit():console.error("Callback is not a function");for(var i=this.elements,e=i.length-1;e>=0;e--){var n=i[e];this._isInView(n)||(n.style.visibility="hidden",n.setAttribute("data-visibility",!1))}this.initialised=!0}},i.prototype.kill=function(){this.options.debug&&t.console.debug&&console.debug("Animation.js nuked"),this.initialised&&(this.options.onResize&&t.removeEventListener("resize",this.throttledEvent,!1),this.options.onScroll&&t.removeEventListener("scroll",this.throttledEvent,!1),this.options=null,this.initialised=!1)},i.prototype.render=function(){for(var t=this.elements,i=t.length-1;i>=0;i--){var e=t[i],n=e.getAttribute("data-animation-reverse");this._isInView(e)?this._isVisible(e)||this._addAnimation(e):this._hasAnimated(e)&&"false"!==n&&this.options.reverse&&this._removeAnimation(e)}},i});

function toggle_mob_search() {
    jQuery(".mobeshop").toggleClass('show');
}

function ajaxSearchNow() {
    if (jQuery(window).width() < 997) 
    {
    
    }
    else
    {
        jQuery("#filterform").submit();
    }
}



if (jQuery(".searchandfilter").length > 0) {
    
    jQuery(".mob__filter").click(function() {
        jQuery("sidebar.shop-filter").toggleClass('fullscreen');
    });
    
    jQuery(".sf-field-submit").click(function() {
        jQuery("sidebar.shop-filter").toggleClass('fullscreen');
    });    
    
    
    
    
    /*
    jQuery(".cat__wrap").click(function() {
        if (jQuery(window).width() < 997) {
            jQuery(this).toggleClass('flip');
        }
    });
     

    jQuery('#filterform').submit(function() { // catch the form's submit event
        
        jQuery('#filterform').find('input[type="submit"]').css({ opacity: 0.5 }).attr("disabled", true);
        jQuery(".search_results").css({ opacity: 0.5 });
        jQuery(".spinnner_loading").toggleClass("show");
        jQuery("sidebar.shop-filter").removeClass('fullscreen'); 
        jQuery.ajax({ 
            data:   jQuery(this).serialize(), 
            type:   jQuery(this).attr('method'), 
            url:    jQuery(this).attr('action'), 
            success: function(response) { 
                //filter and show    
                var content = jQuery(response).find('.search_results').html();  
                jQuery('.search_results').html(content);                 
                jQuery('#filterform').find('input[type="submit"]').css({ opacity: 1 }).attr("disabled", false);
                jQuery(".spinnner_loading").removeClass("show");
                jQuery(".search_results").css({ opacity: 1 });
                jQuery(".mob__filter").click(function() {
                    jQuery("sidebar.shop-filter").toggleClass('fullscreen');
                });                
                
            }
            
        });
        return false;
    });
    
    */ 

}