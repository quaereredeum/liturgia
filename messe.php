<?php

function affiche_messe($refmesse,$tableau) {
//print"<br>MESSE";
$lang=$_GET['lang'];
if(!$lang) $lang="fr";
//if(substr_count($refmesse,"infraoctavamnativitas")) $refmesse="infraoctavamnativitas";
//print_r($tableau);
print"<br><b>refmesse = $refmesse</b>";
/*
$fp = fopen ("sources/propres/messe/messe.csv","r","1");
    //print"<br> : OPEN :"."sources/propres/".$ref.".csv";
	   while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $ordinaire_messe[$id]['lat']=$data[1];
	    if ($lang=="fr") $ordinaire_messe[$id]['verna']=$data[2];
	    if ($lang=="en") $ordinaire_messe[$id]['verna']=$data[3];
	    if ($lang=="ar") $ordinaire_messe[$id]['verna']=$data[4];
	    $ordinaire_messe[$id]['ref']="sources/propres/messe/messe.csv";
	}
	@fclose($fp);	
*/	
  /// Recherche dans la BDD des références du propre du jour.
  /*
$linkwp=mysql_connect("192.168.193.231", "fxp", "fxp")
    or die("Impossible de se connecter : " . mysql_error());
$db_selected = mysql_select_db('wordpress', $linkwp);
if (!$db_selected) die ('Impossible de sélectionner la base de données WP : ' . mysql_error());

  $q="select * from temporal_".$tableau['matin']['lettre_annee']." where celebration='".no_accent($refmesse)."'";
  //print"<br><b>$q</b>";
  $r=mysql_query($q);
	$row=mysql_fetch_object($r) or die("<br>Erreur :".$q." ".mysql_error());
	*/
/*
$ref_=strtolower("temporal_".$tableau['matin']['lettre_annee']);
$xml = simplexml_load_file("wp-content/plugins/liturgia/".$ref_.".xml");	
$propre = $xml->xpath("//".$ref_."//celebration[@id='".$refmesse."']");
//$propre = $xml->xpath("//temporal_a//celebration[@id='perannum_16-3']");
//print"<br>PROPRE : //".$ref_."//celebration[@id='".$refmesse."'] "; print_r($propre);
//temporal_A//celebration[@id='perannum_16-3']
/*	
	$xmlfile="wp-content/plugins/liturgia/sources/temporal_".$tableau['matin']['lettre_annee'].".xml";
	$xml = simplexml_load_file($xmlfile);
	$output.="<br>".$xmlfile;
	//print_r($xml);
	$output.="<table>";
	foreach ($xml->row->field->name as $element) {
	$output.="<tr>";
		$output.="<td>".$element->celebration."</td>";
		$output.="<td>".$element->IN_."</td>";
		$output.="<td>".$element->PS1."</td>";
		$output.="<td>".$element->PS2."</td>";
		$output.="<td>".$element->SEQ."</td>";
		$output.="<td>".$element->PS2."</td>";
		$output.="<td>".$element->OF."</td>";
		$output.="<td>".$element->CO."</td>";		
	$output.="</tr>";
	}
	$output.="</table>";
*/	
///////////	$q="select * from lectures_semaine_temporal where celebration='".no_accent($refmesse)."'";
  //print"<br><b>$q</b>";
//////////  $r=mysql_query($q) or die("<br> Erreur : $q ".mysql_error());
//////////	$lectures=mysql_fetch_object($r);
	//print_r($lectures);
	//print "<br>REF  =".$refmesse;	
//// INTROIT
/*
$i=0;
while($propre[$i]->IN_) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 
 $h=$i-1;
  if($h!=-1) print"<br>$i : ".$propre[$i]->IN_."| $h : ".$propre[$h]->IN_." ".($propre[$i]->IN_!=$propre[$i-1]->IN_);
 if(($propre[$i]->IN_)&&($propre[$i]->IN_!=$propre[$i-1]->IN_)) {$output.=antienne_messe($propre[$i]->IN_,$lang);
	$i++;
	}
}	
$rang=$tableau['matin']['rang'];

/// SALUTATIO
	/*
	$output.="
<div id=\"gauche\"><center><font align=center color=red>Salutatio</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Salutation</font></center></div>";
	$output.=ordinaire_messe($ordinaire_messe,"Initial",$lang);
	// acte pénitentiel
	$output.="
<div id=\"gauche\"><center><font align=center color=red>Actus paenitenialis</font></center></div>";
		if($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>Acte pénitentiel</font></center></div>";
	$output.=ordinaire_messe($ordinaire_messe,"Actus_paenitentialis",$lang);
	*/
//// KYRIE
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Kyrie</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Kyrie</font></center></div>";
   $output.=ordinaire_messe($ordinaire_messe,"Kyrie",$lang);
//// GLORIA

$output.="
<div id=\"gauche\"><center><font align=center color=red>Gloria</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Gloria</font></center></div>";
    $output.=ordinaire_messe($ordinaire_messe,"Gloria",$lang);
    
//// COLLECTE

/*
$ref=no_accent($tableau['matin']['propre']);
$output.="
	<div id=\"gauche\"><i><font color=red>Collecta :</i></font></div>
	<div id=\"droite\"><i><font color=red>Collecte :</font></i></div>";
 //$output.=oraison($messe['oratio']['lat'],$messe['oratio']['verna'],$lang,$ref,"oratio");

//// LECT1
//$ref=$messe['L1_A']['lat']; 
//print_r($tableau);
$jour=$_GET['date'];
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
//print"//celebration[@id='".$refmesse."']";
$xml = simplexml_load_file("wp-content/plugins/liturgia/lectures_semaine_temporal.xml");	
$lectures = $xml->xpath("//celebration[@id='".$refmesse."']");
print"<br>"; print_r($lectures);
/*
//print "<br>lectures[0]->LEC_1_paire=<b>".$lectures[0]->LEC_1_paire."</b>";

if($anno%2==0) {
$reflec=$lectures[0]->LEC_1_paire;
if($tableau['temps']=="Tempus Adventus") $reflec=$lectures[0]->LEC_1_impaire;
}
//print_r($tableau);
if($anno%2==1) {
$reflec=$lectures[0]->LEC_1_impaire;
if($tableau['temps']=="Tempus Adventus") $reflec=$lectures[0]->LEC_1_paire;
}

if($rang<=7) { // Messe à 3 lectures
$reflec="I_".$tableau['matin']['cel']."_".$tableau['matin']['lettre_annee'];
}
 */
 //print "<br>LEC1 = $reflec";
// $refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio I</font>";
//if($ref) $output.=" ($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>1ère lecture</font>";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>1st reading</font>";
//if ($ref) $output.=" ($ref)".affiche_editeur($refL,$lang);
$output.="</center></div>";
//$reflec=$lectures[0]->LEC_1_paire;

 $output.=lecture_messe($reflec,$lang);

//// PSAL1
//if($row->PS1)  $output.=antienne_messe($row->PS1,$lang);

//$q2="select distinct PS1 from temporal_".$tableau[matin][lettre_annee]." where celebration='".no_accent($refmesse)."' or celebration='".no_accent($refmesse)."-I' or celebration='".no_accent($refmesse)."-II'";
//print"<br>$q2";
//$r2=mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
//print $output;
/*
while($propre[$i]->PS1) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
//print"<br>row->PS1 : ".$row->PS1;
$h=$i-1;
 if($h!=-1) print"<br>$i : ".$propre[$i]->PS1."| $h : ".$propre[$h]->PS1." ".($propre[$i]->PS1!=$propre[$h]->PS1);
 if(($propre[$i]->PS1)&&($propre[$i]->PS1!=$propre[$i-1]->PS1)) {
 $output.=antienne_messe($propre[$i]->PS1,$lang);
 //$output.=antienne_messe("AL_Adorabo",$lang);
	$i++;
	}
}
//print $output;

//// LECT2
if($rang<=7) { // Messe à 3 lectures
$ref="II_".$tableau['matin']['cel']."_".$tableau['matin']['lettre_annee'];

 $refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio II</font>";
if($ref) $output.=affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>2ème lecture</font>";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>2nd reading</font>";
if ($ref) $output.=affiche_editeur($refL,$lang);
$output.="</center></div>";
$output.=lecture_messe($ref,$lang);

}


/*
$ref=$messe['L2_A']['lat'];
if($ref)  {
$refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio II</font>";
if($ref) $output.="($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>2ème lecture</font> ";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>2nd reading</font> ";
if ($ref) $output.="($ref)".affiche_editeur($refL,$lang);
$output.="</center></div>";
$output.=lecture_messe($ref,$lang);
}
*/
//// PSAL2
  
//if($row->PS2)	$output.=antienne_messe($row->PS2,$lang);

//$q2="select distinct PS2 from temporal_".$tableau[matin][lettre_annee]." where celebration='".no_accent($refmesse)."' or celebration='".no_accent($refmesse)."-I' or celebration='".no_accent($refmesse)."-II'";
//$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
//$i=0;
/*
while($propre[$i]->PS2) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
$h=$i-1;
$h=$i-1;
  if($h!=-1) print"<br>$i : ".$propre[$i]->PS2."| $h : ".$propre[$h]->PS2." ".($propre[$i]->PS2==$propre[$h]->PS2);
 if($propre[$i]->PS2 == $propre[$h]->PS2) { $output.=antienne_messe($propre[$i]->PS2,$lang);
	$i++;
	}
}





//// SEQ

if ($propre[0]->SEQ) {
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Sequentia</font></center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>Séquence</font></center></div>";
*/
/*
$output.=antienne_messe($row->SEQ,$lang);
}
//// EV

$ev="EV_".$tableau[matin][annee];
$ref=$messe[$ev]['lat'];
$ref=$lectures->EV;

if($rang<=7) {
	$ref="_".$tableau['matin']['cel']."_".$tableau['matin']['lettre_annee'];
}
$output.="
<div id=\"gauche\"><center><font align=center color=red>Evangelium</font>";
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>Evangile</font>";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>Gospel</font> ";
$output.="</center></div>";
$output.=ordinaire_messe($ordinaire_messe,"EV",$lang);
$output.=evangile($ref,$lang);
//$output.=ordinaire_messe($ordinaire_messe,"EV_fin",$lang);
//// CREDO
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Professio fidei</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Profession de foi</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"CREDO_NC",$lang);
*/
//// PU
//// OF
//if($row->OF)  $output.=antienne_messe($row->OF,$lang,"OF");
/*
$q2="select distinct OF from temporal_".$tableau[matin][lettre_annee]." where celebration='".no_accent($refmesse)."' or celebration='".no_accent($refmesse)."-I' or celebration='".no_accent($refmesse)."-II'";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->OF) $output.=antienne_messe($row2->OF,$lang);
$i++;
}
*/
/*
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
$h=$i-1;
  if($h!=-1) print"<br>$i : ".$propre[$i]->OF."| $h : ".$propre[$h]->OF." ".($propre[$i]->OF!=$propre[$i-1]->OF);
 if(($propre[$i]->OF)&&($propre[$i]->OF != $propre[$i-1]->OF)) { $output.=antienne_messe($propre[$i]->OF,$lang);
	$i++;
	}
}

//// OFFERTOIRE
/*
$output.=ordinaire_messe($ordinaire_messe,"OF",$lang);
*/
//// superoblata
//$ref=no_accent($tableau['matin']['propre']);
/*
$output.="
	<div id=\"gauche\"><i><font color=red>Super oblata :</i></font></div>
	<div id=\"droite\"><i><font color=red>Sur les offrandes :</font></i></div>";
$ref=$messe['superoblata']['ref'];
$output.=oraison($messe['superoblata']['lat'],$messe['superoblata']['verna'],$lang,$ref,"superoblata");
*/
//// PREFACE
/*
$ref="propres/messe/".$messe['PREF']['lat'];
//$ref="propres/messe/PRAEFATIO_I_DE ADVENTU";
//$fp = fopen ("sources/".$ref.".csv","r","1");
$output.="
<div id=\"gauche\"><i><font color=red>Praefatio</font></i></div>
<div id=\"droite\"><i><font color=red>Préface</font></i></div>";
$output.=ordinaire_messe($ordinaire_messe,"OF2",$lang);
$output.=recitatif($ref,$lang) ;
*/

//// SANCTUS
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Sanctus</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Sanctus</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"SANCTUS",$lang);
//// PREX EUCHARISTICA
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Prex eucharistica</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Prière eucharistique</font></center></div>";
$output.=PREX_I($lang);
//// PERIPSUM
$output.=ordinaire_messe($ordinaire_messe,"PERIPSUM",$lang);
   */
