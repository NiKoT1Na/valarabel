
function showLoadingGif() {
	if ($('.loading-gif-container').length === 0) {
		$("#subcontainer").html('<div class="loading-gif-container"><img class="loading" src="' + ASSETS_URL + '/body/loading.gif"><div>');
	}
}