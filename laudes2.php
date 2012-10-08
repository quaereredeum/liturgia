<?php

function laudes($jour,$tableau,$calendarium,$office) {
//print_r($_SERVER);
if($office=="") $office=$_GET['office']; /// Pour voir si jamais il faut afficher l'invitatoire.

$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";
//print_r($tableau);
// psautier
$psalterium=$tableau['matin']['psalterium'];
$xmlpsalterium = simplexml_load_file("wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml");
$reference=ajoutexml($reference,$xmlpsalterium);
//print"<br>".$tableau['matin']['psalterium']."<br>";	
//$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/quadragesima_12.xml");
//$reference=ajoutexml($reference,$xml);


/// Férie du temps
$temporal=$tableau['matin']['ferie'];
if($temporal) { 
$xmlferie = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml");
if($xmlferie) print "<br> LOAD temporal :";
if($xmlferie) print "<a href=\"http://192.168.193.231/wordpress/wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml\">wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml</a>";


}
if($xmlferie) $reference=ajoutexml($reference,$xmlferie);	

/// Propre du temps ou des saints
$propre=$tableau['matin']['propre'];
if($tableau['matin']['propre']) { 
$xmlpropre = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".no_accent($tableau['matin']['propre']).".xml") ; //or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$propre.".xml");
//print_r($xmlpropre);
if($xmlpropre) $reference=ajoutexml($reference,$xmlpropre);

}




//print"<br>".$tableau['matin']['ferie'];
/// Sanctoral
/*
if(($tableau['matin']['rang']<13)&&($tableau['matin']['cel'])) {
$sanctoral=$tableau['matin']['cel'];
$sanctoral = str_replace("-", "", $sanctoral);
$xmlsanctoral = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml");
print "<br> LOAD sanctoral : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml";
$reference=ajoutexml($reference,$xmlsanctoral);	
}
*/

if($tableau['matin']['special']) {
$special=$tableau['matin']['special'];

$xmlspe = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml");
if($xmlspe) print "<br> LOAD special : wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml";
if($xmlspe) $reference=ajoutexml($reference,$xmlspe);	
}
//print_r($tableau);
print affiche_tableau($tableau,"laudes");
//print_r($reference);
if($reference['oratio']['id']) $oratio=$reference['oratio']['id'];
if($reference['oratio_laudes']['id']) $oratio=$reference['oratio_laudes']['id'];

print"<table>
<th>Int</th><th>Ref</th>
<tr><td>HYMNUS_Laudes</td><td>".$reference['HYMNUS_laudes']['id']."</td></tr>
<tr><td>ant1</td><td>".$reference['ant1']['id']."</td></tr>
<tr><td>ps1</td><td>".$reference['ps1']['id']."</td></tr>
<tr><td>ant2</td><td>".$reference['ant2']['id']."</td></tr>
<tr><td>ps2</td><td>".$reference['ps2']['id']."</td></tr>
<tr><td>ant3</td><td>".$reference['ant3']['id']."</td></tr>
<tr><td>ps3</td><td>".$reference['ps3']['id']."</td></tr>
<tr><td>LB_matin</td><td>".$reference['LB_matin']['id']."</td></tr>
<tr><td>RB_matin</td><td>".$reference['RB_matin']['id']."</td></tr>
<tr><td>Benedictus</td><td>".$reference['benedictus']['id']."</td></tr>
<tr><td>Benedictus_A</td><td>".$reference['benedictus_A']['id']."</td></tr>
<tr><td>Benedictus_B</td><td>".$reference['benedictus_B']['id']."</td></tr>
<tr><td>Benedictus_C</td><td>".$reference['benedictus_C']['id']."</td></tr>
<tr><td>Oratio</td><td>".$oratio."</td></tr>
</table>
";
/*
print"<p>";
print_r($reference);
print"<p>";
*/



//print"<p>".$reference['HYMNUS_laudes']['id']."<p>";
/*
$special=no_accent($tableau['matin']['propre']);
$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml");
$reference=ajoutexml($reference,$xml);	
  */
/// Eventuellement, le commun
$commun=$reference['commun']['latin'];
if($commun) {
$xmlcommun = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$commun.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$commun.".xml");
$reference=ajoutexml($reference,$xmlcommun);
$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml");
$reference=ajoutexml($reference,$xml);
}



//print_r($reference);

//$fp = fopen ("sources/psalterium/psalterium_12.xml","r","1");
/*
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="psalterium/".$psalterium.".csv";
	    $row++;
	}
	@fclose($fp);
	*/
