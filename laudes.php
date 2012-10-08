<?php

function laudes($jour,$tableau,$calendarium,$office) {

if($office=="") $office=$_GET['office']; /// Pour voir si jamais il faut afficher l'invitatoire.

$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";


/// D'abord le psautier
$psalterium=$tableau['matin']['psalterium'];
$fp = fopen ("sources/psalterium/".$psalterium.".csv","r","1");
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
	
///// Après le temporal
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
	
///// Après le sanctoral	
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



//print_r($reference);

$tem=$tableau['matin']['temps'];
 //print_r($tableau);
 //print_r($reference);

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

	    $hymne=$reference['HYMNUS_laudes']['latin'];
	    $laudes.= hymne($hymne,$lang,$reference['HYMNUS_laudes']['mp3']);

///// Antiennes et premier psaume
$refL=$reference['ant1']['ref'];
	$antlat=nl2br($reference['ant1']['latin']);
	$antver=nl2br($reference['ant1']['verna']);
	$laudes.="<div id=\"gauche\">".mp3Player($reference['ant1']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. 1 </font>$antlat ".affiche_editeur_propre('ant1',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 1</font> $antver  ".affiche_editeur_propre('ant1',$refL,$lang)."</div>";
	
	$psaume=$reference['ps1']['latin'];
	$laudes.=psaume($psaume,$lang);
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et deuxième psaume
$refL=$reference['ant2']['ref'];
	$antlat=nl2br($reference['ant2']['latin']);
   	$antver=nl2br($reference['ant2']['verna']);
	$laudes.="<div id=\"gauche\">".mp3Player($reference['ant2']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. 2 </font>$antlat ".affiche_editeur_propre('ant2',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 2</font> $antver  ".affiche_editeur_propre('ant2',$refL,$lang)."</div>";
	
	$psaume=$reference['ps2']['latin'];
	$laudes.=psaume($psaume,$lang);
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et troisième psaume
$refL=$reference['ant3']['ref'];
	$antlat=nl2br($reference['ant3']['latin']);
   	$antver=nl2br($reference['ant3']['verna']);
	$laudes.="<div id=\"gauche\">".mp3Player($reference['ant3']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. 3 </font>$antlat ".affiche_editeur_propre('ant3',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 3</font> $antver ".affiche_editeur_propre('ant3',$refL,$lang)."</div>";
	
	$psaume=$reference['ps3']['latin'];
	$laudes.=psaume($psaume,$lang);
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
	
///// Lectio brevis	

	    $lectiobrevis =lectiobrevis($reference['LB_matin']['latin'],$lang);
	    $laudes.=$lectiobrevis;

///// Répons bref

    $rblat=nl2br($reference['RB_matin']['latin']);
	$rbver=nl2br($reference['RB_matin']['verna']);
	$refL=$reference['RB_matin']['ref'];
	$laudes.="<div id=\"gauche\">".mp3Player($reference['RB_matin']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
	$laudes.="
	    	<div id=\"gauche\"><font color=red><center><b>Responsorium Breve</b></font></div>
		<div id=\"droite\"><font color=red><center><b>Répons bref</b></center></font></div>
		<div id=\"gauche\">$rblat ".affiche_editeur_propre('RB_matin',$refL,'lat')."</div>
		<div id=\"droite\">$rbver ".affiche_editeur_propre('RB_matin',$refL,$lang)."</div>";

//// Antienne et benedictus

if($reference['benedictus']['latin']) {
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
	$laudes.="<div id=\"gauche\">".mp3Player($reference['benedictus']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. </font>$benelat ".affiche_editeur_propre($rr,$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. </font>$benever ".affiche_editeur_propre($rr,$refL,$lang)."</div>";
	$laudes.=psaume("benedictus",$lang);
	$laudes.="
	<div id=\"gauche\"><font color=red>Ant. </font>$benelat</div>
	<div id=\"droite\"><font color=red>Ant. </font>$benever</div>";
	
////// PRECES
	$refL=$reference['preces_matin']['ref'];
	$laudes.="
		<div id=\"gauche\"><font color=red><center><b>Preces</b></center> </font></div>
		<div id=\"droite\"><font color=red><center><b>Prières litaniques</b></center> </font></div>
		<div id=\"gauche\">".nl2br($reference['preces_matin']['latin']).affiche_editeur_propre("preces_matin",$refL,'lat')."</div>
		<div id=\"droite\">".nl2br($reference['preces_matin']['verna']).affiche_editeur_propre("preces_matin",$refL,$lang)."</div>";
		
	
//////// PATER
	    $laudes.=pater($lang);
	

///////// ORAISON
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
		$laudes.="<div id=\"droite\">".$oratiover." ".affiche_editeur_propre('oratio_laudes',$refL,$lang)."</div>";
	}
	if ($marque) {
		$refL=$reference['oratio']['ref'];
		$laudes.="<div id=\"droite\">$oratiover ".affiche_editeur_propre('oratio',$refL,$lang)."</div>";
	}
	

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