//// PATER
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Pater</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Notre Père</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"PATER",$lang);

//// AGNUS
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Agnus</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Agnus</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"AGNUS",$lang);		
///// ECCE
/*
$output.=ordinaire_messe($ordinaire_messe,"ECCE",$lang);
     */
//// CO
/*
//if($row->CO)  $output.=antienne_messe($row->CO,$lang);
$q2="select distinct CO from temporal_".$tableau[matin][lettre_annee]." where celebration='".no_accent($refmesse)."' or celebration='".no_accent($refmesse)."-I' or celebration='".no_accent($refmesse)."-II'";
//print "<br>".$q2;
$r2=mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->CO) $output.=antienne_messe($row2->CO,$lang);
$i++;
}
*/
/*
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
$h=$i-1;
 if($h!=-1) print"<br>$i : ".$propre[$i]->CO."| $h : ".$propre[$h]->CO." ".($propre[$i]->CO!=$propre[$i-1]->CO);
 if(($propre[$i]->CO)&&($propre[$i]->CO!=$propre[$i-1]->CO)) { $output.=antienne_messe($propre[$i]->CO,$lang);
	$i++;
	}
}


/*	
$output.=ordinaire_messe($ordinaire_messe,"COMMUNIO",$lang);
*/
//// postcommunion
/*
	$output.="
	<div id=\"gauche\"><i><font color=red>Post-communio :</i></font></div>
	<div id=\"droite\"><i><font color=red>Post-communion :</font></i></div>";
$ref=$messe['postcommunio']['ref'];
if(!$ref) {
	$ref=no_accent($tableau['matin']['cel']);
	$ref="propres/".$ref.".csv";
	}

$output.=oraison($messe['postcommunio']['lat'],$messe['postcommunio']['verna'],$lang,$ref,"postcommunio");
*/
/*
/// BENE
$output.=ordinaire_messe($ordinaire_messe,"BENE",$lang);
/// Bénédictions solennelles
    */
