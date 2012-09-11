



function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-articles').hide();
		$('#navbar .nav li').removeClass('active');
		$('#container-article').show();
		$('#articletitle').html(articletitle);
		$.get(
			"functions/loadarticle.php",
			function(data){
				alert(data);
				$('#articlecontent').html(loading);
			},"json");
	});
}
