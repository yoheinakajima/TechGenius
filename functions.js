



function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-articles').hide();
		$('#navbar .nav li').removeClass('active');
		$('#container-article').show();
		$('#articletitle').html(articletitle);
		$.ajax({
			url:"functions/loadarticle.php",
			type:"get",
			success:function(data){
				alert(data);
				$('#articlecontent').html(data);
			}
		});
		
	});
}