/// Modifications à la messe lue.
/*
 $output.="
<div id=\"gauche\"><center><font align=center color=red>Modificationes ad missam lectam.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Modifications à la messe lue.</font></center></div>";
/// ant. ad IN lue
$introit_lat=$messe['IN_lu']['lat'];
$introit_vern=$messe['IN_lu']['verna'];

$output.="
<div id=\"gauche\"><center><font align=center color=red>Ant. ad introitum.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Antienne d'introït.</font></center></div>
    	<div id=\"gauche\">".$introit_lat."</div>
		<div id=\"droite\">".$introit_vern."</div>";
// ant. ad CO lue
$communion_lat=$messe[CO_lu]['lat'];
$communion_vern=$messe[CO_lu]['verna'];
$output.="
<div id=\"gauche\"><center><font align=center color=red>Ant. ad communionem.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Antienne de communion.</font></center></div>
		<div id=\"gauche\">".$communion_lat."</div>
		<div id=\"droite\">".$communion_vern."</div>";
*/

//print $output;
return $output;


}



function affiche_messe_sanctoral($refmesse,$tableau) {
$lang=$_GET['lang'];
if(!$lang) $lang="fr";
print_r($tableau);
/*
$fp = fopen ("sources/propres/messe/messe.csv","r","1");
    //print"<br> : OPEN :"."sources/propres/".$ref.".csv";
	   while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $ordinaire_messe[$id]['lat']=$data[1];
	    if ($lang=="fr") $ordinaire_messe[$id]['verna']=$data[2];
	    if ($lang=="en") $ordinaire_messe[$id]['verna']=$data[3];
	    if ($lang=="ar") $ordinaire_messe[$id]['verna']=$data[4];
	    $ordinaire_messe[$id]['ref']="sources/propres/messe/messe.csv";
	}
	@fclose($fp);	
*/	
  /// Recherche dans la BDD des références du propre du jour.
  //$q="select * from sanctoral_messe where celebration='".$refmesse."'";
  //print"<br><b>$q</b>";
 // print "<br>REF::=".$refmesse;
  //$r=@mysql_query($q);
  //$row=@mysql_fetch_object($r);
	/*
	$q="select * from lectures_semaine_temporal where celebration='".$refmesse."'";
  //print"<br><b>$q</b>";
  $r=@mysql_query($q); // or die("<br> Erreur : $q ".mysql_error());
	$lectures=@mysql_fetch_object($r);
	//print_r($lectures);
	*/
	$output.="
	<div id=\"gauche\"><b>SANCTORAL - REF=".$refmesse."</b></div>
	<div id=\"droite\">&nbsp;</div>
	";
	
//$ref_=strtolower("temporal_".$tableau['matin']['lettre_annee']);
$xml = simplexml_load_file("wp-content/plugins/liturgia/sanctoral_messe.xml");	
$propre = $xml->xpath("//".$ref_."//celebration[@id='".$refmesse."']");
//$propre = $xml->xpath("//temporal_a//celebration[@id='perannum_16-3']");
//print"<br>PROPRE : //".$ref_."//celebration[@id='".$refmesse."'] "; print_r($propre);
	
//// INTROIT
/*
$q2="select distinct IN_ from sanctoral_messe where celebration='".$refmesse."'";
//print"<br><b>$q2</b>";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->IN_) $output.=antienne_messe($row2->IN_,$lang);
$i++;
}	
*/
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 //if($row2->IN_) $output.=antienne_messe($row2->IN_,$lang);
 $h=$i-1;
  print"<br>$i : ".$propre[$i]->IN_."| $h : ".$propre[$h]->IN_;
 if(($propre[$i]->IN_)&&($propre[$i]->IN_!=$propre[$h]->IN_)) {$output.=antienne_messe($propre[$i]->IN_,$lang);
	$i++;
	}
}	

