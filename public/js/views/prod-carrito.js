
$(function () {
	function calcAndShowTotal () {
		var total = 0;
		$('[name="price[]"]').each(function (index, element) {
			var cantidad = parseInt($('[name="amount[]"]').eq(index).val());
			var precionUni = parseInt($(element).val());
			var subtotal = cantidad * precionUni;
			total += subtotal;			
		});
		$('.cart-total').html('$' + total);
	};

	calcAndShowTotal();

	$('[name="amount[]"]').on('change', calcAndShowTotal);
});