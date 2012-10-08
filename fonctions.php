<?php

function mod_ordo($do,$calendarium) {
	$bb.="<h3>Ordo</h3>";
	$datelatin=date_latin($do);
	$bb.="<b>Liturgie pour :</b> $datelatin";
	$bb.="<br><b>Temps liturgique :</b> ".$calendarium['tempus'][$do];
	$bb.="<br><b>Semaine :</b> ".$calendarium['hebdomada'][$do];
	if($calendarium['intitule'][$do]) $bb.="<br><b>".$calendarium['intitule'][$do]."</b>";
	if($calendarium['rang'][$do]) $bb.="<br><b >Rang : </b>".$calendarium['rang'][$do];
	$bb.="<br><b>Couleur des ornements :</b> ".$calendarium['couleur_template'][$do];
	$bb.="<br><b>Semaine du psautier :</b> ".$calendarium['hebdomada_psalterium'][$do];
	$bb.="<br>";
//$bb.= "<i>".$calendarium['vita'][$do]."</i>";
$bb=utf($bb);
print"</table>";
print $bb;
}

function connect_db() {
/*
$linkwp=mysql_connect("192.168.193.231", "fxp", "fxp")
    or die("Impossible de se connecter : " . mysql_error());
$db_selected = mysql_select_db('wordpress', $linkwp);
if (!$db_selected) die ('Impossible de sélectionner la base de données WP : ' . mysql_error());
  /// CONNEXION BDD MYSQL PAR DEFAUT
 /*
  $dbdata=explode("/",$GLOBALS['db_url']);
  $dbserver=$dbdata[2];
  $db=explode("@",$dbserver);
  $dbaddress=$db[1];
  $db_=explode(":",$db[0]);
  $dbuser=$db_[0];
  $dbpassword=$db_[1];
  $dbname=$dbdata[3];
  $link = mysql_connect($dbaddress, $dbuser,$dbpassword)
    or die("Impossible de se connecter : " . mysql_error());
  $db=mysql_select_db($dbname); 
  return $link;
*/
}

function ordo($ordo,$ref,$lang) {
    
	return $output;
}

function datets($jour) {
if(!$jour) $jour=$_GET['jour'];
if(!$jour) $jour=$_GET['date'];
if(!$jour) $jour=date("Ymd",time());
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$date_ts=mktime(12,0,0,$mense,$die,$anno);

//print"<br>Jour=".$jour;
$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
//print"<br> Jour de la semaine : ".$jours_l[date('w',$date_ts)];
$date['ts']=$date_ts;
$date['AAAAMMJJ']=$jour;
return $date;
}

function date_latin($j) {
	if($j==null) $j=time();
 $mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
 $jours = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
 $date= $jours[@date("w",$j)]." ".@date("j",$j)." ".$mois[@date("n",$j)-1]." ".@date("Y",$j);
 return $date;
}

function affiche_tableau($tableau,$office) {
	if($office=="laudes") {
		$t="
		<table>
		<th>Psautier</th>
		<th>Temporal</th>
		<th>Propre</th>
		<th>Special</th>";
		$t.="
		<tr>
		<td>".$tableau['matin']['psalterium']."</td>
		<td>".$tableau['matin']['ferie']."</td>
		<td>".$tableau['matin']['propre']."</td>
		<td>".$tableau['matin']['special']."</td>";
		$t.="</table>";
	}
	return $t;

}

function get_date($date,$calendarium) {
if(!$date) $date=$_GET['date'];
if(!$date) $date=date("Ymd",time());
$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$date_ts=mktime(12,0,0,$mense,$die,$anno);
$output=strftime("%A %#d %B %Y",$date_ts);

$output.="<br>".$calendarium['intitule'][$date];
/*//print_r($calendarium);
*/	
	
	return $output;
	
}

function rougis_verset($string) {
$string1=str_replace("V/.", "<font color=red>V/.</font>",$string);
$string2= str_replace("R/.", "<font color=red>R/.</font>",$string1);
$string3= str_replace("", "<font color=red></font>",$string2);
$string4= str_replace("*", "<font color=red>*</font>",$string3);
$string5= str_replace("]", "<font color=red>]</font>",$string4);
$string6= str_replace("[", "<font color=red>[</font>",$string5);
$string7= str_replace("†", "<font color=red>†</font>",$string5);
return $string7;
}

function lectio($ref) {
//$prefixe="http://gregorien.radio-esperance.fr/";
	$row = -1;
	$fp = @fopen ($prefixe."calendrier/liturgia/$ref.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	$row++;
	  $latin=nl2br($data[0]);
		if ($lang=="fr") $verna=nl2br($data[1]);
		if ($lang=="en") $verna=nl2br($data[2]);
		if ($lang=="ar") $verna=nl2br($data[3]);
		
		if($row==0){		
		$lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$verna</td>";
			}
			   
		elseif($row==1) {
		$lectio.="
		<tr><td id=\"colgauche\"><center><font color=red>$latin</font></center></td><td id=\"coldroite\"><center><font color=red>$verna</font></center></td>";
		}
		elseif($row==2) {
		$lectio.="
		<tr><td id=\"colgauche\"><center><font color=red><i>$latin</i></font></center></td><td id=\"coldroite\"><center><font color=red><i>$verna</i></font></center></td>";
		}
		else {
		$lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$verna</td>";	
		}
	}	
 
	@fclose ($fp);
	return $lectio;
}

function modificationes($messe,$lang) {
           $option=$_GET['option'];
$row = 0;
$ref=no_accent($ref);
$ref="sources/".$ref.".csv";
$fp = fopen ($ref,"r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    //$messe[$id];
	    if($lang=="fr")$verna=$data[4];
	    if($lang=="en")$verna=$data[5];
	    if($lang=="ar")$verna=$data[6];
		}    
	   
	    $modificationes.="
		<div id=\"gauche\">$latin".affiche_editeur($ref,"lat")."</div>
		<div id=\"droite\">$verna".affiche_editeur($ref,$lang)."</div>";	
		$row++;	

	@fclose ($fp);
	return $modificationes;
}


function recitatif  ($ref,$lang) {
  $option=$_GET['option'];
$row = 0;
$ref=no_accent($ref);
$ref="sources/".$ref.".csv";
$fp = @fopen ($ref,"r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];
	    if($lang=="fr")$verna=$data[1];
	    if($lang=="en")$verna=$data[2];
	    if($lang=="ar")$verna=$data[3];
	    
	   
	    $recitatif.="
		<div id=\"gauche\">$latin".affiche_editeur($ref,"lat")."</div>
		<div id=\"droite\">$verna".affiche_editeur($ref,$lang)."</div>";	
		$row++;	
	}
	@fclose ($fp);
	return $recitatif;
}


function ordinaire_messe($ordinaire,$ref,$lang) {
       $ordi.="
		<div id=\"gauche\">".nl2br($ordinaire[$ref]['lat'])."</div>
		<div id=\"droite\">".nl2br($ordinaire[$ref]['verna'])."</div>";
		return $ordi;
}



