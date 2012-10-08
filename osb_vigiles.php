<?php

//osb_vigiles($date,$tableau,$calendarium)

function osb_vigiles($jour,$tableau,$calendarium) {
$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";
$ref=$tableau['matin']['cel'];
$mode="direct";
$rang=$tableau['matin']['rang'];
$tempus=$tableau['matin']['temps'];
print_r($tableau);
//print "<br>RANG=".$rang;
//print"<br> accentuation : 'a 'y = ".creation_accents("'a 'y 'i 'o");
//print "<br> Rang = ".$rang;
/// D'abord le psautier romain
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
	
//Ensuite le psautier monastique
$j=datets($jour);
$jrdelasemaine=date("w",$j['ts'])+1;
$fp = fopen ("sources/psalterium/psalterium_osb_".$jrdelasemaine.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="psalterium/psalterium_osb_".$jrdelasemaine.".csv";
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
	
///// Après le temporal spécifique osb
$temporal=$tableau['matin']['ferie'];
$temp=explode("_",$temporal);
$tempo="osb_".$temp[0]."_".$jrdelasemaine;
//print "<br><b>TEMPO = </b>".$tempo;
$fp = fopen ("sources/propres/".no_accent($tempo).".csv","r","1");
//print"<br>OPEN :"."sources/propres/".no_accent($propre).".csv";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/".$tempo.".csv";
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

	///// Après le sanctoral spécifique osb	
$special=$tableau['matin']['propre'];
//print"<br>OPEN :"."sources/propres/".no_accent($special).".csv";
if(!$special) {
$special=substr($jour,4,4);
//$ref="osb_".$special;
}
$fp = @fopen ("sources/propres/osb_".no_accent($special).".csv","r","1");

if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/osb_".$special.".csv";
	    $row++;
	}
	@fclose($fp);
/// Eventuellement, le commun
$commun=$reference['commun']['latin'];
if ($commun) {
print "<br> COMMUN=".$commun;
$fp = @fopen ("sources/propres/osb_commun_".no_accent($commun).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/osb_commun_".$commun.".csv";
	    $row++;
	}
	@fclose($fp);
	
	$fp = @fopen ("sources/propres/commun_".no_accent($commun).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/osb_commun_".$commun.".csv";
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
	    $reference[$id]['ref']="propres/osb_".$special.".csv";
	    $row++;
	}
	@fclose($fp);
	
		$fp = @fopen ("sources/propres/osb_".no_accent($special).".csv","r","1");
if($fp) $mode="sanct";
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    if ($lang=="fr") $reference[$id]['verna']=$data[4];
	    if ($lang=="en") $reference[$id]['verna']=$data[5];
	    $reference[$id]['mode']=$data[2];
	    $reference[$id]['mp3']=$data[3];
	    $reference[$id]['ref']="propres/osb_".$special.".csv";
	    $row++;
	}
	@fclose($fp);
	
}

///// Enfin les éventuelles particularités			
$special=$tableau['matin']['special'];
//print"<br>OPEN :"."sources/propres/".no_accent($special).".csv";
$fp = @fopen ("sources/propres/".no_accent($special).".csv","r","1");
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

	/// Et quand même des choses particulières OSB
	
$special=$tableau['matin']['special'];
//print"<br>OPEN :"."sources/propres/".no_accent($special).".csv";
$fp = @fopen ("sources/propres/osb_".no_accent($special).".csv","r","1");
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

if($reference['priorite']['latin']) $rang=$reference['priorite']['latin'];	
//print_r($tableau);
//print_r($reference);
//print "<br><b> RANG = </b>".$rang;

$tem=$tableau['matin']['temps'];
 //print_r($tableau);
 //print_r($reference);

