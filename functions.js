
function makearticletabsclickable(){
	$('#articletabs li').click(function(){
		$('#articletabs li').removeClass('active');
		$(this).addClass('active');
		var id=$(this).attr('id');
		loadarticles(id);
	});
}

function loadarticles(val){
	$('#articlelist').empty().load('include/articles.php',{val:val});
}

function loadtopkeywords(){
	$('#topkeywords').load('include/topkeywords.php');
}
function loadtopauthors(){
	$('#topauthors').load('include/topauthors.php');
}

function hidecontainers(){
	$('#container-articles, #container-article, #container-keyword, #container-author, #container-history, #container-about').hide();
}


function makearticlesclickable(){
	$('.articletitle').click(function(){
		var articletitle=$(this).html();
		var aid=$(this).attr('id');
		$('#navbar .nav li').removeClass('active');
		$('#articletitle').html(articletitle);
		$('#articlecontent').empty().load('include/article.php',{aid:aid});
		hidecontainers();
		$('#container-article').show();
		$('#articlekeywords').empty().load('include/topkeywords.php',{aid:aid});
		$('#articleauthor').empty().load('include/topauthors.php',{aid:aid});
		var slug = articletitle.toLowerCase().replace(/^\s+|\s+$/g, "").replace(/[_|\s]+/g, "-").replace(/[^a-z0-9-]+/g, "").replace(/[-]+/g, "-").replace(/^-+|-+$/g, "");
		var urlString='/techgenius/'+slug+'_ar'+aid;
		history.pushState("", "", urlString);
	});
}

function makekeywordsclickable(){
	$('.displaykeyword').off('click');
	$('.displaykeyword').click(function(){
		var displaykeyword=$(this).html();
		var kid=$(this).attr('id');
		hidecontainers();
		$('#navbar .nav li').removeClass('active');
		$('#container-keyword').show();
		$('#displaykeyword').html(displaykeyword);
		$('#keywordarticles').empty().load('include/articles.php',{kid:kid});
		$('#relatedkeywords').empty().load('include/topkeywords.php',{kid:kid});
		$('#keywordauthors').empty().load('include/topauthors.php',{kid:kid});
		var slug = displaykeyword.toLowerCase().replace(/^\s+|\s+$/g, "").replace(/[_|\s]+/g, "-").replace(/[^a-z0-9-]+/g, "").replace(/[-]+/g, "-").replace(/^-+|-+$/g, "");
		var urlString='/techgenius/'+slug+'_ke'+kid;
		history.pushState("", "", urlString);
	});
}

function makeauthorsclickable(){
	$('.authorname').click(function(){
		var authorname=$(this).html();
		var authorid=$(this).attr('id');
		hidecontainers();
		$('#navbar .nav li').removeClass('active');
		$('#container-author').show();
		$('#authorname').html(authorname);
		$('#authorarticles').empty().load('include/articles.php',{authorid:authorid});
		$('#authorkeywords').empty().load('include/topkeywords.php',{authorid:authorid});
		var slug = authorname.toLowerCase().replace(/^\s+|\s+$/g, "").replace(/[_|\s]+/g, "-").replace(/[^a-z0-9-]+/g, "").replace(/[-]+/g, "-").replace(/^-+|-+$/g, "");
		var urlString='/techgenius/'+slug+'_au'+authorid;
		history.pushState("", "", urlString);
	});
}