/// SALUTATIO
	/*
	$output.="
<div id=\"gauche\"><center><font align=center color=red>Salutatio</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Salutation</font></center></div>";
	$output.=ordinaire_messe($ordinaire_messe,"Initial",$lang);
	// acte pénitentiel
	$output.="
<div id=\"gauche\"><center><font align=center color=red>Actus paenitenialis</font></center></div>";
		if($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>Acte pénitentiel</font></center></div>";
	$output.=ordinaire_messe($ordinaire_messe,"Actus_paenitentialis",$lang);
	*/
//// KYRIE
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Kyrie</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Kyrie</font></center></div>";
   $output.=ordinaire_messe($ordinaire_messe,"Kyrie",$lang);
//// GLORIA
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Gloria</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Gloria</font></center></div>";
    $output.=ordinaire_messe($ordinaire_messe,"Gloria",$lang);
    */
//// COLLECTE

$ref=no_accent($tableau['matin']['propre']);
 $output.=oraison($messe['oratio']['lat'],$messe['oratio']['verna'],$lang,$ref,"oratio");
//// LECT1

$ref="I_".$refmesse;
 
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio I</font>";
if($ref) $output.=" ($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><font align=center color=red>1ère lecture</font></div>";
if ($lang=="en") $output.="<div id=\"droite\"><font align=center color=red>1st reading</font></div>";
//if ($ref) $output.=" ($ref)".affiche_editeur($refL,$lang);

