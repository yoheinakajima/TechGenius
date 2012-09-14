<script>
$('#articletabs li').off('click');
</script>
<?php
require('../functions/mysql.php');


if ($_POST[val]==1){
	$articleArray=Array();
?>
<div class="hero-unit">
  <h3>TechGenius is smarter than your intern.</h3>
  <p>Get personalized recommendations of articles to read, trends to follow, and authors to reach out to. All you have to do is create an account.</p>
  <p>
    <a class="btn btn-primary btn-large">
      Learn more
    </a>
  </p>
</div>
<div class="row-fluid">
	<div class="span4">
		<h5>Never lose an article again.</h5>
		<small>Once you sign-up, TechGenius will track every article you read, share, and tweet. Custom filters make it easy for you to find any article you've ever read, like the one you Tweeted last week, what was it again?</small>
	</div>
	<div class="span4">
		<h5>Find out who your favorite authors are.</h5>
		<small>TechGenius automatically identifies your favorite authors based on what you read and share. A great way for entrepreneurs to identify press contacts they should reach out to.</small>
	</div>
	<div class="span4">
		<h5>Super Smart Recommendations.</h5>
		<small>TechGenius combines a number of complex algorithms to make personalized article recommendations for every logged-in user.</small>
	</div>
</div>
<?php
} else if ($_POST[val]==2){
	$articleArray=loadpopulararticles();
} else if ($_POST[val]==3){
	$articleArray=loadtrendingarticles();
} else if ($_POST[val]==4){
	$articleArray=loadnewarticles();
} else if ($_POST[val]==5){
	$articleArray=loadnewestarticles();
} else if (isset($_POST[kid])){
	$kid=$_POST[kid];
	$articleArray=loadkeywordarticles($kid);
} else if (isset($_POST[authorid])){
	$authorid=$_POST[authorid];
	$articleArray=loadauthorarticles($authorid);
}

foreach($articleArray as $article){ 
	?>
	<div class="row-fluid articleinlist" id="<?php echo $article[aid];?>">
		<div class="span10">
			<div class="row-fluid">
				<div class="span2">
					<div class="articlescore" style="display:none"><?php echo round($article[score],1);?></div>
					<?php if (!empty($article[imgurl])){ ?>
						<img src="<?php echo $article[imgurl];?>" />
					<?php } else { ?>
						<img src="http://www.any-data-recovery.com/images/public/article.png" />
					<?php } ?>
				</div>
				<div style="span10">
					<a href="#" id="<?php echo $article[aid] ;?>" class="articletitle"><?php echo $article[title] ;?></a>
					<p class="articleteaser"><?php echo substr(strip_tags($article[content]),0,200);?>...</p>
				</div>
			</div>
		</div>
		<div class="span2" style="text-align:right"><small><?php echo $article[sourcename] ;?></small></div>
	</div>
<?php } ?>

<script>
	makearticlesclickable();
	makearticletabsclickable();
</script>