jQuery(document).ready(function($){

	"use strict";

	/**
	 * ----------------------------------------------------------------------------------------
	 *    Globals
	 * ----------------------------------------------------------------------------------------
	 */

	var $body = $('body');
	var $window = $(window);

	/**
	* ----------------------------------------------------------------------------------------
	*    Functions
	* ----------------------------------------------------------------------------------------
	*/
	// Get URL Parameter
	function getUrlParameter(url, name) {
		return (RegExp(name + '=' + '(.*?)(&|$)').exec(url)||['',''])[1];
	}

	// Get Page Index
	function getPageIndex(url) {
		// return (RegExp(/(?:page\/|paged=)(\d+)\/*/).exec(url)||['','']);
		return (RegExp(/(?:(page\/)|(paged=))(\d+)\/*/).exec(url)||['','']);
	}

	/**
	 * ----------------------------------------------------------------------------------------
	 *    <bgimage>
	 * ----------------------------------------------------------------------------------------
	 */

	var $bgimage = $('.bg-image, .widget-bgimage');

	$bgimage.each(function(){
		var $this = $(this);
		var bgimage = $this.data('bgimage')

		$this.css('background-image', 'url("' + bgimage + '")' );
	})

	/**
	* ----------------------------------------------------------------------------------------
	*    Countdown Init
	* ----------------------------------------------------------------------------------------
	*/
	
	var $dealCountdown = $('.jscountdown-wrap');
	var expiredText = couponhut.expired;
	var dayText = couponhut.day;
	var daysPluralText = couponhut.days;
	var hourText = couponhut.hour;
	var hoursPluralText = couponhut.hours;
	var minuteText = couponhut.minute;
	var minutesPluralText = couponhut.minutes;

	function initCountdown(el){
		var $this = el;
		var finalDate = $this.data('time');

		$this.countdown(finalDate)
		.on('update.countdown', function(event) {

			var format = '%H:%M:%S';

			if ( $this.data('short') ) {

				if( event.offset.totalDays > 0 ) {
					format = '%-D %!D:' + dayText + ' ,' + daysPluralText + ' ;';
				} else if ( event.offset.hours > 0 ) {
					format = '%-H %!H:' + hourText + ' ,' + hoursPluralText + ' ;';
				} else {
					format = '%-M %!M:' + minuteText + ' ,' + minutesPluralText  + ' ;';
				}

				$this.html(event.strftime(format));

			} else if(event.offset.totalDays > 0) {
				var daysFormat = '%-D';

				$this.html('<span class="jscountdown-days">' + 
					event.strftime(daysFormat) +
					'</span>' + 
					'<span class="jscountdown-days-text">' + 
					event.strftime('%!D:' + dayText + ' ,' + daysPluralText + ' ;') + 
					'</span>' +
					'<span class="jscountdown-time">' +
					event.strftime(format) + 
					'</span>');

				// $this.html(event.strftime(daysFormat));
			} else {
				$this.html(event.strftime(format));
			}

		})
		.on('finish.countdown', function(event) {
			$this.html(expiredText)
			.parent().addClass('disabled')

		})
	}

	$dealCountdown.each(function(){

		initCountdown($(this));

	})


	/**
	 * ----------------------------------------------------------------------------------------
	 *    Isotope
	 * ----------------------------------------------------------------------------------------
	 */

	var $isotopeContainer = $(".isotope-wrapper");

	$isotopeContainer.each(function(){

		var $this = $(this);
		var isotopeCols = $this.data('isotope-cols');
		
		function setIsotopeCols(){

			var windowWidth = $(document).width();

			if ( windowWidth <= 478 ) {
				if(typeof $this.data('isotope-cols-xs') != 'undefined') {
					isotopeCols = $this.data('isotope-cols-xs');
				} else {
					isotopeCols = 1;
				}
			}
			else if ( windowWidth <= 767 ) {
				if(typeof $this.data('isotope-cols-xs') != 'undefined') {
					isotopeCols = $this.data('isotope-cols-xs');
				} else {
					isotopeCols = 2;
				}
			} else if ( windowWidth <= 992 ) {

				if(typeof $this.data('isotope-cols-sm') != 'undefined') {
					isotopeCols = $this.data('isotope-cols-sm');
				} else {
					isotopeCols = $this.data('isotope-cols') - 1;
				}

			} else {
				isotopeCols = $this.data('isotope-cols');
			}

			$this.children().css('width', $this.width() / isotopeCols - 1 + 'px' );

		}


		function setIsotopeGutter(){

			if(typeof($this.data('isotope-gutter')) != "undefined" && $this.data('isotope-gutter') !== null) {
				var itemGutter = $this.data('isotope-gutter');

				$this.css({
					'margin-left' : -itemGutter + 'px'
				})

				$this.children().css({
					'padding-bottom' : itemGutter + 'px',
					'padding-left' : itemGutter + 'px'
				})

			}		

		}

		setIsotopeCols();
		setIsotopeGutter();
		// Isotope Init
		$this.isotope({
			transitionDuration: '0.3s',
			layoutMode: 'masonry',
			masonry: {
				columnWidth: $this.width() / isotopeCols - 1
			}
		});

		// Fires Layout when all images are loaded
		$this.imagesLoaded( function() {
			$this.show();
			$window.trigger('resize');
		});

		// Set the items width on resize
		$window.on('resize', function (){
			setIsotopeCols();
			setIsotopeGutter();
			$this.isotope({
				transitionDuration: '0.3s',
				layoutMode: 'fitRows',
				masonry: {
					columnWidth: $this.width() / isotopeCols - 1
				}
			});
			setTimeout(function(){
				$this.isotope('layout');
			}, 1000);
		});

	})


	/**
	 * ----------------------------------------------------------------------------------------
	 *    Nav Menu
	 * ----------------------------------------------------------------------------------------
	 */

	$('.is-slicknav').slicknav({
		label: '',
		init: function(){
			var $brandLogo = $('.navigation-wrapper .site-logo').clone();
			$('.slicknav_menu').prepend($brandLogo);
		}
	});

	$('.main-navigation').find('.menu-item-has-children a').each(function(){

		var $this = $(this);

		if ( $this.next().hasClass('sub-menu') ) {
			$this.append('<i class="fa fa-angle-down"></i>');
		}

	})


	/**
	 * ----------------------------------------------------------------------------------------
	 *    Header on Scroll
	 * ----------------------------------------------------------------------------------------
	 */

	var $navigation = $('.navigation-wrapper');
	var $navOffset = $('.nav-offset');
	var navHeight = $navigation.height();

	function stickyNav() {

		navHeight = $navigation.height();
		
		if ( $window.scrollTop() > navHeight ){
			$navigation.addClass('nav-sticky');
			$navOffset.css('padding-top', navHeight);

		} else if ( $window.scrollTop() == 0 ){
			$navigation.removeClass('nav-sticky');
			$navOffset.css('padding-top', '');

		}

	}

	stickyNav();

	$window.scroll(function(){
		stickyNav();
	});

	$window.on('resize',function(){
		stickyNav();
	});
	


	/**
	 * ----------------------------------------------------------------------------------------
	 *    Video Background
	 * ----------------------------------------------------------------------------------------
	 */

	var bigvideos = {};
	

	$('.bigvideo-wrapper').each(function( index, value ){

		var $this = $(this);
		$this.find('.bg-image').hide();
		var fallback = false;
		var vjsPlayer = false;

		bigvideos[value] = new $.BigVideo({
			useFlashForFirefox: false,
			forceAutoplay: true,
			controls: false,
			doLoop: true,
			container: $this,
			shrinkable: false
		});

		bigvideos[value].init();

		if ( $this.data('bigvideo-mp4') || $this.data('bigvideo-webm') || $this.data('bigvideo-ogg')) {

			vjsPlayer = bigvideos[value].getPlayer();

			bigvideos[value].show([
				{ type: "video/mp4",  src: $this.data('bigvideo-mp4') },
				{ type: "video/webm", src: $this.data('bigvideo-webm') },
				{ type: "video/ogg",  src: $this.data('bigvideo-ogg') },
			]);

		} else {
			$this.find('.bg-image').show();
		}

		
	})


	/**
	* ----------------------------------------------------------------------------------------
	*    Hero Full Height
	* ----------------------------------------------------------------------------------------
	*/

	var $heroImage = $('.hero-image')
	var $navWrap = $('.navigation-wrapper')
	var $navMobile = $('.slicknav_menu');
	var wHeight = $window.height();

	function heroFullHeight(){
		wHeight = $window.height();
		if ( $navWrap.height() > 0 ) {
			var navHeight = $navWrap.height()
		} else {
			var navHeight = $navMobile.height();
		}
		$heroImage.height(wHeight - navHeight);
	}

	heroFullHeight();
	
	$window.on( 'scroll resize', function(){
		heroFullHeight();
	});

	/**
	* ----------------------------------------------------------------------------------------
	*    Featured Deals Slider
	* ----------------------------------------------------------------------------------------
	*/

	$(".featured-deals-slider").each(function(){
		var $this = $(this);
		$this.owlCarousel({
			singleItem: true,
			slideSpeed : 300,
			paginationSpeed : 400,
			autoPlay: 7000,
			stopOnHover: true,
			navigation: true,
			navigationText: ['<i class="icon-Triangle-ArrowLeft"></i>','<i class="icon-Triangle-ArrowRight"></i>'],
			rewindSpeed: 400
		});
	})

	

	/**
	 * ----------------------------------------------------------------------------------------
	 *    ClipboardJS
	 * ----------------------------------------------------------------------------------------
	 */

	var clipboard = new Clipboard('.show-coupon-code');

	$('.show-coupon-code').on('click', function(e){

	 	var $this = $(this);

	 	if( !$this.data('redirect') ) {
	 		e.preventDefault();
	 	}

	 })

	clipboard.on('success', function(e) {
		e.clearSelection();
		var $target = $(e.trigger);
		$($target.data('target')).modal('show');
	});


	/**
	 * ----------------------------------------------------------------------------------------
	 *    Single Deal Slider
	 * ----------------------------------------------------------------------------------------
	 */

	var $dealSlider = $('.single-deal-slider');

	$dealSlider.owlCarousel({
		singleItem:true,
		navigation: true,
		navigationText: ['<i class="icon-Triangle-ArrowLeft"></i>','<i class="icon-Triangle-ArrowRight"></i>'],
		rewindSpeed: 400,
		autoPlay: 4000
	});

    /**
    * ----------------------------------------------------------------------------------------
    *    5 Star Rating
    * ----------------------------------------------------------------------------------------
    */

	$(".post-star-rating i").click(function(){

		var $this = $(this);
        var post_id = $this.data("post-id");
        var rating = $this.data("rating");

        $.ajax({
        	type: "post",
        	url: couponhut.ajaxurl,
        	dataType: 'json',
        	data: "action=_action_ssd_post_rate&nonce="+couponhut.nonce+"&post_rate=&post_id="+post_id+"&rating="+rating,
        	success: function(data){
                // If vote successful
                if(data['average'] != "already") {

                	$.each( data['stars'], function( index, value ){

                		var $starElement = $this.closest('.post-star-rating').find('i').eq(index);

                		switch (value) {
                			case 'full':
                				$starElement.removeClass('fa-star fa-star-half-o fa-star-o').addClass('fa-star');
                				break;
                			case 'half':
                				$starElement.removeClass('fa-star fa-star-half-o fa-star-o').addClass('fa-star-half-o');
                				break;
                			case 'empty':
                				$starElement.removeClass('fa-star fa-star-half-o fa-star-o').addClass('fa-star-o');
                				break;
                		}
                	});

                	// $this.addClass("voted");
                	$this.closest('.post-star-rating').siblings('.rating-average').text(data['average']);
                	$this.closest('.post-star-rating').siblings('.rating-text').find('.rating-count').text(data['rating_count_total']);

                	if(data['rating_count_total'] == 1) {
                		$this.closest('.post-star-rating').siblings('.rating-text').find('.rates').text('rating');
                	} else {
                		$this.closest('.post-star-rating').siblings('.rating-text').find('.rates').text('ratings');
                	}
                	
                }
            }
        });

        return false;
    })

	/**
	* ----------------------------------------------------------------------------------------
	*    Rating Star Hover
	* ----------------------------------------------------------------------------------------
	*/

	$(".post-star-rating i").on({
		mouseenter: function () {
			var $this = $(this);
			$this.addClass('hovered');
			$this.prevAll().addClass('hovered');
			$this.nextAll().addClass('not-hovered');
		},
		mouseleave: function () {
			var $this = $(this);
			$this.removeClass('hovered');
			$this.prevAll().removeClass('hovered');
			$this.nextAll().removeClass('not-hovered');
		}
	});

	/**
	* ----------------------------------------------------------------------------------------
	*    Dropdown Select Save Input In Hidden Field
	* ----------------------------------------------------------------------------------------
	*/


	$(document).on('click', '.dropdown .dropdown-menu li a', function(e){

		var $this = $(this);

		var el = $this.parents('ul').data('name');

		if( el ){
			e.preventDefault();

			var dropdownButton = $this.parents( '.dropdown' ).find('button');
			
			dropdownButton.html( $this.html() );

			$this.closest('form').find('input[name="'+el+'"]').val( $this.data('value') );
		}

	});

	$('.dropdown').each(function(){

		var $this = $(this);

		var dropdownButton = $this.find('button');
		var currentItem = $this.find( '.dropdown-menu li a[data-current="true"]' );

		if ( currentItem.length > 0 ) {
			dropdownButton.html( currentItem.clone() );
		};

	})

	/**
	* ----------------------------------------------------------------------------------------
	*    AJAX Filter Search Button
	* ----------------------------------------------------------------------------------------
	*/

	function showDeals($dealsContainer, response) {

		var $response = $(response);
		var $res_paginaton = $response.find('.is-ajax-paging-navigation');
		var $res_deals = $response.find('.isotope-wrapper.is-ajax-deals-content > *');

		$dealsContainer.siblings('.ajax-deals-notice').remove();

		if ( $res_deals.html() ) {
			$dealsContainer.append($res_deals).isotope('appended', $res_deals);

			// Init JSCountdown on the new deals
			$res_deals.find('.jscountdown-wrap').each(function(){
				initCountdown($(this));
			})

			$dealsContainer.imagesLoaded(function(){
				$window.trigger('resize');
			})	
		} else {
			$dealsContainer.imagesLoaded(function(){
				$window.trigger('resize');
			})	
			// Show No Deals notice
			var $noDeals = $('<div class="ajax-deals-notice" ><h3>' + couponhut.no_deals + '</h3></div>');
			$dealsContainer.after($noDeals);
		}

		if ( $res_paginaton.html() ) {
			$('.is-ajax-paging-navigation').html($res_paginaton.html()).fadeIn('fast');	
		}
	}

	function removeDeals($dealsContainer) {

		$dealsContainer.siblings('.ajax-deals-notice').remove();

		var $spinner = $('<div class="ajax-deals-notice" ><h3>' + couponhut.loading_deals + '</h3><i class="fa fa-circle-o-notch fa-spin"></i></div>');
		$dealsContainer.isotope('remove', $dealsContainer.isotope('getItemElements'));
		
		// Change Pagination Opacity
		$('.is-ajax-paging-navigation').fadeOut('fast', function(){
			$(this).empty();
		});

		//Resize Isotope
		$dealsContainer.imagesLoaded(function(){
			$window.trigger('resize');
		})
		$dealsContainer.after($spinner);

	}

	$('.form-deal-submit button[type="submit"]:not(.is-ajax-deal-filter)').on('click', function(){
		var $this = $(this);

		$this.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		$this.attr('disabled','disabled');
		$this.closest('form').submit();
	})


	$('.form-deal-submit button[type="submit"].is-ajax-deal-filter').on('click', function(e){

		var $this = $(this);
		var buttonHtml = $this.html();

		// Button Spinner
		var buttonWidth = $this.width();
		$this.width(buttonWidth);
		$this.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		$this.attr('disabled','disabled');

		// If $dealContainer is present on current page, continue
		var $dealsContainer = $('.is-ajax-deals-content');
		if (  $dealsContainer.length == 0 ) {
			$this.closest('form').submit();
			return;
		};

		e.preventDefault();

		var s_deal_category = $this.closest('form').find('input[type="hidden"][name="s_deal_category"]').val();
		var s_deal_company = $this.closest('form').find('input[type="hidden"][name="s_deal_company"]').val();
		var days_start_range = $this.closest('form').find('input[type="hidden"][name="days_start_range"]').val();
		var days_end_range = $this.closest('form').find('input[type="hidden"][name="days_end_range"]').val();
		var deal_country = $this.closest('form').find('input[type="hidden"][name="deal_country"]').val();
		var deal_city = $this.closest('form').find('input[type="hidden"][name="deal_city"]').val();

		var $sort_current = $('.is-ajax-sort-deals a.current');
		var deal_sort = getUrlParameter($sort_current.attr('href'), 'sort');

		removeDeals($dealsContainer);

		// Change the URL bar
		var sPageURL = document.location.origin + document.location.pathname;
		sPageURL = sPageURL.replace(/(page\/\d+\/*)/, '');

		// Get the page ID if page_id is present
		var pageId = (RegExp(/(page_id=\d+\/*)/).exec(window.location.href)||['',''])[1];

		sPageURL += '?';
		sPageURL += ( pageId ? pageId : '');
		sPageURL += ( days_start_range ? '&days_start_range=' + days_start_range : '');
		sPageURL += ( days_end_range ? '&days_end_range=' + days_end_range : '');
		sPageURL += ( s_deal_category ? '&s_deal_category=' + s_deal_category : '');
		sPageURL += ( s_deal_company ? '&s_deal_company=' + s_deal_company : '');
		sPageURL += ( deal_country ? '&deal_country=' + deal_country : '');
		sPageURL += ( deal_city ? '&deal_city=' + deal_city : '');
		sPageURL += ( deal_sort ? '&sort=' + deal_sort : '');		

		sPageURL = sPageURL.replace('?&', '?');

		history.pushState({}, '', sPageURL);

		$.get(sPageURL, null, function(response){

			showDeals($dealsContainer, response);

			// Enable button and show results
			$this.html(buttonHtml);
			$this.removeAttr('disabled');	
			$this.css('width', '');	

		});	

	})

	/**
	* ----------------------------------------------------------------------------------------
	*    AJAX Deal Sort Button
	* ----------------------------------------------------------------------------------------
	*/

	$('.is-ajax-sort-deals a').on('click', function(e){

		e.preventDefault();

		var $this = $(this);

		var sPageURL = decodeURIComponent(window.location.search);
		
		var s_deal_category = getUrlParameter(sPageURL, 's_deal_category');
		var s_deal_company = getUrlParameter(sPageURL, 's_deal_company');
		var days_start_range = getUrlParameter(sPageURL, 'days_start_range');
		var days_end_range = getUrlParameter(sPageURL, 'days_end_range');
		var deal_country = getUrlParameter(sPageURL, 'deal_country');
		var deal_city = getUrlParameter(sPageURL, 'deal_city');

		var deal_sort = getUrlParameter($this.attr('href'), 'sort');

		// Change current sort button
		$this.siblings().removeClass('current');
		$this.addClass('current');

		// Spinner in Deals Container
		var $dealsContainer = $('.is-ajax-deals-content');
		
		removeDeals($dealsContainer);

		// Change the URL bar
		var sPageURL = document.location.origin + document.location.pathname;
		sPageURL = sPageURL.replace(/(page\/\d+\/*)/, '');

		// Get the page ID if page_id is present
		var pageId = (RegExp(/(page_id=\d+\/*)/).exec(window.location.href)||['',''])[1];

		sPageURL += '?';
		sPageURL += ( pageId ? pageId : '');
		sPageURL += ( days_start_range ? '&days_start_range=' + days_start_range : '');
		sPageURL += ( days_end_range ? '&days_end_range=' + days_end_range : '');
		sPageURL += ( s_deal_category ? '&s_deal_category=' + s_deal_category : '');
		sPageURL += ( s_deal_company ? '&s_deal_company=' + s_deal_company : '');
		sPageURL += ( deal_country ? '&deal_country=' + deal_country : '');
		sPageURL += ( deal_city ? '&deal_city=' + deal_city : '');
		sPageURL += ( deal_sort ? '&sort=' + deal_sort : '');	

		sPageURL = sPageURL.replace('?&', '?');

		history.pushState({}, '', sPageURL);

		$.get(sPageURL, null, function(response){
			
			showDeals($dealsContainer, response);
			
		});	

	})
	

	/**
	* ----------------------------------------------------------------------------------------
	*    AJAX Pagination
	* ----------------------------------------------------------------------------------------
	*/
	$(document).on('click', '.is-ajax-paging-navigation a', function(e){

		e.preventDefault();

		var $this = $(this);

		var sPageURL = decodeURIComponent(window.location.search);
		
		var s_deal_category = getUrlParameter(sPageURL, 's_deal_category');
		var s_deal_company = getUrlParameter(sPageURL, 's_deal_company');
		var days_start_range = getUrlParameter(sPageURL, 'days_start_range');
		var days_end_range = getUrlParameter(sPageURL, 'days_end_range');
		var deal_country = getUrlParameter(sPageURL, 'deal_country');
		var deal_city = getUrlParameter(sPageURL, 'deal_city');

		var $sort_current = $('.is-ajax-sort-deals a.current');
		var deal_sort = getUrlParameter($sort_current.attr('href'), 'sort');

		var paged = getPageIndex($this.attr('href'));

		// Spinner in Deals Container
		var $dealsContainer = $('.is-ajax-deals-content');

		removeDeals($dealsContainer);

		// Change the URL bar
		var sPageURL = document.location.origin + document.location.pathname;
		sPageURL = sPageURL.replace(/(page\/\d+\/*)/, '');

		// Get the page ID if page_id is present
		var pageId = (RegExp(/(page_id=\d+\/*)/).exec(window.location.href)||['',''])[1];

		sPageURL += ( paged[1] ? paged[0] : '');
		sPageURL += '?';
		sPageURL += ( paged[2] ? paged[2] + paged[3] : '');
		sPageURL += ( pageId ? '&' + pageId : '');
		sPageURL += ( days_start_range ? '&days_start_range=' + days_start_range : '');
		sPageURL += ( days_end_range ? '&days_end_range=' + days_end_range : '');
		sPageURL += ( s_deal_category ? '&s_deal_category=' + s_deal_category : '');
		sPageURL += ( s_deal_company ? '&s_deal_company=' + s_deal_company : '');
		sPageURL += ( deal_country ? '&deal_country=' + deal_country : '');
		sPageURL += ( deal_city ? '&deal_city=' + deal_city : '');
		sPageURL += ( deal_sort ? '&sort=' + deal_sort : '');		
		
		history.pushState({}, '', sPageURL);

		$.get(sPageURL, null, function(response){

			showDeals($dealsContainer, response);

		});	


	})


	/**
	* ----------------------------------------------------------------------------------------
	*    Show Cities on Country Dropdown Click
	* ----------------------------------------------------------------------------------------
	*/

	$('.dropdown .dropdown-menu[data-name="deal_country"] li a').on('click', function(e){

		var $this = $(this);
		var country = $this.data('value');
		var $citiesButton = $this.closest('.dropdown').siblings().find('button.is-city-deal-dropdown');

		$citiesButton.empty().html('<i class="fa fa-circle-o-notch fa-spin"></i>');

		$.ajax({
			type: 'post',
        	url: couponhut.ajaxurl,
        	dataType: 'json',
			data: "action=_action_ssd_show_cities&nonce="+couponhut.nonce+"&country="+country,
			success: function(response){

				var $citiesDropdown = $this.closest('.dropdown').siblings().find('ul[aria-labelledby="cities-deal-dropdown"]');
				
				$citiesDropdown.html(response.html);
				$citiesDropdown.find('.select-country-first').remove();

				$citiesButton.empty().html($citiesDropdown.find('li:first-child').html());
            }
        });

	});

	/**
	* ----------------------------------------------------------------------------------------
	*   Autofill cities and select current City if $_GET['deal_city'] exists
	* ----------------------------------------------------------------------------------------
	*/
	$('.is-city-deal-dropdown').siblings('.dropdown-menu').each(function(){
		var $this = $(this);

		var sPageURL = decodeURIComponent(window.location.search);
		var country = getUrlParameter(sPageURL, 'deal_country');
		var city = getUrlParameter(sPageURL, 'deal_city');

		var $citiesButton = $this.siblings('button.is-city-deal-dropdown');

		var buttonText = $citiesButton.html();

		if ( country && city ) {
			$citiesButton.empty().append('<i class="fa fa-circle-o-notch fa-spin"></i>');	
		}


		$.ajax({
			type: 'post',
        	url: couponhut.ajaxurl,
        	dataType: 'json',
			data: "action=_action_ssd_show_cities&nonce="+couponhut.nonce+"&country="+country+"&city="+city,
			success: function(result){

				$this.append(result.html);

				if ( result.cities_found) {

					$this.find('.select-country-first').remove();

					var currentItem = $this.find('li a[data-current="true"]');

					if ( currentItem.length > 0 ) {
						$citiesButton.html( currentItem.clone() );
					};
				} else {
					$citiesButton.html(buttonText);
				}

				
            }
        });
	})

	
	

	/**
	* ----------------------------------------------------------------------------------------
	*    Post Share Buttons
	* ----------------------------------------------------------------------------------------
	*/

	$('.is-shareable .facebook').on('click', function(e){
		e.preventDefault();
		var postUrl = $(this).closest('.is-shareable').data('post-url');
		window.open('http://www.facebook.com/sharer.php?u=' + postUrl,'sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	})

	$('.is-shareable .twitter').on('click', function(e){
		e.preventDefault();
		var postUrl = $(this).closest('.is-shareable').data('post-url');
		window.open('https://twitter.com/share?url=' + postUrl,'sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	})

	$('.is-shareable .google').on('click', function(e){
		e.preventDefault();
		var postUrl = $(this).closest('.is-shareable').data('post-url');
		window.open('https://plus.google.com/share?url=' + postUrl,'sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	})

	$('.is-shareable .pinterest').on('click', function(e){
		e.preventDefault();
		var postUrl = $(this).closest('.is-shareable').data('post-url');
		window.open('http://pinterest.com/pin/create/button/?url=' + postUrl,'sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	})

	/**
	* ----------------------------------------------------------------------------------------
	*    Parallax
	* ----------------------------------------------------------------------------------------
	*/

	function isScrolledIntoView(elem) {
		var $elem = $(elem);
		var $window = $(window);

		var docViewTop = $window.scrollTop();
		var docViewBottom = docViewTop + $window.height();

		var elemTop = $elem.offset().top;
		var elemBottom = elemTop + $elem.height();

		return (elemTop <= docViewBottom);
	}

	function parallax(){
		var windowWidth = $(document).width();

		if ( windowWidth > 992 ) {
			var docViewTop = $window.scrollTop();
			var docViewBottom = docViewTop + $window.height();

			$('.parallax').each(function(){
				var $this = $(this);
				var top = 0;
				if ( isScrolledIntoView($this) ) {

					top = docViewBottom - $this.offset().top;
					$this.css('background-position', '50% ' + ( 100 - (top * 0.07)) + '%');
				} else {
					$this.css('background-position', '50% 0%');
				}

			})
		}

		
	}

	parallax();

	$(window).on('scroll resize', function(e){
		parallax();
	});
	
})