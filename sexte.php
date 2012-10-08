<?php



/*
function sexte($jour,$tableau,$calendarium) {
	$mode=$_GET['mode'];
	//print"<br>MODE=$mode";
	/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/français ne sont disponibles que pour les utilisateurs enregistrés. <a href=\"index.php?option=com_registration&task=register\">Enregistrez-vous ici pour continuer (simple et gratuit)</a>.</i></center>";
	return;
}

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
$fp = @@fopen ("calendrier/liturgia/psautier/".$special.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$propre=$tableau['matin']['propre'];
$fp = @@fopen ("calendrier/liturgia/psautier/".$propre.".csv","r","1");
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
	$fp = @fopen ("calendrier/liturgia/sexte.csv","r","1");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $lau[$row]['latin']=$latin;
	    $lau[$row]['francais']=$francais;
	    $row++;

	}
	fclose($fp);
$tem=$tableau['matin']['temps'];

 	$max=$row;
	$sexte="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$lau[$row]['latin'];
	    $fr=$lau[$row]['francais'];
	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}
			if(($tem=="Tempus passionis")&&($lat=="Allelúia.")){
				$lat="";
				$fr="";
			}
	if($lat=="#JOUR") {
	  if($reference['intitule']['latin']){
	    	$sexte.="<tr><td width=49%><center><b>{$reference['jour']['latin']}</b></center></td>";  
        $sexte.="<td width=49%><center><b>{$reference['jour']['francais']}</b></center></td></tr>";
        $sexte.="<tr><td width=49%><center><b>{$reference['intitule']['latin']}</b></center></td>";  
        $sexte.="<td width=49%><center><b>{$reference['intitule']['francais']}</b></center></td></tr>";
        $sexte.="<tr><td width=49%><center><font color=red> {$reference['rang']['latin']}</font></center></td><td width=49%><center><font color=red>{$reference['rang']['francais']}</font></center></td></tr>";
		
		
		$sexte.="<tr><td width=49%><center><font color=red><b>Ad Sextam</b></font></center></td>";
		$sexte.="<td width=49%><b><center><font color=red><b>A Sexte</b></font></center></td></tr>";
		}
  		else {
  		$l=$jo[$jrdelasemaine]['latin'];
	    $f=$jo[$jrdelasemaine]['francais'];
		$sexte.="<tr><td width=49%><center><font color=red><b>$date_l ad Sextam.</b></font></center></td>";
		$sexte.="<td td width=49%><b><center><font color=red><b>$date_fr à Sexte.</b></font></center></td></tr>";
			}
	}


	elseif($lat=="#HYMNUS_sextam") {

	    //$mediahora.=hymne("hy_Ætérne_rerum_cónditor");
	    $hymne6=$reference['HYMNUS_sextam']['latin'];
	    $sexte.=hymne($hymne6);

	    //$row++;
	}


	elseif($lat=="#ANT1*"){
 	    $antlat=$reference['ant4']['latin'];
	    $antfr=$reference['ant4']['francais'];

	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 1 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 1 </font> $antfr</td>";
		if($mode=="debug")$sexte.="<td>M $mode</td>";
		$sexte.="</tr>";
	    //$row++;

	}

	elseif($lat=="#PS1"){
	    $psaume=$reference['ps4']['latin'];
	    $sexte.=psaume($psaume);
	    //$row++;
	}

	elseif($lat=="#ANT1"){

	    
	    $antlat=$reference['ant4']['latin'];
	    $antfr=$reference['ant4']['francais'];

	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font>$antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#ANT2*"){
	    
	    $antlat=$reference['ant5']['latin'];
	    $antfr=$reference['ant5']['francais'];

	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 2 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 2 </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS2"){
	    $psaume=$reference['ps5']['latin'];
	    //print"<br><b>temp : ".$temp['ps5']['latin']."</b>";
	    //print_r($temp);
	    $sexte.=psaume($psaume);
	    //$row++;
	}

 	elseif($lat=="#ANT2"){
 	    
	    $antlat=$reference['ant5']['latin'];
	    $antfr=$reference['ant5']['francais'];

	    $sexte.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>
		";
     }

	elseif($lat=="#ANT3*"){
	    
	    $antlat=$reference['ant6']['latin'];
	    $antfr=$reference['ant6']['francais'];

	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 3</font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS3"){
	    $psaume=$reference['ps6']['latin'];
	    $sexte.=psaume($psaume);
	    //$row++;
	}

 	elseif($lat=="#ANT3"){
 	    
	    $antlat=$reference['ant6']['latin'];
	    $antfr=$reference['ant6']['francais'];

	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;

	}


 	elseif($lat=="#LB_6"){
	    $lectiobrevis=$reference['LB_6']['latin'];
	    $sexte.=lectiobrevis($lectiobrevis);
	}
	elseif($lat=="#RB_6"){
	    
	    $rblat=nl2br($reference['RB_6']['latin']);
	    $rbfr=nl2br($reference['RB_6']['francais']);

	    $sexte.="<tr><td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>";

	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");
	}

	elseif($lat=="#ORATIO_6"){
	    
	        $oratio6lat=$reference['oratio']['latin'];
	    	$oratio6fr=$reference['oratio']['francais'];
		
		if(($reference['oratio_6']['latin'])&&($reference['rang']==""))$oratio6lat=$reference['oratio_6']['latin'];
	    if(($reference['oratio_6']['latin'])&&($reference['rang']==""))$oratio6fr=$reference['oratio_6']['francais'];



	    //if($reference['oratio_6']['latin'])$oratio6lat=$reference['oratio_6']['latin'];
	    //if($reference['oratio_6']['latin'])$oratio6fr=$reference['oratio_6']['francais'];
	    
	    if ((substr($oratio6lat,-13))==" Per Dóminum.") {
	        $oratio6lat=str_replace(" Per Dóminum.", " Per Christum Dóminum nostrum.",$oratio6lat);
	    	$oratio6fr.=" Par le Christ, notre Seigneur.";
	    }
	    
	    if ((substr($oratio6lat,-14))==" Per Christum.") {
	        $oratio6lat=str_replace(" Per Christum.", " Per Christum Dóminum nostrum.",$oratio6lat);
	    	$oratio6fr.=" Par le Christ, notre Seigneur.";
	    }

        if ((substr($oratio6lat,-11))==" Qui tecum.") {
	        $oratio6lat=str_replace(" Qui tecum.", " Qui vivit et regnat in sæcula sæculórum.",$oratio6lat);
	    	$oratio6fr.=" Lui qui vit et règne pour les siècles des siècles.";
	    }
	    
	    if ((substr($oratio6lat,-11))==" Qui vivit.") {
	        $oratio6lat=str_replace(" Qui vivit.", " Qui vivit et regnat in sæcula sæculórum.",$oratio6lat);
	    	$oratio6fr.=" Lui qui vit et règne pour les siècles des siècles.";
	    }


        if ((substr($oratio6lat,-11))==" Qui vivis.") {
	        $oratio6lat=str_replace(" Qui vivis.", " Qui vivis et regnas in sæcula sæculórum.",$oratio6lat);
	    	$oratio6fr.=" Toi qui vis et règnes pour les siècles des siècles.";
	    }
	    
	    
	    
	    $sexte.="
	    <tr>
	    <td>Oremus</td><td>Prions</td></tr>
	    <tr>
	<td id=\"colgauche\">$oratio6lat</td><td id=\"coldroite\">$oratio6fr</td></tr>";
	    //$row++;
	}



	else {
	    if(($lat)||($fr))
		$sexte.="
		<tr>
		<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
		}
	}
	$sexte.="</table>";
	$sexte= rougis_verset ($sexte);

    $sexte=utf($sexte);

	return $sexte;

}
*/





?>