///// Après le temporal
//$temporal = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/quadragesima_12.xml");

/*
$temporal=$tableau['matin']['ferie'];
$fp = fopen ("sources/propres/".no_accent($temporal).".csv","r","1");
//print"<br>OPEN :"."sources/propres/".no_accent($propre).".csv";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/".$temporal.".csv";
	    $row++;
	}
	@fclose($fp);
*/	
///// Après le sanctoral
/*	
$special=$tableau['matin']['propre'];

//print"<br>OPEN :"."sources/propres/".no_accent($special).".csv";
$fp = @fopen ("sources/propres/".no_accent($special).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/".$special.".csv";
	    $row++;
	}
	@fclose($fp);
	*/
		
	///// Ensuite le Commun
	
	
/*
$ferie=$tableau['matin']['ferie'];
//print"<br>OPEN :"."sources/propres/".$ferie.".csv";
$fp = fopen ("sources/propres/".$ferie.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']=$ferie;
	    $row++;
	}
	@fclose($fp);
*/

/*

/// Eventuellement, le commun
$commun=$reference['commun']['latin'];
if ($commun) {
print "<br> COMMUN=".$commun;
$fp = @fopen ("sources/propres/commun_".no_accent($commun).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/commun_".$commun.".csv";
	    $row++;
	}
	@fclose($fp);
	
	$fp = @fopen ("sources/propres/".no_accent($special).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/".$special.".csv";
	    $row++;
	}
	@fclose($fp);
	
	
}
*/

//print_r($reference);
//print_r($reference);

