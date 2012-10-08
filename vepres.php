<?php


function vepres($jour,$tableau,$calendarium) {
$vepres="";
	//print_r($tableau);
	$psautier=$tableau['soir']['psautier'];
$fp = fopen ("calendrier/liturgia/psautier/".$psautier.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    if($id=="HYMNUS_vepres") $id="HYMNUS_vesperas";
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    //$row++;
	}
	fclose($fp);

$ferie=$tableau['soir']['ferie'];
$fp = @fopen ("calendrier/liturgia/psautier/".$ferie.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    if($id=="HYMNUS_vepres") $id="HYMNUS_vesperas";
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    //$row++;
	}
	@fclose($fp);

$special=$tableau['soir']['special'];
$fp = @@fopen ("calendrier/liturgia/psautier/".$special.".csv","r","1");
	while ($data = @@fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    if($id=="HYMNUS_vepres") $id="HYMNUS_vesperas";
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    //$row++;
	}
	@fclose($fp);

$propreS=$tableau['soir']['propre'];
$fp = @@fopen ("calendrier/liturgia/psautier/".$propreS.".csv","r","1");
	while ($data = @@fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    if($id=="HYMNUS_vepres") $id="HYMNUS_vesperas";
			$reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    //$row++;
	}
	@fclose($fp);
	
	//print_r($reference);
	
	//print_r($calendarium['hebdomada'][$jour]);
	if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	    $temp['ps7']['latin']="ps109";
		$temp['ps8']['latin']="ps113A";
		$temp['ps9']['latin']="NT12";
	}

