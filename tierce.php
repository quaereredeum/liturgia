<?php

global $baseurl;

// Activer le rapport d'erreurs PHP
if ($_SERVER['SERVER_NAME'] == "localhost" )  {
	//error_reporting(E_ALL);  
	$baseurl="http://localhost/societaslaudis";
	}
	else $baseurl="http://".$_SERVER['SERVER_NAME'];

/*
function tierce($jour,$tableau,$calendarium) {
	/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/français ne sont disponibles que pour les utilisateurs enregistrés. <a href=\"index.php?option=com_registration&task=register\">Enregistrez-vous ici pour continuer (simple et gratuit)</a>.</i></center>";
	return;
} 
//print"<br>tableau :";


$psautier=$tableau['matin']['psautier'];
$fp = @fopen ("calendrier/liturgia/psautier/".$psautier.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$ferie=$tableau['matin']['ferie'];
//print_r($tableau['matin']['ferie']);
$fp = @fopen ("calendrier/liturgia/psautier/".$ferie.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$special=$tableau['matin']['special'];
$fp = @fopen ("calendrier/liturgia/psautier/".$special.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$propre=$tableau['matin']['propre'];
$fp = @fopen ("calendrier/liturgia/psautier/".$propre.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
		$reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);


$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
$jrdelasemaine=date("w",$day);
//print " <br>jrdelasemaine : $jrdelasemaine";
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];
/*
if($calendarium['rang'][$jour]) {
	    $prop=$mense.$die;
	    $fp = @fopen ("calendrier/liturgia/psautier/".$prop.".csv","r");
		while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $propre[$id]['latin']=$data[1];
	    $propre[$id]['francais']=$data[2];
	    $row++;
		}
	@fclose($fp);
	}
*/

$fp = @fopen ("calendrier/liturgia/jours.csv","r","1");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $jo[$id]['latin']=$latin;
	    $jo[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);

$jrdelasemaine++; // pour avoir dimanche=1 etc...


	$row = 0;
	$fp = @fopen ("calendrier/liturgia/tierce.csv","r","1");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $lau[$row]['latin']=$latin;
	    $lau[$row]['francais']=$francais;
	    $row++;

	}
	fclose($fp);

