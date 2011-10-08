/*!
* hipScript v2 // 2011.08.23 // jQuery 1.5.1+
* 
* @author Adam Turner
*/
jQuery(document).ready(function ($) {

	// === Standard ColorBox controls === //
	$('.colorbox').colorbox(); // ColorBox with standard settings for images
	$('.video').click(function (e) {
		e.preventDefault(); // For auto-embedded video
	});
	$('.websitebox').colorbox({width:"960px", height:"95%", iframe:true}); // For iframed websites
	
	// === Inline content function for Slideshow sources === //
	$('.js-hideme').css('display', 'none'); // hide all content wrapped in class="js-hideme" div
	function inlinecolor () {
		$('a[name="inlinebox"]').each(function () { // do the following for each a tag with name attr "inlinebox"
			var selector = '.' + $(this).attr("class"); // form the selector variable 
			var sourceId = '#' + $(this).attr("class"); // form the hidden content div ID
			$(selector).colorbox({ // call ColorBox on the selector crafted from the name attribute of the a tag
				width:'960px', 
				maxHeight: '98%',
				inline: true,
				href: sourceId,
				onComplete: function (){ // callback action to insert audio when present
					var z=$("#audio").get();
					$(".colorbox-inline-content h4").after(z);
				}
			});
		});
	}
	
	// === Slideshow controls === //
	$('#slide-toggler').removeClass('no-script'); // fall-back class for styling minus JavaScript
	$('#slide-container div:not(.default)').hide(1, inlinecolor); // calls the function above (inlinecolor) upon completion
	$('#slide-toggler li:first').addClass('visited');
	$('#slide-toggler li a').click(function (e) {
		$('#slide-container div:first').addClass('active');
		$('#slide-toggler .current_page_item').removeClass('current_page_item');
		$(this).parent().addClass('current_page_item').addClass('visited');
		var clicked = $(this).attr('href');
		$('#slide-container .active').hide().removeClass('active');
		$('#slide-container ' + clicked).stop(true, true).fadeIn('medium', 'swing').addClass('active');
		e.preventDefault();
	});
	
	// === Make sure all resources have been viewed === //
	if ($('#slide-toggler.hide-pagenav-next')[0]) {
		$('.pagenav-next').css('visibility', 'hidden');
	}
	$('#slide-toggler.hide-pagenav-next li a').click(function (e) {
		e.preventDefault();
		$('#slide-toggler li').each(function () {
			if ($(this).hasClass('visited')) {
				$('.pagenav-next').css('visibility', 'visible');
			} else {
				$('.pagenav-next').css('visibility', 'hidden');
				return false;
			}
		});
	});
	
	// === Notes style modification === //
    $(document).ready(function () {
        $('.all-module-notes .note:even').addClass('even');
        $('.all-module-notes .note:odd').addClass('odd');
    });
	
	// === Notes form controls === //
	if ($('#psnotesform').attr("name")) {
		$('.pagenav-next').css('visibility', 'hidden');
	} else {
		$('.pagenav-next').show();
	}
		
	// === Notes page layout === //
	$('.notes-page-section .section-wrap').hide();
	$('.notes-page-section > h2 > a').hover(
		function () {
			$(this).addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
		}).click(function (e) {
			e.preventDefault();
			var selected = $(this).attr('href');
			$(selected + ' .section-wrap').slideToggle('medium');
			$(this).toggleClass("close");
		});
		
	// === Larger thumbnail preview (with hover delay) === //
	// define mouseover callback function
	function overCallbackFn() {
		$(this).parent().addClass("zindex10");
		$(this).find('span').addClass("assistive-text");
		$(this).next('a.jump-url').addClass("assistive-text");
		$(this).find('img').addClass("hover").stop()
			.animate({
				marginTop: '-112px', 
				marginLeft: '-158px', 
				top: '75%', 
				left: '50%', 
				width: '280px', 
				height: '172px',
				padding: '10px'
			}, 200);
	}
	// define mouseout callback function
	function outCallbackFn() {
		$(this).parent().removeClass("zindex10");
		$(this).find('img').removeClass("hover").stop()
			.animate({
				marginTop: '0',
				marginLeft: '0',
				top: '0', 
				left: '0', 
				width: '160px', 
				height: '99px', 
				padding: '5px'
			}, 400);
		$(this).find('span').removeClass("assistive-text");
		$(this).next('a.jump-url').removeClass("assistive-text");
	}
	// set hoverIntent settings
	var hoveropt = {
		sensitivity: 7, // sensitivity threshold
		interval: 90, // 90 millisecond delay on mouseover action
		over: overCallbackFn, // mouseover callback function
		out: outCallbackFn // mouseout callback function
	};
	// call hoverIntent on thumbnails
	$("ul.thumb a:not('.jump-url')").hoverIntent(hoveropt);
	
	// === Swap Image on Click === //
	$("ul.thumb li a").click(function () {	
		var mainImage = $(this).attr("href"); //Find Image Name
		$("#main_view img").attr({ src: mainImage });
		return true;		
	});
	
});