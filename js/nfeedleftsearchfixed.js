

$(document).ready(function(){
   $(window).bind('scroll', function() {
   var nHeight = 300;
		 if ($(window).scrollTop() > nHeight) {
			 $('.nfeedleftsearch').addClass('nfeedleftsearchfixed');
			 $('.header').addClass('nbodyleftmargintop');
			 $('.nfeedrightsearch').addClass('nbodyleftmarginbottom');
		 }
		 else {
			 $('.nfeedleftsearch').removeClass('nfeedleftsearchfixed');
			 $('.header').removeClass('nbodyleftmargintop');
			 $('.nfeedrightsearch').removeClass('nbodyleftmarginbottom');
		 }
	});
});