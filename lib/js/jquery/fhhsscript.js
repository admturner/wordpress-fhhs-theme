/*!
* hipScript v2 // 2011.08.23 // jQuery 1.5.1+
* 
* @author Adam Turner
*/
jQuery(document).ready(function ($) {
	
	// === Notes page layout === //
	$('.membership-list .members').hide();
	$('.membership-list > h4 > a').hover(
		function () {
			$(this).addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
		}).click(function (e) {
			e.preventDefault();
			$('.open').hide();
			var selected = $(this).attr('href');
			$(selected + ' .members').slideToggle('medium').toggleClass('open');
			$(this).toggleClass("close");
		});
	$('.to-top').click(function (e) {
		e.preventDefault();
		var clicked = $(this).attr('href');
		$(clicked + ' .members').slideToggle('fast').toggleClass('open');
		$(this).toggleClass("close");
	});
});