$tem=$tableau['matin']['temps'];
 //print_r($tableau);
 //print_r($reference);
 
 if($_GET['option']=="correction_ordo") {
 $psalterium_HY=@$xmlpsalterium->xpath('/liturgia/HYMNUS_laudes/@id');
 $psalterium_ANT1=@$xmlpsalterium->xpath('/liturgia/ant1/@id');
 $psalterium_PS1=@$xmlpsalterium->xpath('/liturgia/ps1/@id');
 $psalterium_ANT2=@$xmlpsalterium->xpath('/liturgia/ant2/@id');
 $psalterium_PS2=@$xmlpsalterium->xpath('/liturgia/ps2/@id');
 $psalterium_ANT3=@$xmlpsalterium->xpath('/liturgia/ant3/@id');
 $psalterium_PS3=@$xmlpsalterium->xpath('/liturgia/ps3/@id');
 $psalterium_LB=@$xmlpsalterium->xpath('/liturgia/LB_matin/@id');
 $psalterium_RB=@$xmlpsalterium->xpath('/liturgia/RB_matin/@id');
 $psalterium_benedictus=@$xmlpsalterium->xpath('/liturgia/benedictus/@id');
  $psalterium_preces=@$xmlpsalterium->xpath('/liturgia/preces/@id');
 $psalterium_oratio=@$xmlpsalterium->xpath('/liturgia/oratio/@id');
 
 $cel_HY=@$xmlcel->xpath('/liturgia/HYMNUS_laudes/@id');
 $cel_ANT1=@$xmlcel->xpath('/liturgia/ant1/@id');
 $cel_PS1=@$xmlcel->xpath('/liturgia/ps1/@id');
 $cel_ANT2=@$xmlcel->xpath('/liturgia/ant2/@id');
 $cel_PS2=@$xmlcel->xpath('/liturgia/ps2/@id');
 $cel_ANT3=@$xmlcel->xpath('/liturgia/ant3/@id');
 $cel_PS3=@$xmlcel->xpath('/liturgia/ps3/@id');
 $cel_LB=@$xmlcel->xpath('/liturgia/LB_matin/@id');
 $cel_RB=@$xmlcel->xpath('/liturgia/RB_matin/@id');
 $cel_benedictus=@$xmlcel->xpath('/liturgia/benedictus/@id');
 $cel_preces=@$xmlcel->xpath('/liturgia/preces/@id');
 $cel_oratio=@$xmlcel->xpath('/liturgia/oratio/@id');
 
 if($xmlcom) {
 $com_HY=@$xmlcom->xpath('/liturgia/HYMNUS_laudes/@id');
 $com_ANT1=@$xmlcom->xpath('/liturgia/ant1/@id');
 $com_PS1=@$xmlcom->xpath('/liturgia/ps1/@id');
 $com_ANT2=@$xmlcom->xpath('/liturgia/ant2/@id');
 $com_PS2=@$xmlcom->xpath('/liturgia/ps2/@id');
 $com_ANT3=@$xmlcom->xpath('/liturgia/ant3/@id');
 $com_PS3=@$xmlcom->xpath('/liturgia/ps3/@id');
 $com_LB=@$xmlcom->xpath('/liturgia/LB_matin/@id');
 $com_RB=@$xmlcom->xpath('/liturgia/RB_matin/@id');
 $com_benedictus=@$xmlcom->xpath('/liturgia/benedictus/@id');
 $com_preces=@$xmlcom->xpath('/liturgia/preces/@id');
 $com_oratio=@$xmlcom->xpath('/liturgia/oratio/@id');
 }
 
 
 $laudes.="<table>
 <th>Intitule</th><th>psalterium</th><th>cel</th><th>com</th>
 <tr> <td>HYMNUS_laudes</td>	<td><a href=\"\">".$psalterium_HY[0]."</a></td>		<td><a href=\"\">".$cel_HY[0]."</a></td><td><a href=\"\">".$com_HY[0]."</a></td></tr>
 <tr><td>ant1</td>				<td><a href=\"\">".$psalterium_ANT1[0]."</a></td> 	<td><a href=\"\">".$cel_ANT1[0]."</a></td>	<td><a href=\"\">".$com_ANT1[0]."</a></td></tr>
 <tr><td>ps1</td>				<td><a href=\"\">".$psalterium_PS1[0]."</a></td>		<td><a href=\"\">".$cel_PS1[0]."</a></td><td><a href=\"\">".$com_PS1[0]."</a></td></tr>
 <tr><td>ant2</td>				<td><a href=\"\">".$psalterium_ANT2[0]."</a></td>	<td><a href=\"\">".$cel_ANT2[0]."</a></td><td><a href=\"\">".$com_ANT2[0]."</a></td></tr>
 <tr><td>ps2</td>				<td><a href=\"\">".$psalterium_PS2[0]."</a></td>		<td><a href=\"\">".$cel_PS2[0]."</a></td><td><a href=\"\">".$com_PS2[0]."</a></td></tr>
 <tr><td>ant3</tdr>				<td><a href=\"\">".$psalterium_ANT3[0]."</a></td>	<td><a href=\"\">".$cel_ANT3[0]."</a></td><td><a href=\"\">".$com_ANT3[0]."</a></td></tr>
 <tr><td>ps3</td>				<td><a href=\"\">".$psalterium_PS3[0]."</a></td>		<td><a href=\"\">".$cel_PS3[0]."</a></td><td><a href=\"\">".$com_PS3[0]."</a></td></tr>
 <tr><td>LB_matin</td>			<td><a href=\"\">".$psalterium_LB[0]."</a></td>		<td><a href=\"\">".$cel_LB[0]."</a></td><td><a href=\"\">".$com_LB[0]."</a></td></tr>
 <tr><td>RB_matin</td>			<td><a href=\"\">".$psalterium_RB[0]."</a></td>		<td><a href=\"\">".$cel_RB[0]."</a></td><td><a href=\"\">".$com_RB[0]."</a></td></tr>
 <tr><td>benedictus</td>		<td><a href=\"\">".$psalterium_benedictus[0]."</a></td>	<td><a href=\"\">".$cel_benedictus[0]."</a></td><td><a href=\"\">".$com_benedictus[0]."</a></td></tr>
 <tr><td>preces_matin</td>		<td><a href=\"\">".$psalterium_Preces[0]."</a></td>			<td><a href=\"\">".$cel_Preces[0]."</a></td><td><a href=\"\">".$com_Preces[0]."</a></td></tr>
 <tr><td>oratio_laudes</td>		<td><a href=\"\">".$psalterium_oratio[0]."</a></td>		<td><a href=\"\">".$cel_oratio[0]."</a></td><td><a href=\"\">".$com_oratio[0]."</a></td></tr>
 
 
 </table>";
 
 
 }