$output.=lecture_messe($ref,$lang);

/*
//$ref=$messe['L1_A']['lat']; 
 $ref=$lectures->LEC_1_impaire;
 //print "<br>LEC1 = $ref";
 $refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio I</font>";
if($ref) $output.=" ($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>1ère lecture</font>";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>1st reading</font>";
if ($ref) $output.=" ($ref)".affiche_editeur($refL,$lang);
$output.="</center></div>";
$output.=lecture_messe($ref,$lang);
*/
//// PSAL1
//if($row->PS1)  $output.=antienne_messe($row->PS1,$lang);
/*
$q2="select distinct PS1 from sanctoral_messe where celebration='".$refmesse."'";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->PS1) $output.=antienne_messe($row2->PS1,$lang);
$i++;
}
*/

$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 $h=$i-1;
  print"<br>$i : ".$propre[$i]->PS1."| $h : ".$propre[$h]->PS1;
 if(($propre[$i]->PS1)&&($propre[$i]->PS1!=$propre[$h]->PS1)) {$output.=antienne_messe($propre[$i]->PS1,$lang);
	$i++;
	}
}	

//// LECT2
//print_r($tableau);
if($tableau['matin']['rang']<=7) {
$ref="II_".$refmesse;
//}
 
 //print "<br>LEC1 = $ref";
 $refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio II</font>";
if($ref) $output.=" ($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>1ère lecture</font>";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>1st reading</font>";
if ($ref) $output.=" ($ref)".affiche_editeur($refL,$lang);
//$output.="</center></div>";
$output.=lecture_messe($ref,$lang);
}
/*
$ref=$messe['L2_A']['lat'];
if($ref)  {
$refL="sources/propres/messe/lectures/LEC_".$ref.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Lectio II</font>";
if($ref) $output.="($ref)".affiche_editeur($refL,"lat");
$output.="</center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>2ème lecture</font> ";
if ($lang=="en") $output.="<div id=\"droite\"><center><font align=center color=red>2nd reading</font> ";
if ($ref) $output.="($ref)".affiche_editeur($refL,$lang);
$output.="</center></div>";
$output.=lecture_messe($ref,$lang);
}
*/
//// PSAL2
  
