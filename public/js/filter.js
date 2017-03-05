$(function() {
	$('.ajax-form [type="submit"]').remove();
	let promise;
	function triggerAjax() {
		function ajax() {
			showLoadingGif();
			let jqXHR = $.ajax({
				type: 'GET',
				url: $('.ajax-form').attr('action'),
				data: $('.ajax-form').serialize(),
				success: function(data) {
					let $sr = $(data).find('.left-side > *');
					$('.left-side').html($sr);
					$('.ajax-form input').removeAttr('disabled');
				},
			});
			// $('.ajax-form input').attr('disabled', true);
			return jqXHR;
		}
		if (promise) {
			console.log(promise);
			promise = promise.then(ajax);
		} else {
			promise = ajax();
		}
	};

	$('.ajax-form input').on('change keyup', triggerAjax);
	$('.ajax-form [type="reset"]').click(function() {
		setTimeout(triggerAjax, 1);
	});
});