$tem=$tableau['matin']['temps'];
 	$max=$row;
	$tierce="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$lau[$row]['latin'];
	    $fr=$lau[$row]['francais'];
	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}
		if(($tem=="Tempus passionis")&&($lat=="Allelúia.")) {
		    $lat="";
			$fr="";
		}

	if($lat=="#JOUR") {
	    if($reference['intitule']['latin']){
	    	$tierce.="<tr><td width=49%><center><b>{$reference['jour']['latin']}</b></center></td>";  
        $tierce.="<td width=49%><center><b>{$reference['jour']['francais']}</b></center></td></tr>";
        $tierce.="<tr><td width=49%><center><b>{$reference['intitule']['latin']}</b></center></td>";  
        $tierce.="<td width=49%><center><b>{$reference['intitule']['francais']}</b></center></td></tr>";
        $tierce.="<tr><td width=49%><center><font color=red> {$reference['rang']['latin']}</font></center></td><td width=49%><center><font color=red>{$reference['rang']['francais']}</font></center></td></tr>";
    $tierce.="<tr><td width=49%><center><font color=red><b>Ad Tertiam.</b></font></center></td>";
		$tierce.="<td width=49%><b><center><font color=red><b>A Tierce.</b></font></center></td></tr>";
		}
  		else {
  		$l=$jo[$jrdelasemaine]['latin'];
	    $f=$jo[$jrdelasemaine]['francais'];
		$tierce.="<tr><td width=49%><center><font color=red><b>$date_l ad Tertiam.</b></font></center></td>";
		$tierce.="<td td width=49%><b><center><font color=red><b>$date_fr à Tierce.</b></font></center></td></tr>";
			}
	}


	elseif($lat=="#HYMNUS_tertiam") {

	    //$mediahora.=hymne("hy_Ætérne_rerum_cónditor");
	    $hymne3=$reference['HYMNUS_tertiam']['latin'];
	    $tierce.=hymne($hymne3);

	    //$row++;
	}


	elseif($lat=="#ANT1*"){
	


	    $antlat=$reference['ant4']['latin'];
	    $antfr=$reference['ant4']['francais'];
	
	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 1 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 1 </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS1"){
	    $psaume="ps119";
	    $tierce.=psaume($psaume);
	    //$row++;
	}

	elseif($lat=="#ANT1"){

	    
	
	    $antlat=$reference['ant4']['latin'];
	    $antfr=$reference['ant4']['francais'];
	
	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font>$antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#ANT2*"){
	   
	    $antlat=$reference['ant5']['latin'];
	    $antfr=$reference['ant5']['francais'];

	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 2 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 2 </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS2"){
	    $psaume="ps120";
	    $tierce.=psaume($psaume);
	    //$row++;
	}

 	elseif($lat=="#ANT2"){
 	    
	    $antlat=$$reference['ant4']['latin'];
	    $antfr=$$reference['ant4']['francais'];

	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#ANT3*"){
	    
	    $antlat=$$reference['ant6']['latin'];
	    $antfr=$reference['ant6']['francais'];

	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 3</font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS3"){
	    $psaume="ps121";
	    $tierce.=psaume($psaume);
	    //$row++;
	}

 	elseif($lat=="#ANT3"){
 	    
	    $antlat=$reference['ant6']['latin'];
	    $antfr=$reference['ant6']['francais'];

	    $tierce.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;

	}


 	elseif($lat=="#LB_3"){
	    
	    $lectiobrevis=$reference['LB_3']['latin'];
	    $tierce.=lectiobrevis($lectiobrevis);
	}
	elseif($lat=="#RB_3"){
	    
	    $rblat=nl2br($reference['RB_3']['latin']);
	    $rbfr=nl2br($reference['RB_3']['francais']);

	    $tierce.="<tr><td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>";

	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");
	}




	elseif($lat=="#ORATIO_3"){
	    
	        $oratio3lat=$reference['oratio']['latin'];
	    	$oratio3fr=$reference['oratio']['francais'];
	   
	    if(($reference['oratio_3']['latin'])&&($reference['rang']==""))$oratio3lat=$reference['oratio_3']['latin'];
	    if(($reference['oratio_3']['latin'])&&($reference['rang']==""))$oratio3fr=$reference['oratio_3']['francais'];

	    if ((substr($oratio3lat,-13))==" Per Dóminum.") {
	        $oratio3lat=str_replace(" Per Dóminum.", " Per Christum Dóminum nostrum.",$oratio3lat);
	    	$oratio3fr.=" Par le Christ, notre Seigneur.";
	    }
	    
	    if ((substr($oratio3lat,-14))==" Per Christum.") {
	        $oratio3lat=str_replace(" Per Christum.", " Per Christum Dóminum nostrum.",$oratio3lat);
	    	$oratio3fr.=" Par le Christ, notre Seigneur.";
	    }

        if ((substr($oratio3lat,-11))==" Qui tecum.") {
	        $oratio3lat=str_replace(" Qui tecum.", " Qui vivit et regnat in sæcula sæculórum.",$oratio3lat);
	    	$oratio3fr.=" Lui qui vit et règne pour les siècles des siècles.";
	    }

        if ((substr($oratio3lat,-11))==" Qui vivit.") {
	        $oratio3lat=str_replace(" Qui vivit.", " Qui vivit et regnat in sæcula sæculórum.",$oratio3lat);
	    	$oratio3fr.=" Lui qui vit et règne pour les siècles des siècles.";
	    }

        if ((substr($oratio3lat,-11))==" Qui vivis.") {
	        $oratio3lat=str_replace(" Qui vivis.", " Qui vivis et regnas in sæcula sæculórum.",$oratio3lat);
	    	$oratio3fr.=" Toi qui vis et règnes pour les siècles des siècles.";
	    }

	    
	    
	    
	    $tierce.="
	    <tr>
	    <td>Oremus</td><td>Prions</td></tr>
	    <tr>
	<td id=\"colgauche\">$oratio3lat</td><td id=\"coldroite\">$oratio3fr</td></tr>";
	    //$row++;
	}



	else {
	    if(($lat)||($fr))
		$tierce.="
		<tr>
		<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
		}
	}
	$tierce.="</table>";
	$tierce= rougis_verset ($tierce);

   $tierce=utf($tierce);

	return $tierce;

}
*/

?>
