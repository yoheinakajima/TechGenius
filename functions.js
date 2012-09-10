



function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-articles').hide();
		$('#navbar .nav li').removeClass('active');
		$('#container-article').show();
		$('#articletitle').html(articletitle);
		$('#articlecontent').html('loading');
		$.ajax({
			url:"functions/loadarticle.php",
			type:"post",
			success:function(data){
				alert('hey');
			}
		});
		
	});
}
