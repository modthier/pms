$('#filter').click(function () {
	var btn = $(this).text();
	$('.filters').slideToggle(1000);
	

	if ($.trim($(this).text()) === 'Show Filters') {
       $(this).text('Hide Filters');
	} else {
	    $(this).text('Show Filters');        
	}

});