//////// INTITULE
	if($reference['intitule']) {    //// Il y a un intitulé spécial pour la célébration
		$osb_vigiles.="<div id=\"gauche\"><center>{$reference['jour']['latin']}</center></div>";
		$osb_vigiles.="<div id=\"droite\"><center>{$reference['jour']['verna']}</center></div>";
		$osb_vigiles.="<div id=\"gauche\"><center>{$reference['intitule']['latin']}</center></div>
		  <div id=\"droite\"><center>{$reference['intitule']['verna']}</center></div>";
		$osb_vigiles.="<div id=\"gauche\"><center><font color=red>{$reference['rang']['latin']}</font></center></div>
		  <div id=\"droite\"><center><font color=red>{$reference['rang']['verna']}</font></center></div>";
		$osb_vigiles.="<div id=\"gauche\"><center><font color=red><b>Ad Vigilias.</b></font></center></div>";
		if ($lang=="fr") 	$osb_vigiles.="<div id=\"droite\"><center><font color=red><b>Aux Vigiles.</b></font></center></div>";
		}
  	else {   ////// Il n'y a pas d'intitulé spécial, construction d'un intitulé standard.  
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
		$osb_vigiles.="<div id=\"gauche\"><center><font color=red><b>$date_l ad Vigilias.</b></font></center></div>";
		if ($lang=="fr") 	$osb_vigiles.="<div id=\"droite\"><center><font color=red><b>$date_fr aux Vigiles (rite monastique).</b></font></center></div>";
		if ($lang=="en") 	$osb_vigiles.="<div id=\"droite\"><center><font color=red><b>$date_en aux Vigiles (rite monastique).</b></font></center></div>";
	}

//print_r($reference);
if($mode=="direct") {
////// INITIUM
$osb_vigiles.=initium($reference['initium']['mp3'],$lang);
$osb_vigiles.="
<div id=\"gauche\"><font color=red><i>Omnia supra dicta omittuntur, quando Invitatorium immediate praecedit.</i></font></div>
<div id=\"droite\"><font color=red><i>On omet tout ce qui est ci-dessus si l'Invitatoire précède immédiatement.</i></font></div>";
	}

//	$osb_vigiles.=initium($reference['initium']['mp3'],$lang);
	
	/// Psaume d'attente.
	if($mode!="direct") {
	/*
	$refL=$reference['osb_vig_ps_attente']['ref'];
	$antlat=nl2br($reference['osb_vig_ant_attente']['latin']);
	$antver=nl2br($reference['osb_vig_ant_attente']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['ant1']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat ".affiche_editeur_propre('osb_vig_ant_attente',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver  ".affiche_editeur_propre('osb_vig_ant_attente',$refL,$lang)."</div>";
	*/
	}
	
	$psaume=$reference['osb_vig_ps_attente']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	if($mode!="direct") {
	/*
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	*/
	}
	

///// HYMNE
		$hymne=$reference['HYMNUS_lectures']['latin'];
	    $osb_vigiles.= hymne($hymne,$lang,$reference['HYMNUS_lectures']['mp3']);
if($reference['HYMNUS_lec_jour']['latin']) {
$osb_vigiles.="<div id=\"gauche\"><font color=red><i>Vel, quando Officium dicitur diurno tempore:
</i></font></div>";

$osb_vigiles.="
					<div id=\"droite\"><font color=red><i>Ou bien, lorsque l'office est dit pendant le jour :</i></font></div>";

	    $hymne=$reference['HYMNUS_lec_jour']['latin'];
	    $osb_vigiles.= hymne($hymne,$lang,$reference['HYMNUS_lec_jour']['mp3']);

}	
	/// 1er nocturne
	$osb_vigiles.="<div id=\"gauche\"><center><i>IN I NOCTURNO</i></center></div>
					<div id=\"droite\"><center><i>Ier NOCTURNE</i></center></div>";
					
