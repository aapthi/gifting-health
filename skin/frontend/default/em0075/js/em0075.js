/**
 * EMThemes
 *
 * @license commercial software
 * @copyright (c) 2012 Codespot Software JSC - EMThemes.com. (http://www.emthemes.com)
 */

(function($) {

EM_Theme = {
	PRODUCTSGRID_ITEM_WIDTH: 370,
	PRODUCTSGRID_ITEM_SPACING: 90,
	CROSSSELL_ITEM_WIDTH: 250,
	CROSSSELL_ITEM_SPACING: 90,
	UPSELL_ITEM_WIDTH: 250,
	UPSELL_ITEM_SPACING: 90
};



if (typeof EM == 'undefined') EM = {};
if (typeof EM.tools == 'undefined') EM.tools = {};


var isMobile = /iPhone|iPod|iPad|Phone|Mobile|Android|hpwos/i.test(navigator.userAgent);
var isPhone = /iPhone|iPod|Phone|Android/i.test(navigator.userAgent);


var domLoaded = false, 
	windowLoaded = false, 
	last_adapt_i, 
	last_adapt_width;


/**
 * Auto positioning product items in products-grid
 *
 * @param (selector/element) productsGridEl products grid element
 * @param (object) options
 * - (integer) width: width of product item
 * - (integer) spacing: spacing between 2 product items
 */
EM.tools.decorateProductsGrid = function (productsGridEl, options) {
/*	var $productsGridEl = $(productsGridEl);
	
	if ($productsGridEl.length == 0) return;
	
	var columnCount = Math.floor(($productsGridEl.outerWidth() + options.spacing) / (options.width + options.spacing));
	$productsGridEl.css({'position':'relative'});
	
	for (var i = 0; i < 30; i++) $('.item', $productsGridEl).removeClass('item-col-'+i);
            
	var maxHeight = 0;
	var i = 0;
	$('.item', $productsGridEl).each(function() {
		var prev = $(this).prevAll('.item-col-' + i).first();
        if(prev.length > 0){
            var top = prev.position().top + 380;
        }else{
            var top = 10;
        }
		
		$(this).addClass('item-col-'+i)
			.css({
				'position': 'absolute',
				'width': options.width + 'px',
				'left': 10 + i * (options.spacing + options.width) + 'px',
				'top': top + 'px'
			});
			
		maxHeight = Math.max(maxHeight, $(this).position().top + $(this).outerHeight(true));

		if (++i >= columnCount) i = 0;
	});
	
	$productsGridEl.css({
		'height': maxHeight + options.spacing + 'px'
	});
*/
}

/**
 * Decorate Product Tab
 */ 
EM.tools.decorateProductCollateralTabs = function() {
	$(document).ready(function() {
			if($('.box-collateral').length > 1){
            $('.product-collateral').each(function(i) {
			$(this).wrap('<div class="tabs_wrapper_detail collateral_wrapper" />');
            $(this).prepend('<ul class="tabs_control"></ul>');
            $(this).children(".product-collateral-item").addClass("ui-slider-tabs-content-container");
//			var tabs_control = $(document.createElement('ul')).addClass('tabs_control').insertBefore(this);

			$('.box-collateral', this).addClass('tab-item').each(function(j) {
				var id = 'box_collateral_'+i+'_'+j;
				$(this).addClass('content_'+id);
                $(this).attr('id',id);
				$('.tabs_wrapper_detail ul.tabs_control').append('<li><a href="#'+id+'">'+$('h2', this).html()+'</a></li>');
			});
            $("div.tabs_wrapper_detail .product-collateral").sliderTabs({
                autoplay: false,
                indicators: true,
                mousewheel: false,
                panelArrows: true,
                tabHeight: 28,
                panelArrowsShowOnHover: true
            });
			//initToggleTabs(tabs_wrapper);
		});
		
		// update products position after tab showed
		/*
		$('.box-collateral.box-up-sell.tab-item').bind('emtabshow', function() {
			EM.tools.decorateProductsGrid('#upsell-product-table .products-grid', {
				width: EM_Theme.UPSELL_ITEM_WIDTH,
				spacing: EM_Theme.UPSELL_ITEM_SPACING
			});
		});
		*/
		}
	});
};

function menuVertical() {
	if($('.vnav > .menu-item-link > .menu-container > li.fix-top').length > 0){
		$('.vnav > .menu-item-link > .menu-container > li.fix-top').parent().parent().mouseover(function() {
			var $container = $(this).children('.menu-container,ul.level0');
			var $containerHeight = $container.outerHeight();
			var $containerTop = $container.offset().top;
			var $winHeight = $(window).height();
			var $maxHeight = $containerHeight + $containerTop;
			//if($maxHeight >= $winHeight){
				$setTop = $(this).parent().offset().top -  $(this).offset().top;
				if(($setTop+$containerHeight) < $(this).height()){
					$setTop  = $(this).outerHeight() - $containerHeight;
				}
			/*}else{
				$setTop = (-1);
			}*/
			var $grid = $(this).parents('.em_nav').first().parents().first();
			$container.css('top', $setTop);
			if($maxHeight < $winHeight){
				$('.vnav ul.level0,.vnav > .menu-item-link > .menu-container').first().css('top', $setTop-9 +'px');
			}
			
		});
		$('.vnav .menu-item-link > .menu-container,.vnav ul.level0').parent().mouseout(function() {
			var $container = $(this).children('.menu-container,ul.level0');
			$container.removeAttr('style');
		});
	}
}

/**
 * Fix iPhone/iPod auto zoom-in when text fields, select boxes are focus
 */
function fixIPhoneAutoZoomWhenFocus() {
	var viewport = $('head meta[name=viewport]');
	if (viewport.length == 0) {
		$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0"/>');
		viewport = $('head meta[name=viewport]');
	}
	
	var old_content = viewport.attr('content');
	
	function zoomDisable(){
		viewport.attr('content', old_content + ', user-scalable=0');
	}
	function zoomEnable(){
		viewport.attr('content', old_content);
	}
	
	$("input[type=text], textarea, select").mouseover(zoomDisable).mousedown(zoomEnable);
}

/**
 * Adjust elements to make it responsive
 *
 * Adjusted elements:
 * - Image of product items in products-grid scale to 100% width
 */
function responsive() {
	
	// resize products-grid's product image to full width 100% {{{
	var position = $('.products-grid .item').css('position');
	if (position != 'absolute' && position != 'fixed' && position != 'relative')
		$('.products-grid .item').css('position', 'relative');
		
	var img = $('.products-grid .item .product-image img');
	if (!(img.parent().parent().parent().parent().hasClass("category-products"))){
		img.each(function() {
			img.data({
				'width': $(this).width(),
				'height': $(this).height()
			})
		});
		img.removeAttr('width').removeAttr('height').css('width', '100%');
	};
	$('.custom-logo').each(function() {
		$(this).css({
			'max-width': $(this).width(),
			'width': '100%'
		});
	});
}

window.onresize = function(){
	if (typeof em_slider!=='undefined'){
		setTimeout(function(){em_slider.reinit();},100);
	}	
	if (($('#image')!=null)&& (product_zoom != null)){
		$('#image').width(product_zoom.imageDim.width);
        Event.stopObserving($('#zoom_in'), 'mousedown', product_zoom.startZoomIn.bind(product_zoom));
        Event.stopObserving($('#zoom_in'), 'mouseup', product_zoom.stopZooming.bind(product_zoom));
        Event.stopObserving($('#zoom_in'), 'mouseout', product_zoom.stopZooming.bind(product_zoom));

        Event.stopObserving($('#zoom_out'), 'mousedown', product_zoom.startZoomOut.bind(product_zoom));
        Event.stopObserving($('#zoom_out'), 'mouseup', product_zoom.stopZooming.bind(product_zoom));
        Event.stopObserving($('#zoom_out'), 'mouseout', product_zoom.stopZooming.bind(product_zoom));

		//$('#image').height(product_zoom.imageDim.height);
		product_zoom = new Product.Zoom('image', 'track', 'handle', 'zoom_in', 'zoom_out', 'track_hint');;
	}
}
function persistentMenu(){

	$(function () {
		$(window).scroll(function () {
			window.freezedTopMenu = (isPhone!=1 && EM_Theme.FREEZED_TOP_MENU) ? 1: 0;
			if ($(this).scrollTop() > 145 && window.freezedTopMenu) {
				$('.hnav').parent(".em_nav").first().addClass('fixed-top');
			} else {
				$('.hnav').parent(".em_nav").first().removeClass('fixed-top');
			}
		});
	});
}
/**
 * Function called when layout size changed by adapt.js
 */
function whenAdapt(i, width) {
	
	$('body').removeClass('adapt-0 adapt-1 adapt-2 adapt-3 adapt-4 adapt-5 adapt-6')
		.addClass('adapt-'+i);
	//disable freezed top menu when in iphone
	window.freezedTopMenu = (isMobile!=1 && EM_Theme.FREEZED_TOP_MENU) ? 1: 0;
	
	if (window.freezedTopMenu && $(window).scrollTop() > 145) { 
		$('.hnav').parent(".em_nav").first().addClass('fixed-top');
	} else {
		$('.hnav').parent(".em_nav").first().removeClass('fixed-top');
	}	
	/*EM.tools.decorateProductsGrid('.category-products .products-grid', {
		width: EM_Theme.PRODUCTSGRID_ITEM_WIDTH,
		spacing: EM_Theme.PRODUCTSGRID_ITEM_SPACING
	});
	EM.tools.decorateProductsGrid('#upsell-product-table .products-grid', {
		width: EM_Theme.UPSELL_ITEM_WIDTH,
		spacing: EM_Theme.UPSELL_ITEM_SPACING
	});
	EM.tools.decorateProductsGrid('#crosssell-products-list', {
		width: EM_Theme.CROSSSELL_ITEM_WIDTH,
		spacing: EM_Theme.CROSSSELL_ITEM_SPACING
	});*/
}

// Back to top
function backToTop(){
    // hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
	});

	// scroll body to 0px on click
	$('#back-top a').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

}
/**
 * Callback function called when stylesheet is changed by adapt.js
 */
