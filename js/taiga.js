$('.anime-play-button').click(function() {
	alert('Soon.');
});

$('#search-bar').on('input propertychange paste', function() {
	var text = $(this).val().toLowerCase();
    $.each($('.anime-box'), function(k, v) {
    	if($(this).attr('data-anime-name').indexOf(text) >= 0)
    		$(this).show();
    	else $(this).hide();
    });
});