//if($row->PS2)	$output.=antienne_messe($row->PS2,$lang);
/*
$q2="select distinct PS2 from sanctoral_messe where celebration='".$refmesse."' or celebration='".$refmesse."-I' or celebration='".$refmesse."-II'";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->PS2) $output.=antienne_messe($row2->PS2,$lang);
$i++;
}
*/
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 print"<br>$i : ".$propre[$i]->PS2."| $h : ".$propre[$h]->PS2;
 if(($propre[$i]->PS2)&&($propre[$i]->PS2!=$propre[$i-1]->PS2)) {$output.=antienne_messe($propre[$i]->PS2,$lang);
	$i++;
	}
}	

//// SEQ
if ($propre[0]->SEQ) {
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Sequentia</font></center></div>";
if ($lang=="fr") $output.="<div id=\"droite\"><center><font align=center color=red>Séquence</font></center></div>";
*/
$output.=antienne_messe($propre[0]->SEQ,$lang);
}
//// EV
//}
 
 
//print_r($tableau);

$refL="sources/propres/messe/lectures/EV_".$refmesse.".csv";
$output.="
<div id=\"gauche\"><center><font align=center color=red>Evangelium</font>";
if($ref) $output.=" (EV_$refmesse)".affiche_editeur($refL,"lat");
$output.="</div>";
$output.="<div id=\"droite\"><center><font align=center color=red>Evangile</font></div>";


$output.=evangile($refmesse,$lang);
//$output.=ordinaire_messe($ordinaire_messe,"EV_fin",$lang);
//// CREDO
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Professio fidei</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Profession de foi</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"CREDO_NC",$lang);
*/
//// PU
//// OF
//if($row->OF)  $output.=antienne_messe($row->OF,$lang,"OF");
/*
$q2="select distinct OF from sanctoral_messe where celebration='".$refmesse."'";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->OF) $output.=antienne_messe($row2->OF,$lang);
$i++;
}
*/
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 
 if(($propre[$i]->OF)&&($propre[$i]->OF!=$propre[$i-1]->OF)) {$output.=antienne_messe($propre[$i]->OF,$lang);
	$i++;
	}
}	

//// OFFERTOIRE
/*
$output.=ordinaire_messe($ordinaire_messe,"OF",$lang);
*/
//// superoblata
//$ref=no_accent($tableau['matin']['propre']);
/*
$ref=$messe['superoblata']['ref'];
$output.=oraison($messe['superoblata']['lat'],$messe['superoblata']['verna'],$lang,$ref,"superoblata");
//// PREFACE

$ref="propres/messe/".$messe['PREF']['lat'];
//$ref="propres/messe/PRAEFATIO_I_DE ADVENTU";
//$fp = fopen ("sources/".$ref.".csv","r","1");
$output.="
<div id=\"gauche\"><center><font align=center color=red>Praefatio</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Préface</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"OF2",$lang);
$output.=recitatif($ref,$lang) ;

//// SANCTUS
$output.="
<div id=\"gauche\"><center><font align=center color=red>Sanctus</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Sanctus</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"SANCTUS",$lang);
//// PREX EUCHARISTICA
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Prex eucharistica</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Prière eucharistique</font></center></div>";
$output.=PREX_I($lang);
//// PERIPSUM
$output.=ordinaire_messe($ordinaire_messe,"PERIPSUM",$lang);
   */
//// PATER
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Pater</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Notre Père</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"PATER",$lang);
*/
//// AGNUS
/*
$output.="
<div id=\"gauche\"><center><font align=center color=red>Agnus</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Agnus</font></center></div>";
$output.=ordinaire_messe($ordinaire_messe,"AGNUS",$lang);		
///// ECCE
/*
$output.=ordinaire_messe($ordinaire_messe,"ECCE",$lang);
     */