ADAPT_CONFIG.callback = function(i, width) {
	last_adapt_i = i;
	last_adapt_width = width;
	
	whenAdapt(last_adapt_i, last_adapt_width);
};

function toolbarSearch(){

	$('.cat-search').each(function(){
		$(this).insertUlCategorySearch();
		$(this).selectUlCategorySearch();
	});
    $('#select-language').each(function(){
        $(this).insertUl();
        $(this).selectUl();
    });
    $('.currency').each(function(){
        $(this).insertUl();
        $(this).selectUl();
    });

}

/**
*   Add class mobile
**/
function addClassMobile(){
    if(isMobile == true){
        jQuery('body').addClass('mobile-view');
    }
}

function hoverTopCart(){
	$(function($) {
		
		$('.dropdown-cart').each(function(){
			if(isMobile==true){
				$('.dropdown-cart').find('.amount').attr('href','javascript:void(0);');	
				$(this).unbind('click');
				var divWrapper = $(this);
				$(this).find('.icon.cart,.amount').click(function (e) {
					e.preventDefault();
					divWrapper.find('.cart-popup').slideToggle();
				});
			} else{
				var tm;
				function show(el) {
					clearTimeout(tm);
					tm = setTimeout(function() {
						el.slideDown();
					}, 200);
				}
				function hide(el) {
					clearTimeout(tm);
					tm = setTimeout(function() {
						el.slideUp();
					}, 200);
				}
				$(this)
					.bind('mouseenter', show.curry($('.cart-popup', this)))
					.bind('mouseleave', hide.curry($('.cart-popup', this)))
					.find('.cart-popup').slideUp();
			}
		});
		
	});
}

