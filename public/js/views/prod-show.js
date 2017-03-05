
$(function() {
	function imageZoom() {
		$('.zoomed').attr('src', this.src);
		$('.overlay').fadeIn();
	}

	$('.overlay > button.close').click(function() {
		$('.overlay').fadeOut();
	});

	$('.thumbnail > img').click(function() {
		$('.image_to_zoom').attr('src', this.src);
	});

	$('.image_to_zoom').click(imageZoom);
	$('.new_review').submit(function() {
		$.ajax({
			type: 'POST',
			url: this.action,
			data: $('.new_review').serialize(),
			success: function(data) {
				// console.log(data);
				let $sr = $(data).find('.show_reviews > *');
				$('.show_reviews').html($sr);
				$('.new_review').remove();
				$('.show_reviews .titulo-bonito')
					.html('Gracias por tu reseña!')
					.hide().fadeIn(4000);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.single-error').remove();
				['details', 'rating', 'name'].forEach(function(input, i) {
					if (jqXHR.responseJSON[input]) {
						$('<div class="single-error">')
							.text(jqXHR.responseJSON[input].join(', '))
							.appendTo('.' + input + '-group');
					}
				});
			},
		});
		return false;
	});
});