function lectiobrevis($ref,$lang) {
//$prefixe="http://gregorien.radio-esperance.fr/";
$option=$_GET['option'];
$ref=no_accent($ref);
$refL="wp-content/plugins/liturgia/sources/".$ref.".xml" ;
$xml = simplexml_load_file($refL) or die("Error: Cannot create object : $refL");
//print"<br>OPEN : "."sources/".$ref.".csv";
foreach($xml->children() as $ligne){
	$o=$ligne->xpath('@id');
	$la=$ligne->xpath('la');
	$ver=$ligne->xpath($lang);
//	print"<br>".$o[0];
	if($o[0]==0) {
	$lectio.= "<div id=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></div><div id=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></div>";
	}
	else {
	$lectio.= "<div id=\"gauche\">".$la[0]."</div><div id=\"droite\">".$ver[0]."</div>";
	}
}
/*
$option=$_GET['option'];
$row = 0;
$ref=no_accent($ref);
$refL="sources/".$ref.".csv";
$fp = @fopen ($refL,"r","1");
$lectio="
	<div id=\"gauche\">".affiche_editeur($refL,"lat")."</div>
	<div id=\"droite\">".affiche_editeur($refL,$lang)."</div>
	";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];
	    if($lang=="fr")$verna=$data[1];
	    if($lang=="en")$verna=$data[2];
	    
	    if($row==0) {
			$latin="<center><b><font color=red>$latin</font></b></center>";
			$verna="<center><b><font color=red>$verna</font></b></center>";
			if($lang=="en") $verna="<center><b><font color=red>$verna</font></b></center>";
		}
	    $lectio.="
		<div id=\"gauche\">$latin</div>
		<div id=\"droite\">$verna</div>";	
		$row++;	
	}
	@fclose ($fp);
	return $lectio;
	*/
	return $lectio;
}

function preces($ref,$lang) {
	$option=$_GET['option'];
	$ref=no_accent($ref);
	$ref="sources/propres/office/".$ref.".xml";
	$xml = simplexml_load_file("sites/all/modules/liturgia/".$ref);
//print"<br>OPEN : "."sources/".$ref.".csv";
$la=$xml->xpath('la');
$ver=$xml->xpath($lang);
$preces="
	<div id=\"gauche\">".affiche_editeur($ref,"lat")."</div>
	<div id=\"droite\">".affiche_editeur($ref,$lang)."</div>
	";
	$preces.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	$preces.="<div id=\"gauche\"><fontalign=center color=red>Preces ".$num." </font>".$la['0'].affiche_editeur_propre('ant1',$refL,'lat')."</div>";
	$preces.="<div id=\"droite\"><font color=red>Prières litaniques. ".$num."</font> ".$ver[0]."  ".affiche_editeur_propre('ant1',$refL,$lang)."</div>";
			
	return $preces;

}

function antienne($ref,$lang,$num) {
$option=$_GET['option'];
$ref=no_accent($ref);
//$prefixe="http://gregorien.radio-esperance.fr/";

$refL="wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
$xml = simplexml_load_file($refL) or die("Erreur : ".$refL);
//print"<br>OPEN : "."sources/".$ref.".csv";
$la=$xml->xpath('la');
$ver=$xml->xpath($lang);
$antienne="
	<div id=\"gauche\">".affiche_editeur("sources/propres/office/".$ref.".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/propres/office/".$ref.".xml",$lang)."</div>
	";	
	$antienne.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	$antienne.="<div id=\"gauche\"><font color=red>Ant. ".$num." </font>".$la['0']."</div>";
	$antienne.="<div id=\"droite\"><font color=red>Ant. ".$num."</font> ".$ver['0']."</div>";
	return $antienne;
}

function reponsbref($ref,$lang) {
$option=$_GET['option'];
//$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$ref="sources/propres/office/".$ref.".xml";
$xml = simplexml_load_file($prefixe."wp-content/plugins/liturgia/".$ref) or die ("erreur : "."wp-content/plugins/liturgia/".$ref);
//print"<br>OPEN : "."sources/".$ref.".csv";
//print_r($xml);
$la=@$xml->xpath('la');
$ver=@$xml->xpath($lang);

$reponsbref="
   	<div id=\"gauche\"><font color=red><center><b>Responsorium Breve</b></font></div>
	<div id=\"droite\"><font color=red><center><b>Répons bref</b></center></font></div>
	<div id=\"gauche\">".affiche_editeur($ref,"la")."</div>
	<div id=\"droite\">".affiche_editeur($ref,$lang)."</div>
	";
	$reponsbref.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	$reponsbref.="<div id=\"gauche\">".nl2br($la['0'])."</div>";
	$reponsbref.="<div id=\"droite\">".nl2br($ver['0'])."</div>";
	return $reponsbref;
}



function hymne($ref,$lang,$mp3) {
$row = 0;
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="wp-content/plugins/liturgia/sources/".$ref.".xml";
//print"<br>";
//print_r($_SERVER);
//print "<br>".$refL;
$xml = simplexml_load_file($refL) or die("Error: Cannot create object : $refL");

//print"<br>OPEN : "."sources/".$ref.".csv";

$hymne="
	<div id=\"gauche\">".affiche_editeur("sources/".$ref.".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/".$ref.".xml",$lang)."</div>
	";
	$hymne.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	
	
	foreach(@$xml->children() as $ligne){
	$o=@$ligne->xpath('@id');
	$la=@$ligne->xpath('la');
	$ver=@$ligne->xpath($lang);
//	print"<br>".$o[0];
	if($o[0]==0) {
	$hymne.= "<div id=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></div><div id=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></div>";
	}
	elseif($la[0]==null) $hymne.= "<div id=\"gauche\">&nbsp;</div><div id=\"droite\">&nbsp;</div>";
	
	else	$hymne.= "<div id=\"gauche\"><center>".$la[0]."</center></div><div id=\"droite\"><center>".$ver[0]."</center></div>";
	}

	return $hymne;
}


function antienne_messe($ref,$lang) {
$option=$_GET['option'];
if(!$lang) $lang="fr";
$ref=trim($ref);
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="wp-content/plugins/liturgia/sources/propres/messe/".$ref.".xml";
//print"<br>";
//print_r($_SERVER);
//print "<br>".$refL;
if($_GET['debug']==1) $antiennemesse.="
<div id=\"gauche\">".$ref."</div>
<div id=\"droite\">".$ref."</div>
";
$xml = @simplexml_load_file($refL); // or die("Error: Cannot create object : $refL");
if(!$xml) print" - Référence : ".$ref." -> <a href=\"javascript:affichage_popup('?task=creation&comment=".$ref."','affichage_popup');\">Création</a>";

//print"<br>OPEN : "."sources/".$ref.".csv";
$antiennemesse.="</center>";
$antiennemesse.="
	<div id=\"gauche\">".affiche_editeur("sources/propres/messe/".$ref.".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/propres/messe/".$ref.".xml",$lang)."</div>
	";
	$antiennemesse.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	
	
foreach(@$xml->children() as $ligne){
	$o=@$ligne->xpath('@id');
	$la=@$ligne->xpath('la');
	$ver=@$ligne->xpath($lang);
//	print"<br>".$o[0];
	if($o[0]==0) {
	$antiennemesse.= "
	<div id=\"titre-antienne-lat\">".$la[0]."</div>
	<div id=\"titre-antienne-ver\">".$ver[0]."</div>";
	}
	elseif($o[0]==1) {
	$antiennemesse.= "
	<div id=\"gauche\"><i>".$la[0]."</i></div>
	<div id=\"droite\"><i>".$ver[0]."</i></div>";
	}
	elseif($la[0]==null) {
	$antiennemesse.= "
	<div id=\"gauche\">&nbsp;</div>
	<div id=\"droite\">&nbsp;</div>";
	}
	else	{
	$antiennemesse.= "
	<div id=\"gauche\">".$la[0]."</div>
	<div id=\"droite\">".$ver[0]."</div>";
	}
}
return $antiennemesse;
}

function affiche_editeur($ref,$lang) {
	/* Verification
		1 - des droits de l'utilisateur
		2 - de l'éditabilité du contenu concerné.
	*/
	$q=$_GET['q'];
	$auth=true;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	if ($_GET['option']=="edit") $verif=(true);
	// code à compéter.
	if ($verif) { // contenu éditable et droits de l'utilisateur OK.
		$editeur=" &nbsp; <A HREF=\"javascript:affichage_popup('?option=edit&affiche=1&task=edit&lang=$lang&ref=$ref','affichage_popup');\">$ref <b>éditer</b></A>";
	}	
	return $editeur;	
}

