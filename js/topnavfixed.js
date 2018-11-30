
$(document).ready(function(){
   $(window).bind('scroll', function() {
   var navHeight = 115;
		 if ($(window).scrollTop() > navHeight) {
			 $('.topnav').addClass('topnavfixed');
			 $('.header').addClass('nbodymargintop');
		 }
		 else {
			 $('.topnav').removeClass('topnavfixed');
			 $('.header').removeClass('nbodymargintop');
		 }
	});
});