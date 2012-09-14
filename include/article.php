
<?php
require('../functions/mysql.php');
$aid=$_POST[aid];
$article=loadarticle($aid);
insertaction('4','','',$aid,'','');

$sharelink = 'http://techgenius.me?article='.$aid;
$articletitle=$article['title'];
$articleurl=$article['url'];
?>
<fb:like href="<?php echo $sharelink;?>" ref="<?php echo $userid;?>" data-send="true" layout="button_count"></fb:like>
<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $articletitle; ?>" data-url="<?php echo $sharelink;?>&fb_source=twitter" data-counturl="<?php echo $sharelink;?>" data-lang="en">Tweet</a>
<?php
echo '<p>'.$article[content].'</p>';
?>
<script>
	makeauthorsclickable();
	twttr.widgets.load();
	FB.XFBML.parse();
</script>
<?php if(!empty($articleurl)){ ?>
<iframe src="<?php echo $article[url]; ?>" width=100% height='500' frameborder=1"></iframe>
<?php } ?>