/*
function affiche_editeur_propre($id,$ref,$lang) {
	/* Verification
		1 - des droits de l'utilisateur
		2 - de l'éditabilité du contenu concerné.
	*/
/*
	$q=$_GET['q'];
	$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	if ($_GET['option']=="edit") $verif=(true);
	// code à compéter.
	if ($verif) { // conteu éditable et droits de l'utilisateur OK.
		$editeur=" &nbsp; <A HREF=\"javascript:affichage_popup('?q=$q&task=edit_propre&id=$id&lang=$lang&ref=$ref','affichage_popup');\">éditer</A>";
	}
	
	return $editeur;
	
}
*/


function edit_content() {
	$auth=true;
//if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	$q=$_GET['q'];
	$edit_content.="
	<form method='post' action='?q=$q&task=maj&ref=$ref&lang=$lang'>
	<textarea name='miseajour' cols=\"45\" rows=\"12\">";
	$xml = simplexml_load_file("wp-content/plugins/liturgia/".$ref) or die("erreur : $ref");
	$re=explode("/",$ref);
	$r=$re[count($re)-1];
	$r = str_replace(".xml", null, $r);
	//print_r($xml);
	//foreach($xml->children() as $ligne){
	//$o=$ligne->xpath('@id');
	$content=$xml->xpath($lang);
	if(!$content) {
	//print "antienne de messe";
	foreach ($xml->children() as $item) { 
		$el=$item->xpath($lang);
		$edit_content.=trim($el[0])."\r";
		}
	}
	//print_r($xml);
	//$ver=$xml->xpath($lang);
	//print_r($ligne);
	//$la=$ligne->xpath('la');
	//$content=$ligne;
	//$content=$xml->la;
	//}
	//print_r($content);
	$edit_content.=trim($content[0])."\r";	
	//$edit_content.=$content;
	/*
	$fp = fopen (no_accent($ref),"r","1") ; //or die ("<br>Erreur ouverture fichier : ".$ref);
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		if($lang=="lat") $cont=$data[0];
    if($lang=="fr") $cont=$data[1];
		if($lang=="en") $cont=$data[2];
		if($lang=="ar") $cont=$data[3];
		$edit_content.=$cont."\n";
		
	}*/
	//print"<br>$ref CONTENT : ".$content;
	//@fclose ($fp);	
	$edit_content.="</textarea>
	<INPUT type=\"submit\" value=\"Envoyer\" \">
	</form>
	";
	//ONCLICK=\"window.close()
	print $edit_content;
	exit();
}

function edit_content_propre() {
	$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	$id=$_GET['id'];
	$q=$_GET['q'];
	$refL="sources/".no_accent($ref);
	$edit_content_propre.="
	<form method='post' action='?q=$q&task=maj_propre&id=$id&ref=$ref&lang=$lang'>
	<textarea name='miseajour' cols=\"45\" rows=\"12\">";
	$fp = fopen ("$refL","r","1");  //or die ("<br>Erreur ouverture fichier : ".$refL);
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $i=$data[0];
	    $edit[$i]['lat']=$data[1];
	    $edit[$i]['mode']=$data[2];
	    $edit[$i]['mp3']=$data[3];
	    $edit[$i]['fr']=$data[4];
	    $edit[$i]['en']=$data[5];
	    $edit[$i]['ar']=$data[6];
	    $row++;
	}
	
	@fclose ($fp);	
	$edit_content_propre.=$edit[$id][$lang]."</textarea>
	<INPUT type=\"submit\" value=\"Envoyer\" ONCLICK=\"window.close()\">
	</form>
	";
	print $edit_content_propre;
	exit();
}

function maj_content($miseajour,$userid) {
  	$link=connect_db();
	//$linkwp=mysql_connect("192.168.193.231", "fxp", "fxp")
    //or die("Impossible de se connecter : " . mysql_error());
	$db_selected = mysql_select_db('wordpress', $linkwp);
	if (!$db_selected) die ('Impossible de sélectionner la base de données WP : ' . mysql_error());
	$ref=$_GET['ref'];
	$ref="wp-content/plugins/liturgia/".$ref;
	$lang=$_GET['lang'];
	if($lang=="lat") $miseajour=creation_accents($miseajour);
	$datets=time();
	  //global $current_user;
      //global $current_user;
      //get_currentuserinfo();
/*
      echo 'Username: ' . $current_user->user_login . "\n";
      echo 'User email: ' . $current_user->user_email . "\n";
      echo 'User first name: ' . $current_user->user_firstname . "\n";
      echo 'User last name: ' . $current_user->user_lastname . "\n";
      echo 'User display name: ' . $current_user->display_name . "\n";
      echo 'User ID: ' . $current_user->ID . "\n";
	  */
	  //get_currentuserinfo();
	  $miseajour=addslashes($miseajour);
	$q="insert into liturgia_ed(user,ref_texte,lang,nouveau_texte,date_ts) values('$userid','$ref','$lang','$miseajour','$datets') ";  
  	//print "<br>".$q;
	  $r=mysql_query($q,$linkwp) or die ("requete echouee ".mysql_error()." ".$q);
	  print"<br>Mise à jour effectuée. Votre proposition sera validée prochainement.";
	  	mysql_close($linkwp);
	  exit();
	
}

function maj_content_propre($miseajour) {
  $link=connect_db();
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	$id=$_GET['id'];
	$datets=time();
	$user=  $GLOBALS['user']->uid;
	if($lang=="lat") $miseajour=creation_accents($miseajour);
	$miseajour=addslashes($miseajour);
	$q="insert into liturgia_ed(user,ref_texte,id_texte,lang,nouveau_texte,date_ts) values('$user','$ref','$id','$lang','$miseajour','$datets') ";  
  $r=mysql_query($q,$link) or die ("requete echouee ".mysql_error()." ".$q);
  mysql_close($link);
  
}

function lecture_messe($ref,$lang) {

     $refL="/wp-content/plugins/liturgia/sources/propres/messe/lectures/LEC_".no_accent($ref).".xml";
	 $xml = @simplexml_load_file(get_bloginfo('wpurl').$refL); // or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 $ref="LEC_".no_accent($ref);
	 if(!$xml) print" - Référence : ".$ref." -> <a href=\"javascript:affichage_popup('?task=creation&comment=".$ref."','affichage_popup');\">Création</a>";

print"<br>OPEN : ".$refL;
	$LM.="
	<div id=\"gauche\">".affiche_editeur("sources/propres/messe/lectures/".no_accent($ref).".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/propres/messe/lectures/".no_accent($ref).".xml",$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	//	print"<br>".$o[0];
		if($o[0]==0) {
		$LM.= "
		<div id=\"gauche\"><i>".$la[0]."</i></div>
		<div id=\"droite\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$LM.= "
		<div id=\"gauche\">".$la[0]."</div>
		<div id=\"droite\">".$ver[0]."</div>";
		}
	}
	 /*
     $fp=@fopen($refL,"r","1");
      
     $row=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	if (($row==0)&&($data[0]!="")) {
		$latin=$data[0];		
			if($lang=="fr") $verna=$data[1];
			if($lang=="en") $verna=$data[2];
			if($lang=="ar") $verna=$data[3];
			$data[0]="";
	}
	else {
	    $latin=$data[0];
	    if ($lang=="fr") $verna=$data[1];
	    if ($lang=="en") $verna=$data[2];
	    if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
	  }
	    $LM .="
	   <div id=\"gauche\">$latin</div>
	   <div id=\"droite\">$verna</div>";
  	 $row++;
    }
	*/
     $LM .="
	   <div id=\"gauche\">Verbum Domini. R/. Deo gratias.</div>";
	   if ($lang=="fr") $LM.="<div id=\"droite\">Parole du Seigneur. R/. Rendons grâces à Dieu.</div>";
	   if ($lang=="en") $LM.="<div id=\"droite\">Word of the Lord. R/. Thanks be to God.</div>";
    return $LM;
}