$(document).ready(function() {
	domLoaded = true;  
	isMobile && fixIPhoneAutoZoomWhenFocus();
	alternativeProductImage();
	setupReviewLink();
	// safari hack: remove bold in h5, .h5
	if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
		$('h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6').css('font-weight', 'normal');
	}
	addClassMobile();
	toogleStore();
	hoverTopCart();
	if($('.wrapper').hasClass('em-box-custom')){
		if($('body').hasClass('adapt-0')){
			$('.wrapper').removeClass('em-box-custom');
		}
		$(window).bind('emadaptchange',function(){
			if($('body').hasClass('adapt-0')){
				$('.wrapper').removeClass('em-box-custom');
			} else {
				$('.wrapper').addClass('em-box-custom');
			}
		});	
	}
	if (EM_Theme.FREEZED_TOP_MENU) persistentMenu();	
    backToTop();
    menuVertical();
});

$(window).bind('load', function() {
	windowLoaded = true;
	responsive();
	whenAdapt(last_adapt_i, last_adapt_width);
	em0075();
	initIsotope();
	if(jQuery('body').viewPC()){
        toolbarSearch();
		toolbar();
	}
	menuVertical();
});


})(jQuery);

/**
 * Change the alternative product image when hover
 */
function alternativeProductImage() {
    var $=jQuery;
    var tm;
    function swap() {
        clearTimeout(tm);
        setTimeout(function() {
            el = $(this).find('img[data-alt-src]');
            var newImg = $(el).data('alt-src');
            var oldImg = $(el).attr('src');
            $(el).attr('src', newImg).data('alt-src', oldImg);
        }.bind(this), 200);
    }

    $('.item .product-image img[data-alt-src]').parents('.item').bind('mouseenter', swap).bind('mouseleave', swap);
}