//// CO
//if($row->CO)  $output.=antienne_messe($row->CO,$lang);
/*
$q2="select distinct CO from sanctoral_messe where celebration='".$refmesse."'";
$r2=@mysql_query($q2); // or die("<br> Erreur : $q ".mysql_error());
$i=0;
while($row2=@mysql_fetch_object($r2)) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 if($row2->CO) $output.=antienne_messe($row2->CO,$lang);
$i++;
}
*/
$i=0;
while($propre[$i]) {
if ($i>0) {
	$output.="
	<div id=\"gauche\"><i><font color=red>Vel :</i></font></div>
	<div id=\"droite\"><i><font color=red>Ou bien :</font></i></div>";
}
 
 if(($propre[$i]->CO)&&($propre[$i]->CO!=$propre[$i-1]->OF)) {$output.=antienne_messe($propre[$i]->CO,$lang);
	$i++;
	}
}	
/*	
$output.=ordinaire_messe($ordinaire_messe,"COMMUNIO",$lang);
*/
//// postcommunion
/*
$ref=$messe['postcommunio']['ref'];
if(!$ref) {
	$ref=no_accent($tableau['matin']['cel']);
	$ref="propres/".$ref.".csv";
	}

$output.=oraison($messe['postcommunio']['lat'],$messe['postcommunio']['verna'],$lang,$ref,"postcommunio");

/*
/// BENE
$output.=ordinaire_messe($ordinaire_messe,"BENE",$lang);
/// Bénédictions solennelles
    */
/// Modifications à la messe lue.
/*
 $output.="
<div id=\"gauche\"><center><font align=center color=red>Modificationes ad missam lectam.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Modifications à la messe lue.</font></center></div>";
/// ant. ad IN lue
$introit_lat=$messe['IN_lu']['lat'];
$introit_vern=$messe['IN_lu']['verna'];

$output.="
<div id=\"gauche\"><center><font align=center color=red>Ant. ad introitum.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Antienne d'introït.</font></center></div>
    	<div id=\"gauche\">".$introit_lat."</div>
		<div id=\"droite\">".$introit_vern."</div>";
// ant. ad CO lue
$communion_lat=$messe[CO_lu]['lat'];
$communion_vern=$messe[CO_lu]['verna'];
$output.="
<div id=\"gauche\"><center><font align=center color=red>Ant. ad communionem.</font></center></div>
		<div id=\"droite\"><center><font align=center color=red>Antienne de communion.</font></center></div>
		<div id=\"gauche\">".$communion_lat."</div>
		<div id=\"droite\">".$communion_vern."</div>";
*/
return $output;


}