function lecture_vigiles($ref,$lang,$ordre) {
$option=$_GET['option'];
$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="sources/propres/OSB_Vigiles/".$ref;
$fp = @fopen ($prefixe.$refL,"r","1");

 /*
	$antienne_messe.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
*/		
		$id=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    
	    $lecture[$id]['latin']=$data[0];
	    if ($lang=="fr") $lecture[$id]['verna']=$data[1];
	    if ($lang=="en")  $lecture[$id]['verna']=$data[2];
	    if ($lang=="ar")  $lecture[$id]['verna']=$data[3];
	    $id++;
		}
	  @fclose ($fp); 
	  
	  
	  $lecture_vigiles="
		<div id=\"gauche\" align=\"center\" ><font color=red>Lectio $ordre</font> ".affiche_editeur($refL,'lat')."</div>
		<div id=\"droite\" align=\"center\"><font color=red>Lecture $ordre</font> ".affiche_editeur($refL,$lang)."</div>";
        $lecture_vigiles.="
		<div id=\"gauche\"><i>".$lecture['0']['latin']."</i></div>
		<div id=\"droite\"><i>{$lecture['0']['verna']}</i></div>  ";
		$d=1;
		while($d<=$id) {
		$lecture_vigiles.="
		<div id=\"gauche\">".$lecture[$d]['latin']."</div>
		<div id=\"droite\">".$lecture[$d]['verna']."</div>  ";
		$d++;
		}
	return $lecture_vigiles;
}

function creation_accents($texte) {
	$voyelles_sans_accent = array("+","'a", "'i", "'o", "'u", "a'e", "'y", "'A", "'I", "'O", "'U", "A'E","'Y");
	$voyelles_avec_accent = array("†","á", "í", "ó", "ú", "ǽ", "ý", "Á", "Í", "Ó", "Ú", "Ǽ","Ý");
	$texte_final = str_replace($voyelles_sans_accent, $voyelles_avec_accent, $texte);
	return $texte_final;
}

function repons_vigiles($ref,$lang,$ordre) {
$option=$_GET['option'];
$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="sources/propres/OSB_Vigiles/".$ref;
$fp = @fopen ($prefixe.$refL,"r","1");

 /*
	$antienne_messe.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
*/		
		$id=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    
	    $repons[$id]['latin']=$data[0];
	    if ($lang=="fr") $repons[$id]['verna']=$data[1];
	    if ($lang=="en")  $repons[$id]['verna']=$data[2];
	    if ($lang=="ar")  $repons[$id]['verna']=$data[3];
	    $id++;
		}
	  @fclose ($fp); 
	  
	  $repons_vigiles="
		<div id=\"gauche\" align=\"center\" ><font color=red>Responsorium $ordre</font> ".affiche_editeur($refL,'lat')."</div>
		<div id=\"droite\" align=\"center\"><font color=red>Répons $ordre</font> ".affiche_editeur($refL,$lang)."</div>";
    
    $d=0;
	while($d<=$id) {
		$repons_vigiles.="
		<div id=\"gauche\">".$repons[$d]['latin']."</div>
		<div id=\"droite\">".$repons[$d]['verna']."</div>  ";
		$d++;
	}
	
	return $repons_vigiles;
}


function evangile_vigiles($ref,$lang) {
$prefixe="http://gregorien.radio-esperance.fr/";
     $refL="sources/propres/messe/lectures/EV_".$ref.".csv";
     $fp = fopen ($prefixe.$refL,"r","1");
     $row=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	if (($row==0)&&($data[0]!="")) {
		$latin=$data[0];		
			if($lang=="fr") $verna=$data[1];
			if($lang=="en") $verna=$data[2];
			if($lang=="ar") $verna=$data[3];
			$data[0]="";
	}
	else {
	    $latin=$data[0];
	    if ($lang=="fr") $verna=$data[1];
	    if ($lang=="en") $verna=$data[2];
	    if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
	  }
	    $LM .="
	   <div id=\"gauche\">$latin</div>
	   <div id=\"droite\">$verna</div>";
  	 $row++;
    }
     $LM .="
	   <div id=\"gauche\">R/. Amen.</div>";
	   if ($lang=="fr") $LM.="<div id=\"droite\">R/. Amen.</div>";
    return $LM;
}

function evangile($ref,$lang) {
	 //$refL="sources/propres/messe/lectures/".$ref.".csv";
     $refL="/wp-content/plugins/liturgia/sources/propres/messe/lectures/EV_".no_accent($ref).".xml";
	 $xml = @simplexml_load_file(get_bloginfo('url').$refL); // or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	//if(!$xml) print" - Référence : ".$ref." -> <a href=\"javascript:affichage_popup('?task=creation&comment=".$ref."','affichage_popup');\">Création</a>";
	$ref="EV_".no_accent($ref);
	if(!$xml) print" - Référence : ".$ref." -> <a href=\"javascript:affichage_popup('?task=creation&comment=".$ref."','affichage_popup');\">Création</a>";
print"<br>OPEN : ".$refL;
	$LM.="
	<div id=\"gauche\">".affiche_editeur("sources/propres/messe/lectures/".no_accent($ref).".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/propres/messe/lectures/".no_accent($ref).".xml",$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	//	print"<br>".$o[0];
		if($o[0]==0) {
		$LM.= "
		<div id=\"gauche\"><i>".$la[0]."</i></div>
		<div id=\"droite\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$LM.= "
		<div id=\"gauche\">".$la[0]."</div>
		<div id=\"droite\">".$ver[0]."</div>";
		}
	}
     $LM .="
	   <div id=\"gauche\">Verbum Domini. R/. Laus tibi Christe.</div>";
	   if ($lang=="fr") $LM.="<div id=\"droite\">Parole du Seigneur. R/. Louange à Toi, ô Christ.</div>";
    return $LM;
}

function paroles($ref) {
  $s=explode("_",$ref);
  $type=$s[0];
  if($type=="IN") $output = antienne_messe($ref,$lang);
  if($type=="OF") $output = antienne_messe($ref,$lang);
  if($type=="CO") $output = antienne_messe($ref,$lang);
  if($type=="GR") $output = antienne_messe($ref,$lang);
  if($type=="AL") $output = antienne_messe($ref,$lang);
  if($type=="TR") $output = antienne_messe($ref,$lang);
  if($type=="SEQ") $output = antienne_messe($ref,$lang);
  if($type=="HY") $output = hymne($ref);
  if ($output) return $output;
  else return "Ce texte n'est pas disponible pour le moment. Pour nous à aider à rendre disponible ce texte, vous pouvez vous inscire sur le site web. D'avance merci.";
}


