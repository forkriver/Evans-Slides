jQuery(document).ready(function($) {
	$('.carousel').slick({
	  infinite: true,
	  dots: true,
	  arrows: true,
	  autoplay: true,
	  centerMode: true,
	  lazyLoad: 'ondemand',
	  cssEase: 'linear',
	  speed: 500,
	  autoplaySpeed: 5000
	});
});

