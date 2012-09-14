<?php

function insertaction($actiontype,$userid,$cookieid,$aid,$numval,$stringval){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	mysql_query("INSERT INTO actions2 (actiontype,starttime,userid,cookieid,aid,numval,stringval) VALUES ('$actiontype',NOW(),'$userid','$cookieid','$aid','$numval','$stringval')");
	mysql_close($con);	
}

function loadarticle($aid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result=mysql_query("SELECT a.title AS title,
								a.aid AS aid,
								a.content AS content,
								a.url AS url,
								authors.name AS authorname,
								authors.id AS authorid
						FROM 	articles AS a,
								authors
						WHERE 	a.aid=$aid
						AND 	authors.id=a.creator");
	$row=mysql_fetch_array($result);
	return $row;
}

function loadtopkeywords(){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	
	$result = mysql_query("	SELECT 	k.kid AS kid,
									k.displaykeyword AS displaykeyword,
									COUNT(*)-(SELECT AVG(kd.freq) FROM keyworddaily AS kd WHERE kd.kid=k.kid AND DATEDIFF(NOW(),kd.date_added)<6) AS increase
							FROM	augarticles AS a,
									articlehaskeyword AS ak,
									keywords AS k
							WHERE 	HOUR(TIMEDIFF(a.date_added, NOW()))<24
							AND		a.aid=ak.aid
							AND		ak.kid=k.kid
							GROUP BY k.kid
							ORDER BY increase DESC
							LIMIT 40
							");
	$keywordArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($keywordArray,$row);
	}
	mysql_close($con);	
	return $keywordArray;
}
function loadkeywords($aid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	
	$result = mysql_query("	SELECT 	k.kid AS kid,
									k.displaykeyword AS displaykeyword
							FROM	articlehaskeyword AS ak,
									keywords AS k
							WHERE 	$aid=ak.aid
							AND		ak.kid=k.kid
							GROUP BY k.kid
							");
	$keywordArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($keywordArray,$row);
	}
	mysql_close($con);	
	return $keywordArray;
}
function loadauthorkeywords($authorid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	k.kid AS kid,
									k.displaykeyword AS displaykeyword,
									COUNT(*) AS score
							FROM	articles AS a,
									articlehaskeyword AS ak,
									keywords AS k
							WHERE 	a.creator=$authorid
							AND		a.aid=ak.aid
							AND		ak.kid=k.kid
							GROUP BY k.kid
							ORDER BY score DESC
							");
	$keywordArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($keywordArray,$row);
	}
	mysql_close($con);	
	return $keywordArray;
}
function loadrelatedkeywords($kid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	k2.kid AS kid,
									k2.displaykeyword AS displaykeyword,
									SUM(kkd.freq) AS score
							FROM 	keywords AS k1,
									keywords AS k2,
									keywordkeyworddaily AS kkd
							WHERE 	(k1.kid='$kid'
							AND		k1.kid=kkd.kid1
							AND		k2.kid=kkd.kid2)
							AND     DATEDIFF(kkd.date_added,NOW())<30
							GROUP BY k2.kid
							ORDER BY score DESC
							");
	$keywordArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($keywordArray,$row);
	}
	mysql_close($con);	
	return $keywordArray;
}

function loadpopulararticles(){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname,
										(pow((HOUR(TIMEDIFF(NOW(),a.date_added))+1),0.5)) AS mult,
										aa.score/(pow((HOUR(TIMEDIFF(NOW(),a.date_added))+1),0.5)) AS score
								FROM 	augarticles AS aa,
										articles AS a, 
										sourcedata, 
										authors
								WHERE 	DATEDIFF(NOW(),a.date_added)>7
								AND		aa.aid=a.aid
								AND		sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								ORDER BY aa.score/mult  DESC, a.date_added DESC,  a.aid 
								DESC LIMIT 50
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	
	mysql_close($con);	
	return $articleArray;
}
function loadtrendingarticles(){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname,
										aa.score/pow((HOUR(TIMEDIFF(NOW(),a.date_added))+1),0.1) AS score
								FROM 	augarticles AS aa,
										articles AS a, 
										sourcedata, 
										authors
								WHERE 	HOUR(TIMEDIFF(NOW(),a.date_added))<24
								AND		aa.aid=a.aid
								AND		sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								ORDER BY score  DESC, a.date_added DESC,  a.aid 
								DESC LIMIT 50
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	
	mysql_close($con);	
	return $articleArray;
}