function psaume($ref,$lang) {
$row = 0;
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="wp-content/plugins/liturgia/sources/".$ref.".xml";

$xml = simplexml_load_file($refL) or die("Error: Cannot create object : $refL");

//print"<br>OPEN : "."sources/".$ref.".csv";

$psaume="
	<div id=\"gauche\">".affiche_editeur("sources/".$ref.".xml","la")."</div>
	<div id=\"droite\">".affiche_editeur("sources/".$ref.".xml",$lang)."</div>
	";
	$psaume.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	
	
	foreach($xml->children() as $ligne){
	$o=$ligne->xpath('@id');
	$la=$ligne->xpath('la');
	$ver=$ligne->xpath($lang);
//	print"<br>".$o[0];
	if($o[0]==0) {
	$psaume.= "<div id=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></div><div id=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></div>";
	}
	elseif 	($o[0]==1) {
	$psaume.= "<div id=\"gauche\"><center><font color=red>".$la[0]."</font></center></div><div id=\"droite\"><center><font color=red>".$ver[0]."</font></center></div>";
	}
	
	elseif 	($o[0]==2) {
	$psaume.= "<div id=\"gauche\"><center><i>".$la[0]."</i></center></div><div id=\"droite\"><center><i>".$ver[0]."</i></center></div>";
	}
	
	elseif 	($o[0]==3) {
	$psaume.= "<div id=\"gauche\"><center><font color=red><b>".$la[0]."</b></font></div><div id=\"droite\"><center><font color=red><b>".$ver[0]."</b></font></div>";
	}
	else {
	$psaume.= "<div id=\"gauche\">".$la[0]."</div><div id=\"droite\">".$ver[0]."</div>";
	}
}

	
	  
		


/*
$fp = fopen ($refL,"r","1");
$psaume="
	<div id=\"gauche\">".affiche_editeur($refL,"lat")."</div>
	<div id=\"droite\">".affiche_editeur($refL,$lang)."</div>
	";

	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    if ($row==0) {
			$latin="<b><center><font color=red>$data[0]</font></b></center>";
			 if($lang=="fr") $verna="<b><center><font color=red>$data[1]</b></font></center>";
			if($lang=="en") $verna="<b><center><font color=red>$data[2]</b></font></center>";
			if($lang=="ar") $verna="<b><center><font color=red>$data[3]</b></font></center>";
			$data[0]="";
	    }
	    elseif (($row==1)&&($data[0]!="")) {
	        $latin="<center><font color=red>$data[0]</font></center>";
	        if($lang=="fr") $verna="<center><font color=red>$data[1]</font></center>";
		if($lang=="en") $verna="<center><font color=red>$data[2]</font></center>";
		if($lang=="ar") $verna="<center><font color=red>$data[3]</font></center>";
	        $data[0]!="";
	    }
	    elseif (($row==2)&&($data[0]!="")) {
	        $latin="<center><i>$data[0]</i></center>";
	        if($lang=="fr") $verna="<center><i>$data[1]</i></center>";
		if($lang=="en") $verna="<center><i>$data[2]</i></center>";
		if($lang=="ar") $verna="<center><i>$data[3]</i></center>";
	        $data[0]="";
	    }
	    elseif (($row==3)&&($data[0]!="")) {
	        $latin="<center><font color=red><b>$data[0]</b></font></center>";
	        if ($lang=="fr") $verna="<center><font color=red><b>$data[1]</b></font></center>";
		if ($lang=="en") $verna="<center><font color=red><b>$data[2]</b></font></center>";
		if ($lang=="ar") $verna="<center><font color=red><b>$data[3]</b></font></center>";
	        $data[0]="";
	    }
	    else {
	    $latin=$data[0];
	    if ($lang=="fr") $verna=$data[1];
	    if ($lang=="en") $verna=$data[2];
	    if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
	    }
   
  //if($latin!="")	
  $psaume .="
	<div id=\"gauche\">$latin</div>
	<div id=\"droite\">$verna</div>";
  	$row++;
	}
	if($ref!="AT41") $psaume.=doxologie($lang);

	@fclose ($fp);
	//print $psaume;
	*/
	if($ref!="AT41") $psaume.=doxologie($lang);
	$psaume=rougis_verset($psaume);
	$psaume=utf($psaume);
	return $psaume;
}
function doxologie($lang) {
	$fp = fopen ("sources/doxologie.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna=$data[1];
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		
		if($latin!="") $doxologie.="
		<div id=\"gauche\">$latin</div>
		<div id=\"droite\">$verna</div>";
  	$row++;
	}
	@fclose ($fp);
	return $doxologie;
}

function initium($mp3,$lang) {
	$initium.="
	<div id=\"gauche\">".mp3Player($mp3)."&nbsp;</div>
	<div id=\"droite\">&nbsp;</div>";
	$fp = fopen ("sources/initium.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna=$data[1];
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		
		if($latin!="") $initium.="
		<div id=\"gauche\">$latin</div>
		<div id=\"droite\">$verna</div>";
  	}
	@fclose ($fp);
	
	return $initium;
}

function utf($string) {
$string1=str_replace("é", "&eacute;",$string);
$string2= str_replace("è", "&egrave;",$string1);
$string3= str_replace("ê", "&ecirc;",$string2);
$string4= str_replace("ú", "&uacute;",$string3);
$string5= str_replace("ù", "&ugrave;",$string4);
$string6= str_replace("û", "&ucirc;",$string5);
$string7= str_replace("í", "&iacute;",$string6);
$string8= str_replace("î", "&icirc;",$string7);
$string9= str_replace("ï", "&iuml;",$string8);
$string10= str_replace("á", "&aacute;",$string9);
$string11= str_replace("à", "&agrave;",$string10);
$string12= str_replace("â", "&acirc;",$string11);
$string13= str_replace("æ", "&aelig;",$string12);
$string14= str_replace("ó", "&oacute;",$string13);
$string15= str_replace("ô", "&ocirc;",$string14);
$string16= str_replace("", "&oelig;",$string15);
$string17= str_replace(" ", "&nbsp;",$string16);
$string18= str_replace("", "&#146;",$string17);
$string19= str_replace("«", "&#171;",$string18);
$string20= str_replace("»", "&#187;",$string19);
$string21= str_replace("ç", "&ccedil;",$string20);
$string22= str_replace("ë", "&euml;",$string21);
$string23= str_replace("-", "-",$string22);
$string24= str_replace("ý", "&yacute;",$string23);
$string25= str_replace("°", "e",$string24);
//$string26= str_replace("Æ", "&Aelig;",$string25);
$string26= str_replace("", "&#8224;",$string25);
$string27= str_replace("É", "&Eacute;",$string26);
$string28= str_replace("", "&#151;",$string27);
$string29= str_replace("œ", "&#x153;",$string28);
return $string29;

}

function toUTF8($string){
$from = mb_detect_encoding($string);
if ($from != 'UTF-8') {
$string = mb_convert_encoding($string, 'UTF-8', $from);
}
}

function pater($lang) {
	$row=0;	
$fp = fopen ("sources/pater.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna=$data[1];
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		
		if($row==0) $pater="<div id=\"gauche\"><font color=red><center><b>$latin</b></center></font></div><div id=\"droite\"><font color=red><center><b>$verna</b></center></font></div>";
		elseif ($latin!="") $pater.="<div id=\"gauche\">$latin</div>  <div id=\"droite\">$verna</div>";
		
		$row++;
  	}
	@fclose ($fp);
	return $pater;	
}
function renvoi ($mp3,$lang) {
	$fp = fopen ("sources/renvoi.csv","r","1");
	$r=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna="$data[1]";
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		if($r==9) $renvoi.="
	<div id=\"gauche\">".mp3Player($mp3)."</div>";
	$renvoi.="<div id=\"droite\">&nbsp;</div>";
		if($latin!="") $renvoi.="
		<div id=\"gauche\">$latin</div>
		<div id=\"droite\">$verna</div>";
  	$r++;
	}
	@fclose ($fp);
	
	return $renvoi;
}





