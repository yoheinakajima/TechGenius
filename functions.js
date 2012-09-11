

function loadarticles(){
	$('#articlelist').load('include/articles.php');
}

function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-articles').hide();
		$('#navbar .nav li').removeClass('active');
		$('#container-article').show();
		$('#articletitle').html(articletitle);
		$('#articlecontent').load('include/article.php');
	});
}
