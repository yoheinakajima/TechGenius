



function makearticlesclickable(){
	$('.article').click(function(){
		var articletitle=$(this).html();
		$('#container-articles').hide();
		$('#navbar .nav li').removeClass('active');
		$('#container-article').show();
		$('#articletitle').html(articletitle);
		$.getJSON("http://yoheinakajima.github.com/TechGenius/functions/loadarticle.php?callback=?",
			function(data){
				$('#articlecontent').html('loading');
			},"json");
	});
}
