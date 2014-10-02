jQuery(document).ready(function($) {
	$('.carousel').slick({
	  infinite: true,
	  dots: true,
	  arrows: true,
	  autoplay: true,
	  centerMode: true,
	  centerPadding: '50px',
	  lazyLoad: 'ondemand',
	  speed: 500,
	  autoplaySpeed: 5000,
	  responsive: [
		  {
      breakpoint: 600,
      settings: {
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1
      }
    }
  ]
	});
});

