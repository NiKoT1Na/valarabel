$(function() {
	$('.ajax-form').on('submit', function() {
		showLoadingGif();
		$.ajax({
			type: 'GET',
			url: $('.tag-selector').attr('action'),
			data: $('.tag-selector').serialize(),
			success: function(data) {
				let $sr = $(data).find('.left-side > *');
				$('.left-side').html($sr);
				$('.tag-selector input').removeAttr('disabled');
			},
		});
		$('.tag-selector input').attr('disabled', true);
		return false;
	});
});
