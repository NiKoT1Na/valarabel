
$(function(){
	$('body').on('click', '.pagination a', function(event){
		showLoadingGif();
		var url = this.href;
		$('.left-side').load(url + ' .left-side > *');
		return false;						
	});
});