///// Antiennes et 1 psaume
$refL=$reference['osb_vig_ant1']['ref'];
	$antlat=nl2br($reference['osb_vig_ant1']['latin']);
   	$antver=nl2br($reference['osb_vig_ant1']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant1']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 1 </font>$antlat ".affiche_editeur_propre('osb_vig_ant1',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 1</font> $antver ".affiche_editeur_propre('osb_vig_ant1',$refL,$lang)."</div>";
	
	$psaume=$reference['osb_vig_ps1']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if($mode!="direct") {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et 2 psaume
$refL=$reference['osb_vig_ant2']['ref'];
	$antlat=nl2br($reference['osb_vig_ant2']['latin']);
   	$antver=nl2br($reference['osb_vig_ant2']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant2']['mp2'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 2 </font>$antlat ".affiche_editeur_propre('osb_vig_ant2',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 2</font> $antver ".affiche_editeur_propre('osb_vig_ant2',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps2']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);

	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et 3 psaume
$refL=$reference['osb_vig_ant3']['ref'];
	$antlat=nl2br($reference['osb_vig_ant3']['latin']);
   	$antver=nl2br($reference['osb_vig_ant3']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant3']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 3 </font>$antlat ".affiche_editeur_propre('osb_vig_ant3',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 3</font> $antver ".affiche_editeur_propre('osb_vig_ant3',$refL,$lang)."</div>";
	
	$psaume=$reference['osb_vig_ps3']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if($mode!="direct") {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";

///// Antiennes et 4 psaume
$refL=$reference['osb_vig_ant4']['ref'];
	$antlat=nl2br($reference['osb_vig_ant4']['latin']);
   	$antver=nl2br($reference['osb_vig_ant4']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant4']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 4 </font>$antlat ".affiche_editeur_propre('osb_vig_ant4',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 4</font> $antver ".affiche_editeur_propre('osb_vig_ant4',$refL,$lang)."</div>";
	}
	
	$psaume=$reference['osb_vig_ps4']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	 
	///// Antiennes et 5 psaume
$refL=$reference['osb_vig_ant5']['ref'];
	$antlat=nl2br($reference['osb_vig_ant5']['latin']);
   	$antver=nl2br($reference['osb_vig_ant5']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant5']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 5 </font>$antlat ".affiche_editeur_propre('osb_vig_ant5',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 5 </font> $antver ".affiche_editeur_propre('osb_vig_ant5',$refL,$lang)."</div>";
	
	$psaume=$reference['osb_vig_ps5']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if($mode!="direct") {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
	///// Antiennes et 6 psaume
$refL=$reference['osb_vig_ant6']['ref'];
	$antlat=nl2br($reference['osb_vig_ant6']['latin']);
   	$antver=nl2br($reference['osb_vig_ant6']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant6']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 6 </font>$antlat ".affiche_editeur_propre('osb_vig_ant6',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 6</font> $antver ".affiche_editeur_propre('osb_vig_ant6',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps6']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";	
	
// Verset
	$refL=$reference['osb_vig_vers1']['ref'];
	$antlat=nl2br($reference['osb_vig_vers1']['latin']);
   	$antver=nl2br($reference['osb_vig_vers1']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_vers1']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Vers. </font>$antlat ".affiche_editeur_propre('osb_vig_vers1',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Vers. </font> $antver ".affiche_editeur_propre('osb_vig_vers1',$refL,$lang)."</div>";

// Benediction
	$refL=$reference['osb_vig_ben1']['ref'];
	$antlat=nl2br($reference['osb_vig_ben1']['latin']);
   	$antver=nl2br($reference['osb_vig_ben1']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ben1']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ben. </font>$antlat ".affiche_editeur_propre('osb_vig_ben1',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ben. </font> $antver ".affiche_editeur_propre('osb_vig_ben1',$refL,$lang)."</div>";

	$osb_vigiles.="<div id=\"gauche\"><center><i>Anno I</i></center></div>
					<div id=\"droite\"><center><i>Année impaire</i></center></div>"; 
$ref=$tableau['matin']['cel'];
if(($rang<=8)&&($tableau['matin']['cels'])) $ref=$tableau['matin']['cels'];	
// Lectio I

 if(!$ref) $ref="osb_".substr($jour,4,4);
$lec="LEC_$ref-I_1.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,1);
/// Resp I
$resp="RESP_$ref-1.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,1);

// Lectio II

$lec="LEC_$ref-I_2.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,2);
/// Resp II
$resp="RESP_$ref-2.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,2);

// Lectio III

$lec="LEC_$ref-I_3.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,3);
/// Resp III
$resp="RESP_$ref-3.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,3);

if($rang<=8) {
// Lectio IV

$lec="LEC_$ref-I_4.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,4);
/// Resp IV
$resp="RESP_$ref-4.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,4);
}
	$osb_vigiles.="<div id=\"gauche\"><center><i>Anno II</i></center></div>
					<div id=\"droite\"><center><i>Année paire</i></center></div>";
	
// Lectio I

$lec="LEC_$ref-II_1.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,1);
/// Resp I
$resp="RESP_$ref-1.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,1);

// Lectio II

$lec="LEC_$ref-II_2.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,2);
/// Resp II
$resp="RESP_$ref-2.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,2);

// Lectio III

$lec="LEC_$ref-II_3.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,3);
/// Resp III
$resp="RESP_$ref-3.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,3);

if($rang<=8) {
// Lectio IV

$lec="LEC_$ref-II_4.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,4);
/// Resp IV
$resp="RESP_$ref-4.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,4);
}
			/// 2ème nocturne
	$osb_vigiles.="<div id=\"gauche\"><center><i>IN II NOCTURNO</i></center></div>
					<div id=\"droite\"><center><i>IIème NOCTURNE</i></center></div>";
					
///// Antiennes et 7 psaume
$refL=$reference['osb_vig_ant7']['ref'];
	$antlat=nl2br($reference['osb_vig_ant7']['latin']);
   	$antver=nl2br($reference['osb_vig_ant7']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant7']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 7 </font>$antlat ".affiche_editeur_propre('osb_vig_ant7',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 7</font> $antver ".affiche_editeur_propre('osb_vig_ant7',$refL,$lang)."</div>";
	
	$psaume=$reference['osb_vig_ps7']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if($rang<=8) {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et 8 psaume
$refL=$reference['osb_vig_ant8']['ref'];
	$antlat=nl2br($reference['osb_vig_ant8']['latin']);
   	$antver=nl2br($reference['osb_vig_ant8']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant8']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 8 </font>$antlat ".affiche_editeur_propre('osb_vig_ant8',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 8</font> $antver ".affiche_editeur_propre('osb_vig_ant8',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps8']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if(($tempus=="Tempus Quadragesimae")&&($rang>8)) {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	$refL=$reference['osb_vig_ant9']['ref'];
	$antlat=nl2br($reference['osb_vig_ant9']['latin']);
   	$antver=nl2br($reference['osb_vig_ant9']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant9']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 9 </font>$antlat ".affiche_editeur_propre('osb_vig_ant9',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 9</font> $antver ".affiche_editeur_propre('osb_vig_ant9',$refL,$lang)."</div>";
	
}
if($rang<=8) {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
///// Antiennes et 9 psaume
$refL=$reference['osb_vig_ant9']['ref'];
	$antlat=nl2br($reference['osb_vig_ant9']['latin']);
   	$antver=nl2br($reference['osb_vig_ant9']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant9']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 9 </font>$antlat ".affiche_editeur_propre('osb_vig_ant9',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 9</font> $antver ".affiche_editeur_propre('osb_vig_ant9',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps9']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if(($mode!="direct")||($rang<=8)) { 
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";

///// Antiennes et 10 psaume
$refL=$reference['osb_vig_ant10']['ref'];
	$antlat=nl2br($reference['osb_vig_ant10']['latin']);
   	$antver=nl2br($reference['osb_vig_ant10']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant10']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 10 </font>$antlat ".affiche_editeur_propre('osb_vig_ant10',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 10 </font> $antver ".affiche_editeur_propre('osb_vig_ant10',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps10']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	
if(($rang>8)&&($tempus=="Tempus Quadragesimae")) {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	$refL=$reference['osb_vig_ant11']['ref'];
	$antlat=nl2br($reference['osb_vig_ant11']['latin']);
   	$antver=nl2br($reference['osb_vig_ant11']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant9']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 11 </font>$antlat ".affiche_editeur_propre('osb_vig_ant11',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 11</font> $antver ".affiche_editeur_propre('osb_vig_ant11',$refL,$lang)."</div>";
	
}
	
	
	
if($rang<=8) {
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
	///// Antiennes et 11 psaume
$refL=$reference['osb_vig_ant11']['ref'];
	$antlat=nl2br($reference['osb_vig_ant11']['latin']);
   	$antver=nl2br($reference['osb_vig_ant11']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant11']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 11 </font>$antlat ".affiche_editeur_propre('osb_vig_ant11',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 11</font> $antver ".affiche_editeur_propre('osb_vig_ant11',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps11']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
if(($mode!="direct")||($rang<=8)) { 
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";
	
	///// Antiennes et 12 psaume
$refL=$reference['osb_vig_ant12']['ref'];
	$antlat=nl2br($reference['osb_vig_ant12']['latin']);
   	$antver=nl2br($reference['osb_vig_ant12']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant12']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 12 </font>$antlat ".affiche_editeur_propre('osb_vig_ant12',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 12</font> $antver ".affiche_editeur_propre('osb_vig_ant12',$refL,$lang)."</div>";
}	
	$psaume=$reference['osb_vig_ps12']['latin'];

	$osb_vigiles.=psaume($psaume,$lang);
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";	

	if($rang<=8) {
// Verset
	$refL=$reference['osb_vig_vers2']['ref'];
	$antlat=nl2br($reference['osb_vig_vers2']['latin']);
   	$antver=nl2br($reference['osb_vig_vers2']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_vers2']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Vers. </font>$antlat ".affiche_editeur_propre('osb_vig_vers2',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Vers. </font> $antver ".affiche_editeur_propre('osb_vig_vers2',$refL,$lang)."</div>";

// Benediction
	$refL=$reference['osb_vig_ben2']['ref'];
	$antlat=nl2br($reference['osb_vig_ben2']['latin']);
   	$antver=nl2br($reference['osb_vig_ben2']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ben2']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ben. </font>$antlat ".affiche_editeur_propre('osb_vig_ben2',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ben. </font> $antver ".affiche_editeur_propre('osb_vig_ben2',$refL,$lang)."</div>";
}
if($rang<=8) {	
	$osb_vigiles.="<div id=\"gauche\"><center><i>Anno I</i></center></div>
					<div id=\"droite\"><center><i>Année impaire</i></center></div>";
	
// Lectio V

$lec="LEC_$ref-I_5.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,5);
/// Resp I
$resp="RESP_$ref-5.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,5);

// Lectio VI

$lec="LEC_$ref-I_6.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,6);
/// Resp II
$resp="RESP_$ref-6.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,6);

// Lectio VII

$lec="LEC_$ref-I_7.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,7);
/// Resp III
$resp="RESP_$ref-7.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,7);

// Lectio VIII

$lec="LEC_$ref-I_7.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,8);
/// Resp IV
$resp="RESP_$ref-7.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,8);

	$osb_vigiles.="<div id=\"gauche\"><center><i>Anno II</i></center></div>
					<div id=\"droite\"><center><i>Année paire</i></center></div>";
	
// Lectio V

$lec="LEC_$ref-II_5.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,5);
/// Resp I
$resp="RESP_$ref-5.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,5);

// Lectio VI

$lec="LEC_$ref-II_6.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,6);
/// Resp VI
$resp="RESP_$ref-6.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,6);

// Lectio VII

$lec="LEC_$ref-II_7.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,7);
/// Resp VII
$resp="RESP_$ref-7.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,7);

// Lectio VIII

$lec="LEC_$ref-II_8.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,8);
/// Resp VIII
$resp="RESP_$ref-8.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,8);
}

if(($mode=="direct")&&($rang>8)) {
// Lectio brevis + répons
$lec=$reference['LB_osb_vigiles']['latin'];
$osb_vigiles.=lectiobrevis($lec,$lang);
    $rblat=nl2br($reference['RB_osb_vigiles']['latin']);
	$rbver=nl2br($reference['RB_osb_vigiles']['verna']);
	$refL=$reference['RB_osb_vigiles']['ref'];
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['RB_osb_vigiles']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
	$osb_vigiles.="
		<div id=\"gauche\">$rblat ".affiche_editeur_propre('RB_osb_vigiles',$refL,'lat')."</div>
		<div id=\"droite\">$rbver ".affiche_editeur_propre('RB_osb_vigiles',$refL,$lang)."</div>";
}

//print"<br>Rang = ".$rang;
if($rang<=8) {
				/// 3ème nocturne
	$osb_vigiles.="<div id=\"gauche\"><center><i>IN III NOCTURNO</i></center></div>
					<div id=\"droite\"><center><i>IIIème NOCTURNE</i></center></div>";
		///// Antienne 13 et 3 cantiques
$refL=$reference['osb_vig_ant13']['ref'];
	$antlat=nl2br($reference['osb_vig_ant13']['latin']);
   	$antver=nl2br($reference['osb_vig_ant13']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ant13']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. 13 </font>$antlat ".affiche_editeur_propre('osb_vig_ant13',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ant. 13</font> $antver ".affiche_editeur_propre('osb_vig_ant13',$refL,$lang)."</div>";
	
	$psaume=$reference['osb_vig_ps13']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	
	$psaume=$reference['osb_vig_ps14']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	
	$psaume=$reference['osb_vig_ps15']['latin'];
	$osb_vigiles.=psaume($psaume,$lang);
	
	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ant. </font>$antlat</div>
	<div id=\"droite\"><font color=red>Ant. </font> $antver</div>";	

// Verset
	$refL=$reference['osb_vig_vers3']['ref'];
	$antlat=nl2br($reference['osb_vig_vers3']['latin']);
   	$antver=nl2br($reference['osb_vig_vers3']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_vers3']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Vers. </font>$antlat ".affiche_editeur_propre('osb_vig_vers3',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Vers. </font> $antver ".affiche_editeur_propre('osb_vig_vers3',$refL,$lang)."</div>";

// Benediction
	$refL=$reference['osb_vig_ben3']['ref'];
	$antlat=nl2br($reference['osb_vig_ben3']['latin']);
   	$antver=nl2br($reference['osb_vig_ben3']['verna']);
	$osb_vigiles.="<div id=\"gauche\">".mp3Player($reference['osb_vig_ben3']['mp3'])."</div><div id=\"droite\">&nbsp;</div>";
    	$osb_vigiles.="
	<div id=\"gauche\"><font color=red>Ben. </font>$antlat ".affiche_editeur_propre('osb_vig_ben3',$refL,'lat')."</div>
	<div id=\"droite\"><font color=red>Ben. </font> $antver ".affiche_editeur_propre('osb_vig_ben3',$refL,$lang)."</div>";

// Début de l'Evangile
// Lectio VIII

$lec="LEC_".$ref."-".$tableau['matin']['lettre_annee']."_initiumev.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,"");

$lec="LEC_".$ref."-".$tableau['matin']['lettre_annee']."_9.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,9);
/// Resp IX
$resp="RESP_$ref-9.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,9);

$lec="LEC_".$ref."-".$tableau['matin']['lettre_annee']."_10.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,10);
/// Resp X
$resp="RESP_$ref-10.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,10);

$lec="LEC_".$ref."-".$tableau['matin']['lettre_annee']."_11.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,11);
/// Resp XI
$resp="RESP_$ref-11.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,11);

$lec="LEC_".$ref."-".$tableau['matin']['lettre_annee']."_12.csv";
$osb_vigiles.=lecture_vigiles($lec,$lang,12);
/// Resp XII
$resp="RESP_$ref-12.csv";
$osb_vigiles.=repons_vigiles($resp,$lang,12);
// Te Deum
$osb_vigiles.="
	<div id=\"gauche\"><font color=red><center>Hymnus </center></font></div>
	<div id=\"droite\"><font color=red><center>Hymne </center></font> </div>";
$osb_vigiles.=hymne("Hy_Te_Deum",$lang,$mp3);

if($rang<=7) {
	$ref="_".$tableau['matin']['cel']."_".$tableau['matin']['lettre_annee'];
}
//$osb_vigiles.=lecture_vigiles($ev,$lang,"");
$osb_vigiles.=evangile_vigiles($ref,$lang);

$osb_vigiles.=hymne("HY_Te_decet_laus",$lang,$mp3);
$osb_vigiles.="<div id=\"gauche\">Orémus.</div>
	<div id=\"droite\">Prions.</div>";
}

if($rang>8) {
$osb_vigiles.="<div id=\"gauche\">Kýrie eléison. Christe eléison. Kýrie eléison.</div>
	<div id=\"droite\">Seigneur aie pitié. O Christ, aie pitié. Seigneur aie pitié.</div>
	<div id=\"gauche\">Pater noster <i><font color=red>secreto usque ad </font></i> V/. Et ne nos indúcas in tentatiónem. R/. Sed líbera nos a malo.</div>
	<div id=\"droite\">Notre père<i><font color=red> en silence jusqu'à </font></i> V/. Et ne nous abandonne pas dans l'épreuve. R/. Mais libère-nous du malin.</div>
	";
}

///////// ORAISON
	$osb_vigiles.="
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
	    
	$osb_vigiles.="<div id=\"gauche\">".$oratiolat."</div>";
	if (!$marque) {
		$refL=$reference['oratio_laudes']['ref'];
		$osb_vigiles.="<div id=\"droite\">".$oratiover." ".affiche_editeur_propre('oratio_laudes',$refL,$lang)."</div>";
	}
	if ($marque) {
		$refL=$reference['oratio']['ref'];
		$osb_vigiles.="<div id=\"droite\">$oratiover ".affiche_editeur_propre('oratio',$refL,$lang)."</div>";
	}

	$osb_vigiles.="
	<div id=\"gauche\">Benedicámus Dómino. </div>
	<div id=\"droite\">Bénissons le Seigneur.</div>
	<div id=\"gauche\">R/. Deo grátias.</div>
	<div id=\"droite\">R/. Rendons grâces à Dieu.</div>
	<div id=\"gauche\">Divínum auxílium máneat semper nobíscum.</div>
	<div id=\"droite\">Que le secours divin demeure toujours avec nous.</div>
	<div id=\"gauche\">R/. Et cum frátribus nostris abséntibus. Amen.</div>
	<div id=\"droite\">R/. Et avec nos frères absents. Amen.</div>
	
	";
	
	//$osb_vigiles.=renvoi($reference['renvoi_laudes']['mp3'],$lang);
	$osb_vigiles=utf($osb_vigiles);
	$osb_vigiles= rougis_verset ($osb_vigiles);	
//print_r($reference);
return $osb_vigiles;
}




?>