function no_accent($str_accent) {
   $pattern = Array("/ /","/Æ/","/é/", "/è/", "/ê/", "/ç/", "/æ/","/à/", "/á/", "/í/", "/ï/", "/ù/", "/ó/","/ú/","/,/","/__/","/:/");
   // notez bien les / avant et après les caractères
   $rep_pat = Array("_","A","e", "e", "e", "c", "ae","a", "a", "i", "i", "u", "o", "u","_","_",null,null);
   $str_noacc = preg_replace($pattern, $rep_pat, $str_accent);
   $str_noacc=trim($str_noacc,"_");
   $str_noacc = preg_replace($pattern, $rep_pat, $str_noacc);
   $str_noacc = str_replace("*", null, $str_noacc);
   $str_noacc = str_replace("?", null, $str_noacc);
   $str_noacc=trim($str_noacc);
   $str_noacc=str_replace("__", "_", $str_noacc);
   return $str_noacc;
}
function outputCSV($list,$file) {
	//$fichiercsv="sites/all/modules/liturgia/".$file;
	$fp = fopen($file, 'c+') ; 
	//if (!$fp) 
	foreach ($list as $fields) {
	fputcsv($fp, $fields, ';');
	}
	fclose($fp);
	return $outputCSV;
}

function ref_player($office,$piece,$date,$tableau) {
	$dj="matin"; if ($office=="vepres") $dj="soir";
	$anno=substr($date,0,4);
	$mense=substr($date,4,2);
	$die=substr($date,6,2);
	
	$tempus=$tableau[$dj]['temps'];
	switch ($tempus) {
		case "Tempus Adventus":
		$ref_player="HG/TO_Noel/4-Avent";
		if (($mense=="12")&&($die<17)) {
			$ref_player.="/1- Adv jusque 16dec";	
		}
		if (($mense=="12")&&($die>16)) {
			$ref_player.="/2- Adv a partir 17dec";
		}
		break;
		
		case "Tempus Nativitatis":
		$ref_player="HG/TO_Noel";	
		break;

		case "Tempus per annum":
		$ref_player="HG/TO_Noel";	
		break;

		case "Tempus Quadragesimae":
		$ref_player="HG/Careme_Temps-pascal/1-Careme";	
		break;

		case "Tempus Paschale":
		$ref_player="HG/Careme_Temps-pascal/2-Temps pascal";	
		break;	
	}	
	
	
	
	return $ref_player;
}
function mp3Playerjs($ref) {
	$playerjs=<<<END

END;
return $playerjs;
}
function mp3Player ($ref) {
	if($ref=="") return null;
$player= <<< END
<embed src="$ref" width="50" height="40" autostart="false" loop="false"></embed>
</object>
END;

return $player;	
}



function affiche_nav($date,$office) {
    
    //INITIALISATION
  $jour=datets("");
  $date=$jour['AAAAMMJJ'];
  $lang=$_GET['lang'];
  $option=$_GET['option'];
  $task=$_GET['task'];
	$q=$_GET['q'];
		
	
  if(!$task) $task="affiche";
  if(!$lang) $lang=fr;
    
    
    $offices=array("p","invitatoire","osb_vigiles","Lectures","laudes","tierce","sexte","none","vepres","complies","s");

    for($o=0;$offices[$o];$o++) {	 
      if ($office==$offices[$o]) {
	$officeactuel=$o;
	break;
      }
    }
  
$suivant = $offices[$officeactuel+1]; $precedent = $offices[$officeactuel-1];

$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
//print"<br> day = ".$day;
if($day==-1) $day=time();
//$dts=mktime(12,0,0,$mense,$die,$anno);
$dtsmoinsun=$day-60*60*24;
$dtsplusun=$day+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);

$dsuiv=$day+60*60*24;
$dprec=$day-60*60*24;

$date_suiv=$do;
$date_prec= $do;
if ($suivant=="s") {
	$suivant = "invitatoire";
	$date_suiv=date("Ymd",$dsuiv);
}

if ($precedent=="p") {
	$precedent = "complies";
	$date_prec= date("Ymd",$dprec);
}
$nav.="<center> <a href=?affiche=1&lang=fr&option=$option&date=$date&office=$office&task=$task>Français</a> - <a href=?affiche=1&lang=en&option=$option&date=$date&office=$office&task=$task>English</a> - <a href=?affiche=1&lang=ar&option=$option&date=$date&office=$office&task=$task>عربي</a></center>";

$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;

//if ($auth) 
global $current_user;
get_currentuserinfo();
if($current_user->user_login) {
$nav.="<p><center> 
<a href=?affiche=1&lang=$lang&option=edit&date=$date&office=$office&mois_courant=$mense>Editer</a>"; /* | 
<a href=?affiche=1&lang=$lang&option=correction_ordo&date=$date&office=$office&mois_courant=$mense>Correction de l'ordo</a>
*/
}
print"</center>";

$nav.="<center><a href=\"?affiche=1&date=$hier&office=$office&mois_courant=$mense&an=$anno&lang=$lang\"><<</a>|";
$nav.="<a href=\"?affiche=1&date=$date_prec&office=$precedent&mois_courant=$mense_prec&an=$anno_prec&lang=$lang&option=$option&task=$task\"><</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=invitatoire&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Invitatoire</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=osb_vigiles&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Vigiles (OSB) </a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=lectures&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Lectures</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=laudes&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Laudes</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=tierce&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Tierce</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=messe&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Messe</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=sexte&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Sexte</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=none&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">None</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=vepres&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Vêpres</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=complies&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Complies</a>|";
$nav.="<a href=\"?affiche=1&date=$date_suiv&office=$suivant&mois_courant=$mense_suiv&an=$anno_suiv&lang=$lang&option=$option&task=$task\">></a>|";
$nav.="<a href=\"?affiche=1&date=$demain&office=$office&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\"> >></a></center>";
return $nav;
}