function loadnewarticles(){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname,
										COUNT(*) AS score
								FROM 	articles AS a, 
										articlehaskeyword AS ak,
										sourcedata, 
										authors
								WHERE 	HOUR(TIMEDIFF(NOW(),a.date_added))<6
								AND		sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								AND		a.aid=ak.aid
								GROUP BY a.aid
								ORDER BY score DESC, a.date_added DESC,  a.aid 
								DESC LIMIT 50
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	
	mysql_close($con);	
	return $articleArray;
}

function loadnewestarticles(){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname
								FROM	articles AS a,
										sourcedata, 
										authors
								WHERE 	sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								GROUP BY a.aid
								ORDER BY a.date_added DESC,  a.aid 
								DESC LIMIT 200
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	mysql_close($con);	
	return $articleArray;
}

function loadkeywordarticles($kid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname
								FROM	articlehaskeyword AS ak,
										articles AS a, 
										sourcedata, 
										authors
								WHERE 	ak.kid=$kid
								AND		a.aid=ak.aid
								AND		sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								GROUP BY a.aid
								ORDER BY a.date_added DESC,  a.aid 
								DESC LIMIT 50
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	mysql_close($con);	
	return $articleArray;
}
function loadauthorarticles($authorid){
	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	$result = mysql_query("	SELECT 	a.title AS title,
										a.aid AS aid,
										a.content AS content,
										a.imgurl AS imgurl,
										DATEDIFF(NOW(),a.date_added) AS daysago,
										HOUR(TIMEDIFF(NOW(),a.date_added)) AS hoursago,
										MINUTE(TIMEDIFF(NOW(),a.date_added)) AS minutesago,
										sourcedata.name AS sourcename,
										authors.name AS authorname
								FROM	articles AS a, 
										sourcedata, 
										authors
								WHERE 	a.creator=$authorid
								AND		sourcedata.id=a.sourceid
								AND 	authors.id=a.creator 
								GROUP BY a.aid
								ORDER BY a.date_added DESC,  a.aid 
								DESC LIMIT 50
								");
	$articleArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($articleArray,$row);
	}
	mysql_close($con);	
	return $articleArray;
}

function loadtopauthors(){

	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	
	$result = mysql_query("	SELECT 	au.id AS id,
									au.name AS name,
									SUM(a.readcount) AS count
							FROM	augarticles AS a,
									authors AS au
							WHERE 	HOUR(TIMEDIFF(a.date_added, NOW()))<(24*7)
							AND		a.creator=au.name
							AND		au.id<>173
							AND		au.id<>90
							GROUP BY au.id
							ORDER BY count DESC
							LIMIT 40
							");
	
	$authorsArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($authorsArray,$row);
	}
	mysql_close($con);	
	return $authorsArray;
}
function loadarticleauthor($aid){

	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	
	$result = mysql_query("	SELECT 	au.id AS id,
									au.name AS name
							FROM	articles AS a,
									authors AS au
							WHERE 	a.aid=$aid
							AND		a.creator=au.id
							AND		au.id<>173
							AND		au.id<>90
							");
	
	$authorsArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($authorsArray,$row);
	}
	mysql_close($con);	
	return $authorsArray;
}
function loadkeywordauthors($kid){

	$con=mysql_connect("projectkiki.db.4477134.hostedresource.com", "projectkiki", "Goda07yo") or die(mysql_error());
	mysql_select_db("projectkiki") or die(mysql_error());
	
	$result = mysql_query("	SELECT 	au.id AS id,
									au.name AS name,
									COUNT(*) AS count
							FROM	articles AS a,
									articlehaskeyword AS ak,
									authors AS au
							WHERE 	HOUR(TIMEDIFF(a.date_added, NOW()))<(24*7)
							AND		ak.kid=$kid
							AND		a.aid=ak.aid
							AND		a.creator=au.id
							AND		au.id<>173
							AND		au.id<>90
							GROUP BY au.id
							ORDER BY count DESC
							LIMIT 40
							");
	
	$authorsArray = array();
	while ($row=mysql_fetch_array($result)){
		array_push($authorsArray,$row);
	}
	mysql_close($con);	
	return $authorsArray;
}
?>