$jours_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
$jours_fr= array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux Ières ");
$jour=$_GET['date'];
//print"<br>Jour =".$jour;
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
//print"<br>day=".$day;
if($day==-1) $day=time();
$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];
$fp = @fopen ("calendrier/liturgia/jours.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $jo[$id]['latin']=$latin;
	    $jo[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
$jrdelasemaine++; // pour avoir dimanche=1 etc...

//print"<br>$oratiolat";

	// format $jour=AAAAMMJJ
	$row = 0;
	$fp = @fopen ("calendrier/liturgia/vepres.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $vesp[$row]['latin']=$latin;
	    $vesp[$row]['francais']=$francais;
	    $row++;
	}
	$max=$row;
	$tem=$tableau['soir']['temps'];
	$vepres.="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$vesp[$row]['latin'];
	    $fr=$vesp[$row]['francais'];
	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}
        if(($tem=="Tempus passionis")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}
	if($lat=="#JOUR") {
	    $jrdelasemaine=date("w",$day);
		$date_fr=$jours_fr[$jrdelasemaine];
		$date_l=$jours_l[$jrdelasemaine];
		
      if($reference['intitule']){
      		if($reference['rubrique']!="") {
			  $vepres.="<tr><td width=49%><font color=red>{$reference['rubrique']['latin']}</font></td>";
			  $vepres.="<td width=49%><font color=red>{$reference['rubrique']['francais']}</font></td></tr>";
			  }
            $vepres.="<tr><td width=49%><center><b>{$reference['jour']['latin']}</b></center></td>";
            $vepres.="<td width=49%><center><b>{$reference['jour']['francais']}</b></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><b>{$reference['intitule']['latin']}</b></center></td><td width=49%><center><b>{$reference['intitule']['francais']}</b></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><font color=red>{$reference['rang']['latin']}</font></center></td><td width=49%><center><font color=red>{$reference['rang']['francais']}</font></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><font color=red><b>Ad ";
			if($tableau['soir']['1V']=="1") $vepres.="I ";
			else if($calendarium['1V'][$jour]==1) $vepres.="II ";
			$vepres.="Vesperas</b></font></center></td>";
			$vepres.="<td width=49%><b><center><font color=red><b>Aux ";
			if($tableau['soir']['1V']=="1") $vepres.="Ières ";
			else if($calendarium['1V'][$jour]==1) $vepres.="IIes ";
			$vepres.="Vêpres</b></font></center></td></tr>";
			
	    }
	else {
		$vepres.="<tr><td width=49%><center><font color=red><b>$date_l Vesperas</b></font></center></td>";
		$vepres.="<td width=49%><b><center><font color=red><b>$date_fr Vêpres</b></font></center></td></tr>";
		}
	}

	elseif($lat=="#HYMNUS") {
	    if(!$hymne) $hymne=$reference['HYMNUS_vesperas']['latin'];
	    if($tableau['soir']['1V']=="1") $hymne=$reference['HYMNUS_1V']['latin'];
	    //print"<br> hymne = $hymne";
	    //else $hymne=$propre
	    $vepres.=hymne($hymne);
	    //$row++;
	}

	elseif($lat=="#ANT1*"){
			$antlat=$reference['ant7']['latin'];
	    	$antfr=$reference['ant7']['francais'];
	    	if(($tableau['soir']['1V']=="1")&&($reference['ant01']['latin'])) {
	    	    $antlat=$reference['ant01']['latin'];
	    		$antfr=$reference['ant01']['francais'];
	    	
	    	}
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 1</font> $antlat</td>
	<td id=\"coldroite\"><font color=red>Ant.1</font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#PS1"){
	    $psaume=$reference['ps7']['latin'];
	    if(($tableau['soir']['1V']=="1")&&($reference['ps01']['latin'])) $psaume=$reference['ps01']['latin'];
	    $vepres.=psaume($psaume);
	    //$row++;
	}

	elseif($lat=="#ANT1"){
        $antlat=$reference['ant7']['latin'];
	    $antfr=$reference['ant7']['francais'];
	    if(($tableau['soir']['1V']=="1")&&($reference['ant01']['latin'])) {
	    	    $antlat=$reference['ant01']['latin'];
	    		$antfr=$reference['ant01']['francais'];

	    	}
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#ANT2*"){
	    
        $antlat=$reference['ant8']['latin'];
        $antfr=$reference['ant8']['francais'];
        if(($tableau['soir']['1V']=="1")&&($reference['ant02']['latin'])) {
	    	    $antlat=$reference['ant02']['latin'];
	    		$antfr=$reference['ant02']['francais'];

	    	}

        $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant.2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant.2 </font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#PS2"){

	    $psaume=$reference['ps8']['latin'];
	    if(($tableau['soir']['1V']=="1")&&($reference['ps02']['latin'])) $psaume=$reference['ps02']['latin'];	   
	    $vepres.=psaume($psaume);
	    	    //$row++;
	}

	elseif($lat=="#ANT2"){
	    	$antlat=$reference['ant8']['latin'];
	    	$antfr=$reference['ant8']['francais'];
	    	if(($tableau['soir']['1V']=="1")&&($reference['ant02']['latin'])) {
	    	    $antlat=$reference['ant02']['latin'];
	    		$antfr=$reference['ant02']['francais'];

	    	}
	    
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#ANT3*"){
			$antlat=$reference['ant9']['latin'];
	    	$antfr=$reference['ant9']['francais'];
	    	if(($tableau['soir']['1V']=="1")&&($reference['ant03']['latin'])) {
	    	    $antlat=$reference['ant03']['latin'];
	    		$antfr=$reference['ant03']['francais'];

	    	}
	    
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant.3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant.3 </font> $antfr</td></tr>";
	    //$row++;
	}
	elseif($lat=="#PS3"){
	    $psaume=$reference['ps9']['latin'];
	    if(($tableau['soir']['1V']=="1")&&($reference['ps03']['latin'])) $psaume=$reference['ps03']['latin'];
	    $vepres.=psaume($psaume);
	    //$row++;
	}
	elseif($lat=="#ANT3"){
	    	$antlat=$reference['ant9']['latin'];
	    	$antfr=$reference['ant9']['francais'];
	    	if(($tableau['soir']['1V']=="1")&&($reference['ant03']['latin'])) {
	    	    $antlat=$reference['ant03']['latin'];
	    		$antfr=$reference['ant03']['francais'];

	    	}
	    
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
	}
	elseif($lat=="#LB"){
	    //print"<br>$LB_soir";
	    $lectiobrevis=$reference['LB_soir']['latin'];
	    if(($tableau['soir']['1V']=="1")&&($reference['LB_1V']['latin'])) {
	    	    $lectiobrevis=$reference['LB_1V']['latin'];

	    	}
		//print"<br>$lectiobrevis";
	    $vepres.=lectiobrevis($lectiobrevis);
	}
	elseif($lat=="#RB"){

	    $rblat=nl2br($reference['RB_soir']['latin']);
	    $rbfr=nl2br($reference['RB_soir']['francais']);
	    if(($tableau['soir']['1V']=="1")&&($reference['RB_1V']['latin'])) {
	    	    $rblat=nl2br($reference['RB_1V']['latin']);
                $rbfr=nl2br($reference['RB_1V']['francais']);
	    	}
	    
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>Répons bref</center></b></font></td></tr>
<tr>
	<td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>

	";

	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");
	}
	elseif($lat=="#ANT_MAGN"){
	    
			$magniflat=$reference['magnificat']['latin'];
			$magniffr=$reference['magnificat']['francais'];
			$L=$tableau['soir']['lettre_annee'];
			$rr="2magnificat_".$L;
   			if($reference[$rr]['latin']) {
			$magniflat=$reference[$rr]['latin'];
			$magniffr=$reference[$rr]['francais'];
	    	}
	    	$rr="pmagnificat_".$L;
	    	if(($tableau['soir']['1V']=="1")&&($reference[$rr]['latin'])) {
			    $magniflat=$reference[$rr]['latin'];
				$magniffr=$reference[$rr]['francais'];
	    	}
	    	if(($tableau['soir']['1V']=="1")&&($reference['pmagnificat']['latin'])) {
				if($magniflat=="") {
				    $magniflat=$reference['pmagnificat']['latin'];
					$magniffr=$reference['pmagnificat']['francais'];
				
				}
			}
			
			if(($tableau['soir']['1V']=="1")&&($reference['magnificat_1V']['latin'])) {
				  $magniflat=$reference['magnificat_1V']['latin'];
					$magniffr=$reference['magnificat_1V']['francais'];
			}
	    	
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$magniflat</td><td id=\"coldroite\"><font color=red>Ant. </font> $magniffr</td></tr>";
	    //$row++;
	}



	elseif($lat=="#MAGNIFICAT"){
	    $vepres.=psaume("magnificat");
	}
	elseif($lat=="#PRECES"){
	 	$preces="preces_".$tableau['soir']['preces_soir'];
	 	//print"<br>Preces : ".$preces;
	    $vepres.=preces($preces);

	    //$vepres.=preces("preces_III");
	    //$row++;
	}
	elseif($lat=="#PATER"){
	    $vepres.=psaume("pater");
	    //$row++;
	}

	elseif($lat=="#ORATIO"){
	    //print"<br>oratiolat : ".$oratiolat;
	    $oratiolat=$reference['oratio_vesperas']['latin'];
	    $oratiofr=$reference['oratio_vesperas']['francais'];
	    if($reference['oratio']['latin']) {
	    	$oratiolat=$reference['oratio']['latin']; $oratiofr=$reference['oratio']['francais'];
	    }
	    /*
	    $oratiolat=$reference['oratio']['latin']; $oratiofr=$reference['oratio']['francais'];  
			if($reference['oratio_vesperas']['latin']) $oratiolat=$reference['oratio_vesperas']['latin'];
	    if($reference['oratio_vesperas']['francais']) $oratiofr=$reference['oratio_vesperas']['francais'];
	    */
	    if(($reference['oratio_1V']['latin'])&&($tableau['soir']['1V']=="1")) $oratiolat=$reference['oratio_1V']['latin'];
	    if(($reference['oratio_1V']['francais'])&&($tableau['soir']['1V']=="1")) $oratiofr=$reference['oratio_1V']['francais'];
   
	//print"<br> test";
	    if ((substr($oratiolat,-13))==" Per Dóminum.") {
	        $oratiolat=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Par notre Seigneur Jésus-Christ, ton Fils, qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }

        if ((substr($oratiolat,-11))==" Qui tecum.") {
	        $oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Lui qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }


        if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }


		// $rest = substr("abcdef", -2);    // returns "ef"

	    //$oratiolat=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	//$oratiolat=$oratiolat2;
	    $vepres.="
	    <tr>
	<td id=\"colgauche\">$oratiolat</td><td id=\"coldroite\">$oratiofr</td></tr>";
	    //$row++;
	}
	//print $calendarium['hebdomada'][$do];
	//&&($calendarium['hebdomada'][$do]=="Infra octavam paschae")
 	elseif (($lat=="Ite in pace. ")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="Ite in pace, allelúia, allelúia.";
	    $fr="Allez en paix, alléluia, alléluia.";
	    $vepres.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	elseif (($lat=="R/. Deo grátias.")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="R/. Deo grátias, allelúia, allelúia.";
	    $fr="R/. Rendons grâces à Dieu, alléluia, alléluia.";
	    $vepres.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}

	else $vepres.="
	<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	$vepres.="</table>";
	$vepres= rougis_verset ($vepres);
	
	$task=$_GET['task'];
	//print"<br>task=".$task;
	if($task=="tableau") {
	//print"<br>référence :";
	//print_r($tableau);
	//print_r($reference);
	
	}
	
	$vepres=utf($vepres);

	return $vepres;
}


?>