function oraison($latin,$verna,$lang,$ref,$id) {
    
	$oraison.="
	<div id=\"gauche\"><font color=red><center>Oratio.".affiche_editeur($ref,"lat")."</center></font></div>";
	     
	if($lang=="fr") {$oraison.="<div id=\"droite\"><font color=red><center>Oraison.".affiche_editeur($ref,$lang)."</center></font>".affiche_editeur($ref,$lang)."</div>";
	} 
	  
	if ((substr($latin,-14))==" Per Dóminum.") {
		$latin=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
		if ($lang=="fr") $verna.=" Par notre Seigneur Jésus-Christ, Ton Fils, qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
     
	if ((substr($latin,-11))==" Qui tecum.") {
	        $latin=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
	    	if ($lang=="fr") $verna.=" Lui qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}

	if ((substr($latin,-11))==" Qui vivis.") {
	        $latin=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
	    	if ($lang=="fr") $verna.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
	    
	$oraison.="<div id=\"gauche\">".$latin."</div>";
	$oraison.="<div id=\"droite\">$verna </div>";

  return $oraison;
}

function oratio($ref,$lang) {

$option=$_GET['option'];
$ref=no_accent($ref);
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="wp-content/plugins/liturgia/sources/propres/xml/".$ref.".xml";
$xml = simplexml_load_file($refL) or die("Erreur : ".$refL);
//print"<br>OPEN : "."sources/".$ref.".csv";
$la=$xml->xpath('la');
$ver=$xml->xpath($lang);
$oratio="
	<div id=\"gauche\">".affiche_editeur($ref,"la")."</div>
	<div id=\"droite\">".affiche_editeur($ref,$lang)."</div>
	";	
	$oratio.="
		<div id=\"gauche\">".mp3Player($mp3)."</div>
		<div id=\"droite\">&nbsp;</div>";
	$oratio.="<div id=\"gauche\">".$la['0']."</div>";
	$oratio.="<div id=\"droite\">".$ver['0']."</div>";

	return $oratio;

}

function collecte($ref,$lang) {
	$oraison.="
	<div id=\"gauche\"><font color=red><center>Oratio.".affiche_editeur($ref,"la")."</center></font></div>";
	     
	if($lang=="fr") {
		$oraison.="<div id=\"droite\"><font color=red><center>Oraison.".affiche_editeur($ref,$lang)."</center></font>".affiche_editeur($ref,$lang)."</div>";
	} 
	  
	$refL="wp-content/plugins/liturgia/sources/propres/xml/".$ref.".xml";
	$xml = simplexml_load_file($refL) or die("Erreur : ".$refL);
	//print"<br>OPEN : "."sources/".$ref.".csv";
	$la=$xml->xpath('la');
	$ver=$xml->xpath($lang); 
	
	  
	if ((substr($la[0],-14))==" Per Dóminum.") {
		$la[0]=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
		if ($lang=="fr") $ver[0].=" Par notre Seigneur Jésus-Christ, Ton Fils, qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
     
	if ((substr($la[0],-11))==" Qui tecum.") {
	    $la[0]=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
	    if ($lang=="fr") $ver[0].=" Lui qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}

	if ((substr($la[0],-11))==" Qui vivis.") {
	    $la[0]=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
	    if ($lang=="fr") $ver[0].=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
	    
	$oraison.="<div id=\"gauche\">".$la['0']."</div>";
	$oraison.="<div id=\"droite\">".$ver['0']."</div>";  

  return $oraison;
}


function connect_zenon() {
	/*
    $dbaddress="192.168.193.1";
    $dbuser="writer";
    $dbpassword="writer";
    $dbname="zenon32";
    $link = @mysql_connect($dbaddress, $dbuser,$dbpassword)
    or die("Impossible de se connecter : " . mysql_error());
    $db=@mysql_select_db($dbname); 
    return $link;
    */
}

function titre_dans_base_zenon ($ref){
     $link = connect_zenon();
     //$refB=substr($ref, 0, 9);
     $q="SELECT * FROM t_rotation t where NUM_TYPE=3 and COMMENT LIKE '$ref'";
     //print"<br>".$q;
     $r=mysql_query($q) or die ("Erreur : $q ".mysql_error());
     $i=0;
     while ($row=mysql_fetch_object($r)) {
        
        $q2="SELECT * FROM t_gema t where NUM_rotation=$row->NUM_ROTATION";
        //print"<br>".$q2;
        $r2=mysql_query($q2);
        $rs=mysql_fetch_object($r2);  
        $sacem[$i]=$rs;
        $titre[$i]=$row;
        $i++;
     }
     $result[titre]=$titre;
     $result[sacem]=$sacem;
     return $result;
     
}

function affiche_infotitre($ref) {
    //if(!$ref) return;
    //print"<br>INFOTITRE";
   
     $result=titre_dans_base_zenon($ref);
      
      
     $i=0;
     $inf="<table><tr>
     <th>Choeur</th>
     <th>Titre</th>
     <th>Direction</th>
     <th>Contexte liturgique</th>
     <th>Album</th>
      <th>Label</th>
      <th>Réf. du label</th>      
     </tr>
     ";
     while($result[titre][$i]) {
     $pic=$result[titre][$i]->PICTURE;
     $pic = str_replace("\\","/",$pic); 
     
     $inf.="<tr><td>{$result[titre][$i]->NAME}</td>
     <td>{$result[titre][$i]->TITLE}</td>
     <td>{$result[titre][$i]->ROTA_PERFORMER1}</td>
     <td>{$result[titre][$i]->S1}</td>
     <td>{$result[sacem][$i]->NUTZUNG}</td>
     <td>{$result[sacem][$i]->KOMPO}</td>  
     <td>{$result[sacem][$i]->LCM}</td>    
     </tr>
     ";   
      $i++;
     }
     $inf.="</table>";
     print $inf;
     exit();
}

function creation_xml($ref) {
$url=get_bloginfo('wpurl');
	print"
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\" dir=\"ltr\">
  <head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
 
	</head>";
	print"<form method=POST action='?task=enregistreXML&comment=".$ref."'>";
	print"<br> : $ref";
	print"<textarea name='enregistre' cols=\"45\" rows=\"12\">";
	print"</textarea>";
	print"<input type=submit value=OK>";
	print"</form>";
	exit();
}


function enregistre_xml($ref) {
	$emplacement="wp-content/plugins/liturgia/sources/".$ref.".xml";
	if(substr($ref,0,3)=="AN_") {
	$emplacement="wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
	}
	if(substr($ref,0,4)=="LEC_") {
	$emplacement="wp-content/plugins/liturgia/sources/propres/messe/lectures/".$ref.".xml";
	}
	if(substr($ref,0,3)=="EV_") {
	$emplacement="wp-content/plugins/liturgia/sources/propres/messe/lectures/".$ref.".xml";
	}
	if(substr($ref,0,4)=="RESP") {
	$emplacement="wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
	}
	
	if((substr($ref,0,3)=="IN_")||(substr($ref,0,3)=="GR_")||(substr($ref,0,3)=="AL_")||(substr($ref,0,3)=="SEQ")||(substr($ref,0,3)=="OF_")||(substr($ref,0,3)=="TR_")||(substr($ref,0,3)=="OF_")||(substr($ref,0,3)=="CO_")) {
	$emplacement="wp-content/plugins/liturgia/sources/propres/messe/".$ref.".xml";	
	}
	$content=$_POST['enregistre'];
	$output="
	<liturgia> 
	<ligne id=\"0\">
	<la>
	</la>
	</ligne>
	<ligne id=\"1\">
	<la>
	</la>
	</ligne>
	<ligne id=\"2\">
	<la>".$_POST['enregistre']."
	</la>
	</ligne>
	</liturgia>	
	";
	$output=creation_accents($output);
	$sxe = new SimpleXMLElement($output);
	$sxe->asXML($emplacement);
	print $output;
	print"<br>".$emplacement;
exit();
}

function mod_calendarium($mois,$an) {
//print "calendrier";

$date=$_GET['date'];
$lang=$_GET['lang'];

if(!$lang) $lang="fr";

if(!$mois) $mois=$_GET['mois'];
if(!$mois) $mois=date("m",time());

if (!$an) $an=$_GET['an'];
if(!$an) $an=date("Y",time());

if(!date) {
$date=date("Ymd", @mktime(0, 0, 0, $mois, 1,$an));
}

if (!$date) {
   $date=date("Ymd",time());
}

$date_ts=mktime(12,0,0,$mois,1,$an);

$file="wp-content/plugins/liturgia/calendrier/".date("Y-n",$date_ts).".xml";
$xml = simplexml_load_file($file);

if ($lang=="la") {
$men= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
$do="Do.";
$f2="F.2";
$f3="F.3";
$f4="F.4";
$f5="F.5";
$f6="F.6";
$sa="Sa.";
//$calendarium="";
}
if ($lang=="fr") {
$men= array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$do="Dim";
$f2="Lun";
$f3="Mar";
$f4="Mer";
$f5="Jeu";
$f6="Ven";
$sa="Sam";
//$calendarium="";
}

//print_r($men);

if($mois=="13") {
	$mois=1;
	$an++;
}
if($mois=="0") {
	$mois=12;
	$an--;
}

$s=0;$i=1;$sem=array();
while(date("m",$date_ts)==$mois) {
	$jour=date("w",$date_ts);

	$sem[$s][$jour]=$i;
	if ($jour==6) { $jour=0; $s++;}
 	//print"[$s|$jour]=$i";
	$i++;
	$date_ts=$date_ts+60*60*24;

}

$coul['Rouge']="#ff0000";
$coul['Vert']="#1b6f1f";
$coul['Blanc']="#ffeda6";
$coul['Violet']="#6b0d24";
$coul['Rose']="#d1a8a8";
$coul['Noir']="#000000";

	$an_plus=$an;
	$an_moins=$an;
    $mois_moins=$mois-1;
    $mois_plus=$mois+1;
	if($mois_plus==13) {$mois_plus=1; $an_plus=$an+1; }
	if($mois_moins==0) {$mois_moins=12; $an_moins=$an-1; }
	
$calendarium="<div align=center>
<table style=\"text-align: center; font-size:15px; margin:2px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"3\">
<tr><td style=\"color: black;\"><a href=\"".get_bloginfo('wpurl')."/".get_titre()."/?mois=$mois_moins&an=$an_moins\">&lt;&lt;</a></td>
      <td style=\"text-align: center;\" colspan=\"5\" rowspan=\"1\"><a href=\"".get_bloginfo('wpurl')."/".get_titre()."?mois=$mois&an=$an\">".$men[$mois-1]." $an</a></td>
      <td style=\"color: black;\"><a href=\"".get_bloginfo('wpurl')."/".get_titre()."/?mois=$mois_plus&&an=$an_plus\">&gt;&gt;</a></td></tr>
  <tbody><tr >
  <td style=\"color: #777;\"><b>$do</b></td>
  <td style=\"color: #777;\">$f2</td>
  <td style=\"color: #777;\">$f3</td>
  <td style=\"color: #777;\">$f4</td>
  <td style=\"color: #777;\">$f5</td>
  <td style=\"color: #777;\">$f6</td>
  <td style=\"color: #777;\">$sa</td>
  </tr>";

	for ($u=0;$u<6;$u++) { // boucle semaines
		
    $calendarium.="<tr>";
    $f=$sem[$u][0];
    $jour_ts=@mktime(12,0,0,$mois,$f,$an);
   
	$url="/".$GLOBALS['wp']->request;
   
    $jour=@date("Ymd",$jour_ts);
	$req="//jour[@date='".$jour."']";
	$result=$xml->xpath($req);
    $iff=(string) $result[0]->couleur;
	//print"<br>"; print_r($result[0]->intitule);
	$titre=(string) $result[0]->intitule->fr;
	if($lang=="la") $titre=(string) $result[0]->intitule->la;
	$coloris=$coul[$iff];
	//print"<br>".$jour." ".$req." ".$iff." "; //print_r($result);
	 $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";	
//	print"<br>".$couleur_fonte;
	if($f!="")    {
		$calendarium.="
		<td style=\" background-color: $coloris;  font-weight:700; text-align: center;  text-decoration: none;\">
		<a style=\"color: #000000; text-decoration: none;\"  href=\"?date=$jour&mois=$mois&an=$an\" title=\"$titre\">
		<font color=\"$couleur_fonte\">$f</font></a></td>";
		}
	else $calendarium.="<td style=\" color: #000000; text-align: center; text-decoration: none;\"></td>";
	
	for($n=1;$n<7;$n++) { // boucle jours
	$f=$sem[$u][$n];
    $jour_ts=@mktime(12,0,0,$mois,$f,$an);
    $jour=@date("Ymd",$jour_ts);
	$req="//jour[@date='".$jour."']";
	$result=$xml->xpath($req);
    $iff=(string) $result[0]->couleur;
	$titre=(string) $result[0]->intitule->fr;
	if($lang=="la") $titre=(string) $result[0]->intitule->la;
	//print"<br>".$jour." ".$req." ".$iff." "; //print_r($result);
	///
	//print_r($result);
			///
    $coloris=$coul[$iff];
    $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";
	//print"<br>".$couleur_fonte;
    //$titre=$calend['intitule'][$jour];
	  if($f!="") {
	  $calendarium.="
	  <td style=\" background-color: $coloris; text-align: center; text-decoration: none;\">
	  <a style=\"color: #000000; text-decoration: none;\" href=\"?date=$jour&mois=$mois&an=$an\" title=\"".$titre."\">
	  <font color=\"$couleur_fonte\">$f</font></a></td>
	  ";
      }
	else {
	$calendarium.="<td style=\" text-align: center;  text-decoration: none;\"></td>";
	   }

	} // fin boucle jours
} // fin boucle semaines


    $calendarium.="   
  </tbody>
</table>
</div>
";

return $calendarium;

}


function affichage() {
 global $current_user;
get_currentuserinfo();

// Calcul du jour;
//if($_SERVER[SERVER_ADDR]!="192.168.193.231") return;
$date=$_GET['date'];
$lang=$_GET['lang'];
$option=$_GET['option'];
$q=$_GET['q'];
//if($_GET['task']=="edit_propre") edit_content_propre();
//if($_GET['task']=="maj_propre") maj_content_propre($_POST['miseajour']);
//if($_GET['task']=="infopiece") affiche_infotitre($_GET['ref']); 

if(!$office) $office=$_GET['office'];

if (!$date) {
     $date=date("Ymd",time());
}
$calendarium=calendarium($date,$ordo);

$tableau=tableau($calendarium,$date);



if ($office=="invitatoire") { $contenu.= invitatoire($date,$calendarium,$reference,$tableau); print"</table>"; affiche_nav($date,$office); }
if ($office=="osb_vigiles") {$contenu.= osb_vigiles($date,$tableau,$calendarium); affiche_nav($date,$office);}
if ($office=="lectures") { $contenu.= lectures($date,$tableau,$calendarium,$office);  affiche_nav($date,$office);}
if ($office=="laudes") {  $contenu.= laudes($date,$tableau,$calendarium,$office); affiche_nav($date,$office); }
if ($office=="tierce") {$contenu.= tierce($date,$tableau,$calendarium);  affiche_nav($date,$office);}
if ($office=="messe") {$contenu.= messe($date,$tableau,$calendarium);  affiche_nav($date,$office);}
if ($office=="sexte") {$contenu.= sexte($date,$tableau,$calendarium);  affiche_nav($date,$office);}
if ($office=="none") {$contenu.= none($date,$tableau,$calendarium);  affiche_nav($date,$office);}
if ($office=="vepres") {$contenu.= vepres($date,$tableau,$calendarium); affiche_nav($date,$office);}
if ($office=="complies") {$contenu.= complies($date,$tableau,$calendarium); affiche_nav($date,$office);}


$couleur=$calendarium['couleur_template'][$date];

/*
$output.="
		
		<fieldset><center>
		 
		<form id=\"monForm\" action=\"?q=$q&task=setpref\" method=\"post\">
		<label>Ordo :</label>
		<SELECT name=\"livre\">
		<OPTION VALUE=\"LH\" "; if ($ordo=="LH") $output.="selected"; $output.=">Liturgia Horarum, editio typica altera, 1985, © Libreria editrice vaticana.</OPTION>
		<OPTION VALUE=\"HG\""; if ($ordo=="HG") $output.="selected"; $output.=">Les Heures Grégoriennes, 2008, © Communauté Saint Martin.</OPTION>
		<OPTION VALUE=\"AR\""; if ($ordo=="AR") $output.="selected"; $output.=">Antiphonale romanum, 2009, © Abbaye Saint Pierre de Solesmes.</OPTION>
		</SELECT>
		<input type=\"submit\" value=\"OK\">
		</form>
		</center>
		</fieldset>		
";
//}
 * 
 */

//$output.=affiche_date($jour,$calendarium);
$output.=affiche_nav($date,$office);
//$output.="</div>";
//$output.=laudes($date,$tableau,$calendarium,"laudes");
$output.=$contenu;
//$output.=$footer;
//print_r($calendarium);
//print $output;
return $output;
}



?>