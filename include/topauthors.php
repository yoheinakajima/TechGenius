
<?php
include_once('../functions/mysql.php');
if(isset($_POST[aid])){
	$aid=$_POST[aid];
	$authorsArray=loadarticleauthor($aid);
	$wrapperid='articleauthor';
} else if(isset($_POST[kid])){
	$kid=$_POST[kid];
	$authorsArray=loadkeywordauthors($kid);
	$wrapperid='keywordauthors';
} else {
	$authorsArray=loadtopauthors();
	$wrapperid='topauthors';
}
$i=0;
foreach($authorsArray as $author){ 
$i++;
?>
 	
	<tr class="authorinlist" <?php if($i>5){echo 'style="display:none"';} ?>>
		<td><a class="authorname" id="<?php echo $author[id];?>" href="#"><?php echo $author[name]; ?></a>
		<?php if ($wrapperid=='topauthors' OR $wrapperid=='keywordauthors'){ ?><div class="pull-right change"><?php echo round($author[count],1); ?> &#9650;</div></td><?php } ?>
	</tr>

<?php } 

if($i>5){ ?>
<tr>
	<td><a class="pull-right showmoreauthors" id="<?php echo $wrapperid;?>"><small>Show More Authors</small></a></td>
</td>
<?php } ?>
<script>
$(document).ready(function(){
	makeauthorsclickable();
	$('.showmoreauthors').click(function(){
		$(this).hide();
		var wrapperid=$(this).attr('id');
		$('#'+wrapperid+' .authorinlist').show();
	});
});
</script>