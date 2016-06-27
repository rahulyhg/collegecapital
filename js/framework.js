$(document).ready(function() {
	$('ul#filter a').click(function() {
		$(this).css('outline','none');
		$('ul#filter .current').removeClass('current');
		$(this).parent().addClass('current');
		
		var filterVal = $(this).text().toLowerCase().replace(/ /gi,"-");
		//alert(filterVal);		
		if(filterVal == 'section-1') {
			$('ul#portfolio li.section-1').fadeIn('slow').removeClass('hidden');
			$('ul#portfolio li.section-2').fadeOut('normal').addClass('hidden');
			$('ul#portfolio li.section-3').fadeOut('normal').addClass('hidden');
			//Note: Unfortunately because of the structure of the FAQ page, have to manually add/remove the above code for new LI based on FAQ sections
		} else {
			
			$('ul#portfolio li').each(function() {
				if(!$(this).hasClass(filterVal)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
		
		return false;
	});
});