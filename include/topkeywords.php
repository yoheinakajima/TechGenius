
<?php
include_once('../functions/mysql.php');

if(isset($_POST[aid])){
	$aid=$_POST[aid];
	$keywordArray=loadkeywords($aid);
	$wrapperid='articlekeywords';
} else if(isset($_POST[authorid])){
	$authorid=$_POST[authorid];
	$keywordArray=loadauthorkeywords($authorid);
	$wrapperid='authorkeywords';
} else if(isset($_POST[kid])){
	$kid=$_POST[kid];
	$keywordArray=loadrelatedkeywords($kid);
	$wrapperid='relatedkeywords';
} else {
	$keywordArray=loadtopkeywords();
	$wrapperid='topkeywords';
}
$i=0;
foreach($keywordArray as $keyword){ 
$i++;
?>
 	
	<tr class="keywordinlist" <?php if($i>5){echo 'style="display:none"';} ?>>
		<td><a class="displaykeyword" id="<?php echo $keyword[kid];?>" href="#"><?php echo $keyword[displaykeyword]; ?></a>
		<?php if($wrapperid=='topkeywords'){ ?><div class="pull-right change"><?php echo round($keyword[increase],1); ?> &#9650;</div><?php } ?>
		<?php if(isset($_POST[authorid]) OR isset($_POST[kid])){ ?><div class="pull-right"><?php echo $keyword[score]; ?></div><?php } ?>
		
		</td>
		
	</tr>

<?php } 

if($i>5){ ?>
<tr>
	<td><a class="pull-right showmorekeywords" id="<?php echo $wrapperid;?>"><small>Show More Keywords</small></a></td>
</tr>
<?php } ?>
<script>
$(document).ready(function(){
	makekeywordsclickable();
	$('.showmorekeywords').click(function(){
		$(this).hide();
		var wrapperid=$(this).attr('id');
		$('#'+wrapperid+' .keywordinlist').show();
	});
});
</script>