function messe($jour,$tableau,$calendarium) {
$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
//if($auth) print"<br>AUTHENTIFIE";
//print_r($tableau);


//connect_db();
//print_r($tableau);

$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";
 
if (no_accent($tableau['matin']['cels'])) { // SANCTORAL
	if($tableau['matin']['cels']=="06-29") {
		$output.=affiche_messe_sanctoral(no_accent("06-29-in-vigilia"),$tableau);
		$output.=affiche_messe_sanctoral(no_accent("06-29-in-die"),$tableau);
	}
	elseif($tableau['matin']['cels']=="06-24") {
		$output.=affiche_messe_sanctoral(no_accent("06-24-in-vigilia"),$tableau);
		$output.=affiche_messe_sanctoral(no_accent("06-24-in-die"),$tableau);
	}
	else $output.=affiche_messe_sanctoral(no_accent($tableau['matin']['cels']),$tableau);
	}
	
	
if($tableau['matin']['cel']) { 	//// TEMPORAL
	$refmesse=$tableau['matin']['cel'];
	if($refmesse=="12-25_jour") {  // NOEL
	$output="
	<div id=\"gauche\"><center>AD MISSAM IN VIGILIA</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("12-25_vigile",$tableau);
	
	$output.="
	<div id=\"gauche\"><center>AD MISSAM IN NOCTE</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("12-25_minuit",$tableau);
	
	$output.="
	<div id=\"gauche\"><center>AD MISSAM IN AURORA</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("12-25_aurore",$tableau);
	
	$output.="
	<div id=\"gauche\"><center>AD MISSAM IN DIE</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("12-25_jour",$tableau);
	}
	//print"refmesse : ".$refmesse. " <br>";
	
	elseif($refmesse=="Dominica_Pentecostes_in_die") { // PENTECOTE
	$output="
	<div id=\"gauche\"><center>AD MISSAM IN VIGILIA</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("Dominica_Pentecostes_in_vigilia",$tableau);
	
	$output.="
	<div id=\"gauche\"><center>AD MISSAM IN DIE</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("Dominica_Pentecostes_in_die",$tableau);
	
	}
	
	elseif($refmesse=="DOMINICA_IN_PALMIS_DE_PASSIONE_DOMINI") { // RAMEAUX
	$output="
	<div id=\"gauche\"><center><i>Commemoratio ingressus Domini in Ierusalem</i></center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=antienne_messe("AN_Hosanna_filio_David",$lang);
	$output.=antienne_messe("AN_Pueri_portantes",$lang);
	$output.=antienne_messe("AN_Pueri_vestimenta",$lang);
	$output.=antienne_messe("HY_Gloria_laus",$lang);
	$output.=antienne_messe("RESP_Ingrediente",$lang);
	$output.="
	<div id=\"gauche\"><center>AD MISSAM</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe($refmesse,$tableau);
	}
	
	
	elseif($refmesse=="HS_5_AD_MISSAM_CHRISMATIS") { // MESSE CHRISMALE
	$output="
	<div id=\"gauche\"><center>AD MISSAM CHRISMATIS</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("HS_5_AD_MISSAM_CHRISMATIS",$tableau);
	$output.="
	<div id=\"gauche\"><center>SACRUM TRIDUUM PASCHALE<br>PASSIONIS ET RESURRECTIONIS DOMINI<br>MISSA VESPERTINA IN CENA DOMINI</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("HS_5_MISSA_VESPERTINA_IN_CENA_DOMINI",$tableau);
	$output.=antienne_messe("AN_Postquam_surrexit",$lang);
	$output.=antienne_messe("AN_Dominus_Iesus",$lang);
	$output.=antienne_messe("AN_Domine_tu_mihi_lavas_pedes",$lang);
	$output.=antienne_messe("AN_Si_Ego_Dominus",$lang);
	$output.=antienne_messe("AN_In_hoc_cognoscent_omnes",$lang);
	$output.=antienne_messe("AN_Mandatum_novum",$lang);
	$output.=antienne_messe("AN_Maneant_in_vobis",$lang);
	$output.=antienne_messe("HY_Pange_lingua",$lang);
	
	}
	
	elseif($refmesse=="HS_6") { // VENDREDI SAINT
	$output="
	<div id=\"gauche\"><center>FERIA SEXTA IN PASSIONE DOMINI</center></div>
	<div id=\"droite\">&nbsp;</div>";
	$output.=affiche_messe("HS_6",$tableau);
	$output.=antienne_messe("AN_Ecce_lignum_crucis",$lang);
	$output.=antienne_messe("AN_Crucem_tuam",$lang);
	$output.=antienne_messe("IMP_Popule_meus",$lang);
	$output.=antienne_messe("HY_Crux_fidelis",$lang);		
	}
	
	else $output.= affiche_messe($refmesse,$tableau);
	}
	return $output;

}

function PREX_I($lang) {
  return;

     $fp = fopen ("sources/propres/messe/prex_I.csv","r","1");
    //print"<br> : OPEN :"."sources/propres/".$ref.".csv";
	   while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $prex[$id]['lat']=$data[1];
	    if ($lang=="fr") $prex[$id]['verna']=$data[2];
	    if ($lang=="en") $prex[$id]['verna']=$data[3];
	    if ($lang=="ar") $prex[$id]['verna']=$data[4];
	    $prex[$id]['ref']="sources/propres/messe/prex_I.csv";
	}
	@fclose($fp);	
    $pe.=ordinaire_messe($prex,"TE_IGITUR",$lang);
    $pe.=ordinaire_messe($prex,"MEMENTO",$lang);
    $pe.=ordinaire_messe($prex,"COMMUNICANTES",$lang);
    $pe.=ordinaire_messe($prex,"HANC_IGITUR",$lang);
    $pe.=ordinaire_messe($prex,"QUAM_OBLATIONEM",$lang);
    $pe.=ordinaire_messe($prex,"QUI_PRIDIE",$lang);
    $pe.=ordinaire_messe($prex,"ACCIPITE",$lang);
    $pe.=ordinaire_messe($prex,"SIMILI_MODO",$lang);
    $pe.=ordinaire_messe($prex,"ACCIPITE",$lang);
    $pe.=ordinaire_messe($prex,"ANAMNESE",$lang);    
    $pe.=ordinaire_messe($prex,"UNDE_ET_MEMORES",$lang);
    $pe.=ordinaire_messe($prex,"SUPPLICES",$lang);
    $pe.=ordinaire_messe($prex,"MEMENTO_ETIAM",$lang);
    $pe.=ordinaire_messe($prex,"NOBIS_QUOQUE",$lang);
    $pe.=ordinaire_messe($prex,"PER_QUEM_HAEC",$lang);
    return $pe;
    
}


?>