function showAgreementPopup(e) {
	
	//jQuery('#checkout-agreements .agreement-content').show();
	//$('agreement-content-popup').show();
		
	jQuery('#checkout-agreements label.a-click').parent().parent().children('.agreement-content').show()
		.css({
			'left': (parseInt(document.viewport.getWidth()) - jQuery('#checkout-agreements label.a-click').parent().parent().children('.agreement-content').width())/2 +'px',
			'top': (parseInt(document.viewport.getHeight()) - jQuery('#checkout-agreements label.a-click').parent().parent().children('.agreement-content').height())/2 + 'px'
		});
	
};

/**
 *   After Layer Update
 **/
window.afterLayerUpdate = function () {
    var $=jQuery;
    if($('body').viewPC()){
        toolbar();
    }
    alternativeProductImage();
    initIsotope();
    qs({
        itemClass: '.products-grid li.item, .products-list li.item, li.item .cate_product, .product-upsell-slideshow li.item, .mini-products-list li.item, #crosssell-products-list li.item', //selector for each items in catalog product list,use to insert quickshop image
        aClass: 'a.product-image', //selector for each a tag in product items,give us href for one product
        imgClass: '.product-image img' //class for quickshop href
    });
}


function hideAgreementPopup(e) {
	//$('opc-agreement-popup-overlay').hide();
	jQuery('#checkout-agreements .agreement-content').hide();
	
};

function initSlider(e,verticals) {
	var $ = jQuery;
    var wraps;
	if (verticals == null){
		verticals=false;
    }
	
	var widthcss = $( e + ' li.item').width();
	var rightcss = $( e + ' li.item').outerWidth(true)- $( e + ' li.item').outerWidth();
	$(e).addClass('jcarousel-skin-tango');
	$(e).parent().append('<div class="slide_css">');
	$(e).parent().find('.slide_css').html('<style type="text/css">'+e+' .jcarousel-item {width:' + widthcss + 'px;margin-right:'+ rightcss +'px;}</style>');
	//jQuery('#<?php echo $idJs;?>_css').html('<style type="text/css">#<?php echo $idJs;?> .jcarousel-skin-tango .jcarousel-item {width:' + width_<?php echo $idJs;?> + 'px;}</style>');
	//$('.jcarousel-skin-tango .jcarousel-item').css('width',  width>');
	$(e).jcarousel({
		buttonNextHTML:'<a class="next" href="javascript:void(0);" title="Next"></a>',
		buttonPrevHTML:'<a class="previous" href="javascript:void(0);" title="Previous"></a>',
		scroll: 1,
		animation:'slow',
		vertical:verticals,
		initCallback: function (carousel) {
			var context = carousel.container.context;
			$(context).touchwipe({
				wipeLeft: function() { 
					carousel.next();
				},
				wipeRight: function() { 
					carousel.prev();
				},
				preventDefaultEvents: false
			});
			jQuery(window).bind('emadaptchange orientationchange', function() {
				setTimeout(function(){
					carousel.reload();
					carousel.scroll(1,true);
					carousel.funcResize();
				},300); 
				}); 
			jQuery(window).resize(function(){
				setTimeout(function(){
					carousel.reload();
				},300); 
				}); 
		}
	});
	

}