//////// INTITULE
	if($reference['intitule']) {    //// Il y a un intitulé spécial pour la célébration
		$laudes.="<div id=\"gauche\"><center>{$reference['jour']['latin']}</center></div>";
		$laudes.="<div id=\"droite\"><center>{$reference['jour']['verna']}</center></div>";
		$laudes.="<div id=\"gauche\"><center>{$reference['intitule']['latin']}</center></div>
		  <div id=\"droite\"><center>{$reference['intitule']['verna']}</center></div>";
		$laudes.="<div id=\"gauche\"><center><font color=red>{$reference['rang']['latin']}</font></center></div>
		  <div id=\"droite\"><center><font color=red>{$reference['rang']['verna']}</font></center></div>";
		$laudes.="<div id=\"gauche\"><center><font color=red><b>Ad Laudes matutinas.</b></font></center></div>";
		if ($lang=="fr") $laudes.="<div id=\"droite\"><center><font color=red><b>Aux Laudes du matin.</b></font></center></div>";
		}
  	else {   ////// Il n'ya pas d'intitulé spécial, construction d'un intitulé standard.  
		$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
		$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");
		$jours_en=array("On Sunday","On Monday","On Tuesday","On Wednesday","On Thursday","On Friday","On Saturday");
		
		$laudes.="
		<div id=\"gauche\"><center>{$reference['intitule']['latin']}</center></div>
		<div id=\"droite\"><center>{$reference['intitule']['francais']}</center></div>";
		$datets=datets($jour);
		$date_l=$jours_l[date('w',$datets['ts'])];
		$date_fr=$jours_fr[date('w',$datets['ts'])];
		$date_en=$jours_en[date('w',$datets['ts'])];
		$laudes.="<div id=\"gauche\"><center><font color=red><b>$date_l ad Laudes matutinas.</b></font></center></div>";
		if ($lang=="fr") $laudes.="<div id=\"droite\"><center><font color=red><b>$date_fr aux Laudes du matin.</b></font></center></div>";
		if ($lang=="en") $laudes.="<div id=\"droite\"><center><font color=red><b>$date_en aux Laudes du matin.</b></font></center></div>";
	}

/////// ORDO 
	$ordo=$_COOKIE["pref"];
	if ($ordo=="LH") 	$laudes.="<br><center> <i>Liturgia Horarum, editio typica altera, 1985, © Libreria editrice vaticana.</i></center>";
	if ($ordo=="HG") 	$laudes.="<br><center> <i>Les Heures Grégoriennes, 2008, © Communauté Saint Martin.</i></center>";
	if ($ordo=="AR") 	$laudes.="<br><center> <i>Antiphonale romanum, 2009, © Abbaye Saint Pierre de Solesmes.</i></center>";
	

////// INITIUM

	if($office=="laudes") $laudes.=initium($reference['initium']['mp3'],$lang);
	
	
///// HYMNE
	//print"<p>".$reference['HYMNUS_laudes']['id']."<p>";
	//print_r($reference['HYMNUS_laudes']['id']);
	    $hymne=$reference['HYMNUS_laudes']['id'];
		//print no_accent($hymne);
	    $laudes.= hymne($hymne,$lang,$reference['HYMNUS_laudes']['mp3']);

///// Antiennes et premier psaume

	$laudes.=antienne($reference['ant1']['id'],$lang,"1");
	$psaume=$reference['ps1']['id'];
	$laudes.=psaume($psaume,$lang);
	$laudes.=antienne($reference['ant1']['id'],$lang,"");
	
///// Antiennes et deuxième psaume

	$laudes.=antienne($reference['ant2']['id'],$lang,"2");
	$psaume=$reference['ps2']['id'];
	$laudes.=psaume($psaume,$lang);
	$laudes.=antienne($reference['ant2']['id'],$lang,"");
	

	
///// Antiennes et troisième psaume

	$laudes.=antienne($reference['ant3']['id'],$lang,"3");
	$psaume=$reference['ps3']['id'];
	$laudes.=psaume($psaume,$lang);
	$laudes.=antienne($reference['ant3']['id'],$lang,"");
	


///// Lectio brevis	

	    $lectiobrevis =lectiobrevis($reference['LB_matin']['id'],$lang);
	    $laudes.=$lectiobrevis;

///// Répons bref

	$ref=$reference['RB_matin']['id']; //print"<br> REF répons bref".$ref;
	$laudes.=reponsbref($reference['RB_matin']['id'],$lang);

//// Antienne et benedictus
/*
if($reference['benedictus']['id']) {
	$benelat=$reference['benedictus']['latin'];
	$benever=$reference['benedictus']['verna'];
	}
	
	$rr="benedictus_".$tableau['matin']['lettre_annee'];
	if($reference[$rr]['latin']) {
		$benelat=$reference[$rr]['latin'];
		$benever=$reference[$rr]['verna'];
		$refL=$reference[$rr]['ref'];
	}
	else {
		$refL=$reference['benedictus']['ref'];
		$rr="benedictus";
	}
*/
//print_r($reference);
if($reference['benedictus']['id']) $laudes.=antienne($reference['benedictus']['id'],$lang,"");
if($reference['benedictus_A']['id']) $laudes.=antienne($reference['benedictus_A']['id'],$lang,"");
if($reference['benedictus_B']['id']) $laudes.=antienne($reference['benedictus_B']['id'],$lang,"");
if($reference['benedictus_C']['id']) $laudes.=antienne($reference['benedictus_C']['id'],$lang,"");

