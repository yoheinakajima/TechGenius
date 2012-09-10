function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-dashboard').hide();
		$('#container-article').show();
		$('#articletitle').html(articletitle);
	});
}