/**
*   showReviewTab
**/

function showReviewTab() {
	var $ = jQuery;
	
	function getReviewTabHandle() {
		var classes = $('#customer-reviews').attr('class').split(' ');
		var href = '';
		$(classes).each(function (i, e) {
			if (/content_box_collateral/.test(e)) {
				href = e.replace('content_', '');
			}
		});
		return $('[href="#'+href+'"]');
	}
	
	var hasTab = $('.product-collateral').hasClass('tab_content');
	var reviewTab = getReviewTabHandle();//$('.tabs_control li:contains(Review)');
	if (hasTab) {
		// scroll to review tab
		$('html, body').animate({
			 scrollTop: reviewTab.offset().top
		}, 500);
		 
		 // show review tab
		reviewTab.click();
	} else if ($('#customer-reviews').size()) {
		// scroll to customer review
		$('html, body').animate({ scrollTop: $('#customer-reviews').offset().top }, 500);
	} else {
		return false;
	}
	return true;	
}

/**
*   setupReviewLink
**/
function setupReviewLink() {
	jQuery('.r-lnk').click(function (e) {
		if (showReviewTab())
			e.preventDefault();
	});
}

function toolbar(){
    var $=jQuery;

    $('.show').each(function(){
        $(this).insertUl();
        $(this).selectUl();
    });
    $('.sortby').each(function(){
        //$(this).insertTitle();
        $(this).insertUl();
        $(this).selectUl();
    });
}

/* js for theme */
function em0075(){
	var $ = jQuery;
	var tagul = $(".widget-home ul.products-grid");
	tagul.each(function(){
		var tagli = $(this).find("li.item");
		var heightli = 0;
		tagli.each(function(){
			if (heightli < $(this).height())
				heightli = $(this).height();
		})
		tagli.css("min-height",heightli+"px");
	})
}

function toogleStore(){
    var $=jQuery;
   
    	initSlider('#slider_storeview ul', null);
  
    $('.storediv').hide(); 
    $(".btn_storeview").click(function() {
		store_show();        
	});
	
	$(".btn_storeclose").click(function() {
		store_hide();
	});
	
	function store_show(){            
		var bg	=	$("#bg_fade_color");
		bg.css("opacity",0.5);
		bg.css("display","block");    		
        var top =( $(window).height() - $(".storediv").height() ) / 2;
        var left = ( $(window).width() - $(".storediv").width() ) / 2;
		$(".storediv").show();
        $(".storediv").css('top', top+'px');
        $(".storediv").css('left', left+'px');
	}
	
	function store_hide(){
		var bg	=	$("#bg_fade_color");
		$(".storediv").hide();
		bg.css("opacity",0);
		bg.css("display","none");
	}
};
/* Isotope */
function initIsotope(){
	if(!checkPhone){	
	var itemwidth = jQuery('.category-products ul.products-grid li').first().width();
	
	jQuery.Isotope.prototype._getMasonryGutterColumns = function() {
	    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
	        containerWidth = this.element.width();
	  
	    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
	                  // or use the size of the first item
	                  this.$filteredAtoms.outerWidth(true) ||
	                  // if there's no items, use size of container
	                  containerWidth;

	    this.masonry.columnWidth += gutter;

	    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
	    this.masonry.cols = Math.max( this.masonry.cols, 1 );
	  };

	  jQuery.Isotope.prototype._masonryReset = function() {
	    // layout-specific props
	    this.masonry = {};
	    // FIXME shouldn't have to call this again
	    this._getMasonryGutterColumns();
	    var i = this.masonry.cols;
	    this.masonry.colYs = [];
	    while (i--) {
	      this.masonry.colYs.push( 0 );
	    }
	  };

	  jQuery.Isotope.prototype._masonryResizeChanged = function() {
	    var prevSegments = this.masonry.cols;
	    // update cols/rows
	    this._getMasonryGutterColumns();
	    // return if updated cols/rows is not equal to previous
	    return ( this.masonry.cols !== prevSegments );
	  };
	jQuery('.category-products ul.products-grid').isotope({
		itemSelector : '.item',
		masonry : {
	      },
		    layoutMode : EM_Theme.PRODUCTSGRID_POSITION_ABSOLUTE
	});

	}
	
}