$laudes.=psaume("benedictus",$lang);
if($reference['benedictus']['id']) $laudes.=antienne($reference['benedictus']['id'],$lang,"");
if($reference['benedictus_A']['id']) $laudes.=antienne($reference['benedictus_A']['id'],$lang,"");
if($reference['benedictus_B']['id']) $laudes.=antienne($reference['benedictus_B']['id'],$lang,"");
if($reference['benedictus_C']['id']) $laudes.=antienne($reference['benedictus_C']['id'],$lang,"");


//$laudes.=antienne($reference['benedictus']['id'],$lang,"");
	
////// PRECES
	$ref=$reference['preces_matin']['id'];
	$laudes.="
		<div id=\"gauche\"><font color=red><center><b>Preces</b></center> </font></div>
		<div id=\"droite\"><font color=red><center><b>Prières litaniques</b></center> </font></div>
		<div id=\"gauche\">".nl2br($reference['preces_matin']['latin'])."</div>
		<div id=\"droite\">".nl2br($reference['preces_matin']['verna'])."</div>";
		
	
//////// PATER
	    $laudes.=pater($lang);
	

///////// ORAISON
print "<br><b>Oratio laudes :</b>".$reference['oratio_laudes']['id'];
//print_r($reference);
if($reference['oratio_laudes']['id']) $laudes.=collecte($reference['oratio_laudes']['id'],$lang);
if($reference['oratio']['id']) $laudes.=collecte($reference['oratio']['id'],$lang);
/*
	$laudes.="
	<div id=\"gauche\"><font color=red><center><b>Oratio.</b></center></font></div>";
	if($lang=="fr") $laudes.="<div id=\"droite\"><font color=red><center><b>Oraison.</b></center></font></div>";
	$marque=false;
	$oratiolat=$reference['oratio_laudes']['latin'];
	$oratiover=$reference['oratio_laudes']['verna'];
	if($reference['oratio']['latin']) {
		$oratiolat=$reference['oratio']['latin'];
		$oratiover=$reference['oratio']['verna'];
		$marque=true;
	} 
	    
	if ((substr($oratiolat,-14))==" Per Dóminum.") {
		$oratiolat=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
		if ($lang=="fr") $oratiover.=" Par notre Seigneur Jésus-Christ, Ton Fils, qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}

	if ((substr($oratiolat,-11))==" Qui tecum.") {
	        $oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	if ($lang=="fr") $oratiover.=" Lui qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}

	if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	if ($lang=="fr") $oratiover.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
	    
	$laudes.="<div id=\"gauche\">".$oratiolat."</div>";
	if (!$marque) {
		$refL=$reference['oratio_laudes']['ref'];
		$laudes.="<div id=\"droite\">".$oratiover." ".affiche_editeur($refL,$lang)."</div>";
	}
	if ($marque) {
		$refL=$reference['oratio']['ref'];
		$laudes.="<div id=\"droite\">$oratiover ".affiche_editeur($refL,$lang)."</div>";
	}
	*/

/////// RENVOI
	/*
	if ((($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")))  {
	    $laudes.="
	    <div id=\"gauche\">Ite in pace, allelúia, allelúia.</div>
	    <div id=\"droite\">Allez en paix, alléluia, alléluia.</div>
	    <div id=\"gauche\">R/. Deo grátias, allelúia, allelúia.</div>
	    <div id=\"droite\">R/. Rendons grâces à Dieu, alléluia, alléluia.</div>";
	}
	else {
		$laudes.="<div id=\"gauche\">Ite in pace.</div>
		<div id=\"droite\">Allez en paix.</div>
		<div id=\"gauche\">R/. Deo grátias.</div>
		<div id=\"droite\">R/. Rendons grâces à Dieu.</div>";
	}
	*/
	$laudes.=renvoi($reference['renvoi_laudes']['mp3'],$lang);
	$laudes=utf($laudes);
	$laudes= rougis_verset ($laudes);
	return $laudes;
}

?>