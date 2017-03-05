$(function registerAjaxLinks(){ 		
	$(".small-text").on('click', '.side-links', function(event){
		showLoadingGif();
		var url = this.href;
		$(".left-side").load(url + " .left-side > *");
		return false;
	});
});
