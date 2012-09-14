
<!DOCTYPE HTML>
<html>
<head>
<title>TechGenius</title>
	
	<!-- JQUERY: from google api library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	
	
	<!-- CSS - BOOTSTRAP: include bootstrap css  from boostrap folder-->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	
	<!-- CSS - CUSTOM: custom style changes to be kept in mystyle.css-->
	<link href="mystyle.css" rel="stylesheet">
	
	<!-- JAVASCRIPT FUNCTIONS - BOOTSTRAP -->
	<script src="bootstrap/js/bootstrap.js"></script>
	
	<!-- JAVSCRIPT FUNCTIONS - CUSTOM -->
	<script src="functions.js"></script>
</head>
<body>
	<div class="navbar navbar-fixed-top" id="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="#">TechGenius.me</a>
					<ul class="nav">
					  <li class="active navlink" id="articles"><a>Articles</a></li>
					  <li class="navlink" id="history"><a>My History</a></li>
					</ul>
				<div class="btn-group pull-right">
					<a class="btn btn-primary btn-small" id="auth-loginlink" href="#">Facebook Login</a>
				</div>
				<div class="pull-right">
					<ul class="nav">
						<li class="navlink" id="about"><a href="#">About</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid" id="container-articles">
		<div class="row-fluid">
			<div class="span9">
				<div class="lead-wrapper">
					<p><?php if (isset($_GET[article])){echo 'Article '.$_GET[article];} ?></p>
					<p><?php if (isset($_GET[keyword])){echo 'Keyword '.$_GET[keyword];} ?></p>
					<p><?php if (isset($_GET[author])){echo 'Author '.$_GET[author];} ?></p>
					<p class="lead">Your one stop shop for Tech Industry News & Trends</p>
				</div>
				<div>
					<ul class="nav nav-tabs" id="articletabs">
						<li class="disabled" id="1"><a href="#">RECOMMENDED</a></li>
						<li class="active" id="2">
							<a href="#">POPULAR</a>
						</li>
						<li id="3"><a href="#">TRENDING</a></li>
						<li id="4"><a href="#">RECENT</a></li>
						<li id="5"><a href="#">NEWEST</a></li>
					</ul>
				</div>
				<div id="articlelist">
				</div>
			</div>
			<div class="span3">
				<div>
					<h4>Get Personalized!</h4>
					<small>Sign-in with your Facebook account to get personalized recommendations!</small>
				</div>
				<div>
					<h4>Trending Keywords</h4>
					<table class="table" id="topkeywords">
					</table>
				</div>
				<div>
					<h4>Popular Authors</h4>
					<table class="table" id="topauthors">
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" id="container-article">
		<div class="row-fluid">
			<div class="span9">
				<p class="lead" id="articletitle"></p>
				<div id="articlecontent"></div>
			</div>
			<div class="span3">
				<div>
					<h4>Author</h4>
					<table class="table" id="articleauthor">
					</table>
				</div>
				<div>
					<h4>Keywords</h4>
					<table class="table" id="articlekeywords">
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" id="container-keyword">
		<div class="row-fluid">
			<div class="span9">
				<p class="lead" id="displaykeyword"></p>
				<div id="keywordarticles"></div>
			</div>
			<div class="span3">
				<div>
					<h4>Top Authors</h4>
					<table class="table" id="keywordauthors">
					</table>
				</div>
				<div>
					<h4>Relevant Keywords</h4>
					<table class="table" id="relatedkeywords">
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="container-author">
		<div class="row-fluid">
			<div class="span9">
				<p class="lead" id="authorname"></p>
				<div id="authorarticles"></div>
			</div>
			<div class="span3">
				<div>
					<h4>Keyword Mentions</h4>
					<table class="table" id="authorkeywords">
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="container-history">
		<div class="row-fluid">
			<div class="span9">
				<p class="lead" id="historytitle">Your Activity History</p>
				<div id="historylist"></div>
			</div>
			<div class="span3">
				<div>
					<h4>Never lose an article again!</h4>
					<small>Log-in with Facebook to have TechGenius track what you read and share, easily searchable with simple filters.</small>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="container-about">
		<div class="row-fluid">
			<div class="span9">
				<p class="lead" id="abouttitle">About TechGenius</p>
			</div>
			<div class="span3">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<span class="pull-right"><small>Copyright TechGenius</small></span>
			</div>
		</div>
	</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>
<script>
$(document).ready(function(){
	loadarticles('2');
	loadtopkeywords();
	loadtopauthors();
	makearticletabsclickable();
	$('.brand').click(function(){
		$('.navlink').removeClass('active');
		$('.nav #articles').addClass('active');
		hidecontainers();
		$('#container-articles').show();
	});
	$('.navlink').click(function(){
		var id= $(this).attr('id');
		$('.navlink').removeClass('active');
		$(this).addClass('active');
		hidecontainers();
		$('#container-'+id).show();
		var urlString='/techgenius/'+id;
		history.pushState("", "", urlString);
	});
	
   
  window.twttr = (function (d,s,id) {
	var t, js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
	js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
	return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
  }(document, "script", "twitter-wjs"));
  
  
   FB.init({
     appId  : '205929832871771',
     status: true, // check login status
     cookie: true, // enable cookies to allow server to access session,
     xfbml: true, // enable XFBML and social plugins
     oauth: true, // enable OAuth 2.0
   });
   
	// respond to clicks on the login and logout links
	$('#auth-loginlink').click(function(){
	  FB.login(function(){},{scope:'email,publish_actions,user_likes,user_work_history'});
	});
	$('#auth-logoutlink').click(function(){
	  FB.logout();
	});
  
});
</script>
</body>
</html>