<?php


function lectures($jour,$tableau,$calendarium,$office) {

	if($office=="") $office=$_GET['office'];
$lang=$_GET['lang'];
if(!$lang) $lang=fr;

//print_r($tableau);


$psalterium=$tableau['matin']['psalterium'];
$fp = fopen ("sites/all/modules/liturgia/sources/psalterium/".$psalterium.".csv","r");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
		$reference[$id]['ref']="psalterium/".$psalterium;
	    $row++;
	}
	@fclose($fp);

$ferie=$tableau['matin']['ferie'];
$fp = @fopen ("sites/all/modules/liturgia/sources/propres/".$ferie.".csv","r");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
		$reference[$id]['ref']=$ferie;
	    $row++;
	}
	@fclose($fp);

$special=$tableau['matin']['special'];
$fp = @fopen ("sites/all/modules/liturgia/sources/propres/".$special.".csv","r");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
		$reference[$id]['ref']=$special;
	    $row++;
	}
	@fclose($fp);

$propre=$tableau['matin']['propre'];
$fp = @fopen ("sites/all/modules/liturgia/sources/propres/".$propre.".csv","r");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
		$reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
		$reference[$id]['ref']=$propre;
	    $row++;
	}
	@fclose($fp);

//print_r($reference);
//print_r($tableau);
$tem=$tableau['matin']['temps'];
//print"<br>tem : $tem | ".$tableau['temps'];
	// format $jour=AAAAMMJJ
	

// JOUR
	if($reference['intitule']){
        $lectures.="
		<div id=gauche><center>		<b>{$reference['jour']['latin']}				</b></center></div>";
        $lectures.="
		<div id=droite><center>		<b>{$reference['jour']['francais']}				</b></center></div>";
        $lectures.="
		<div id=gauche><center>		<b>{$reference['intitule']['latin']}			</b></center></div>
		<div id=droite><center>		<b>{$reference['intitule']['francais']}			</b></center></div>";
        $lectures.="
		<div id=gauche><center>		<font color=red>{$reference['rang']['latin']}	</font></center></div>
		<div id=droite><center>		<font color=red>{$reference['rang']['francais']}</font></center></div>";
        $lectures.="
		<div id=gauche><center>		<font color=red><b>Ad Officium lectionis.</b>	</font></center></div>";
		$lectures.="
		<div id=droite><center>		<font color=red><b>A l'Office des lectures.</b>	</font></center></div>";
	}
  	else {
  		    

	$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
	$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");
	$jour=$_GET['date'];
	$anno=substr($jour,0,4);
	$mense=substr($jour,4,2);
	$die=substr($jour,6,2);
	$day=@mktime(12,0,0,$mense,$die,$anno);
	if($day==-1) $day=time();
	$jrdelasemaine=date("w",$day);
	$date_fr=$jours_fr[$jrdelasemaine];
	$date_l=$jours_l[$jrdelasemaine];
  	$jrdelasemaine=date("w",$day);
	$date_fr=$jours_fr[$jrdelasemaine];
	$date_l=$jours_l[$jrdelasemaine];
  	$l=$jo[$jrdelasemaine]['latin'];
	$f=$jo[$jrdelasemaine]['francais'];
	$lectures.="
	<div id=gauche><center>		<b>{$reference['intitule']['latin']}				</b>	</center>	</div>
	<div id=droite><center>		<b>{$reference['intitule']['francais']}				</b>	</center>	</div>";
	if($reference['intitule']['latin']) {$date_l=""; $date_fr="";}
	$lectures.="
	<div id=gauche><center>		<font color=red>	<b>$date_l ad Officium lectionis.</b>		</font>	</center>	</div>";
	$lectures.="
	<div id=droite><center>		<font color=red>	<b>$date_fr à l'Office des lectures.</b>	</font>	</center>	</div>";
	
	}
			
		
/// Deus in... etc.
/*
			$lectures.="<div id=gauche>V/. Deus, in adiutórium meum inténde.</div>";
			$lectures.="<div id=droite>V/.  Dieu, viens à mon aide.</div>";
			$lectures.="<div id=gauche>R/. Dómine, ad adiuvándum me festína.</div>";
			$lectures.="<div id=droite>R/. Seigneur, vite à mon secours.</div>";
			$lectures.="<div id=gauche>Gloria Patri, et Fílio, * et Spirítui Sancto.</div>";
			$lectures.="<div id=droite>Gloire au Père, au Fils et au Saint Esprit.</div>";
			$lectures.="<div id=gauche>Sicut erat in principio, et nunc et semper et in sæcula sæculórum. Amen.</div>";
			$lectures.="<div id=droite>Comme il était au commencement, maintenant et toujours, et dans les siècles des siècles. Amen.</div>";
			$all_lat="Allelúia.";
			$all_fr="Alléluia.";
			if($tem=="Tempus Quadragesimae") {
				$all_lat="";
				$all_fr="";
			}
			if($tem=="Tempus passionis") {
				$all_lat="";
				$all_fr="";
			}
			$lectures.="<div id=gauche>".$all_lat."</div>";
			$lectures.="<div id=droite>".$all_fr."</div>";
		
*/
$lectures.=initium($reference['initium']['mp3'],$lang);
	$lectures.="<div id=gauche><font color=red size=-1>Omnia supra dicta omittuntur, quando Invitatorium immediate praecedit.</font></div>";
	$lectures.="<div id=droite><font color=red size=-1>On omet tout ce qui est ci-dessus si l'Invitatoire précède immédiatement.</font></div>";

// Affichage Hymne

	
	    $hymne=$reference['HYMNUS_lectures']['latin'];
	    $lectures.= hymne($hymne,$lang,$reference['HYMNUS_lectures']['mp3']);
	    //$row++;
	   
// ANT1
			$refL=$reference[ant01]['ref'];
	      $antlat=nl2br($reference['ant01']['latin']);
	    	$antfr=nl2br($reference['ant01']['francais']);
	    	$lectures.="
	    	<div id=gauche><font color=red>Ant. 1 </font>$antlat".affiche_editeur_propre('ant01',$refL,'lat')."</div>
			<div id=droite><font color=red>Ant. 1</font> $antfr".affiche_editeur_propre('ant01',$refL,$lang)."</div>";
 
// Psaume 1
	    $psaume=$reference['ps01']['latin'];
	    $lectures.=psaume($psaume,$lang);
// ANT1
  			
			$antlat=nl2br($reference['ant01']['latin']);
	    	$antfr=nl2br($reference['ant01']['francais']);
	    	$lectures.="
	    	<<div id=gauche><font color=red>Ant. </font>$antlat</div>
			<div id=droite><font color=red>Ant. </font> $antfr</div>";

//ANT2
			$refL=$reference[ant02]['ref'];
	        $antlat=nl2br($reference['ant02']['latin']);
	    	$antfr=nl2br($reference['ant02']['francais']);
	    	$lectures.="
	    		<div id=gauche><font color=red>Ant. 2 </font>$antlat".affiche_editeur_propre('ant02',$refL,'lat')."</div>
				<div id=droite><font color=red>Ant. 1</font> $antfr".affiche_editeur_propre('ant02',$refL,$lang)."</div>";
//PS2
	    $psaume=$reference['ps02']['latin'];
	    $lectures.=psaume($psaume,$lang);
//ANT2
	        $antlat=nl2br($reference['ant02']['latin']);
	    	$antfr=nl2br($reference['ant02']['francais']);
	    	$lectures.="
	    	<div id=gauche><font color=red>Ant. </font>$antlat</div>
			<div id=droite><font color=red>Ant. </font> $antfr</div>";

//ANT3
			$refL=$reference[ant03]['ref'];
	        $antlat=nl2br($reference['ant03']['latin']);
	    	$antfr=nl2br($reference['ant03']['francais']);
	    	$lectures.="
	    	<div id=gauche><font color=red>Ant. 3 </font>$antlat".affiche_editeur_propre('ant03',$refL,'lat')."</div>
			<div id=droite><font color=red>Ant. 3</font> $antfr".affiche_editeur_propre('ant03',$refL,'lat')."</div>";

//PS3
	    $psaume=$reference['ps03']['latin'];
	    $lectures.=psaume($psaume,$lang);
	    //$row++;
//ANT3
	    $antlat=nl2br($reference['ant03']['latin']);
	    $antfr=nl2br($reference['ant03']['francais']);
	   
	$lectures.="
	<div id=gauche><font color=red>Ant. </font>$antlat</div>
	<div id=droite><font color=red>Ant. </font> $antfr</div>";
//Verset
  $versetlat=nl2br($reference['VERS']['latin']);
	$versetfr=nl2br($reference['VERS']['francais']);
	 $refL=$reference['VERS']['ref'];  
	$lectures.="
	<div id=gauche>$versetlat".affiche_editeur_propre('VERS',$refL,'lat')."</div>
	<div id=droite>$versetfr".affiche_editeur_propre('VERS',$refL,$lang)."</div>";
// Lectio prior
	$lectures.="
	<div id=gauche><center><font color=red><b>Lectio prior</b></font></center></div>
	<div id=droite><center><font color=red><b>1ère lecture</b></font></center></div>";
		$lectures.=lectio($reference['lectio_prior']['latin']);

// Répons I	  
	$refL=$reference['resp_I']['ref']; 
	  $resplat=nl2br($reference['resp_I']['latin']);
	  $respfr=nl2br($reference['resp_I']['francais']);
	   
	$lectures.="
	<div id=gauche><font color=red>Responsorium </font> $resplat".affiche_editeur_propre('resp_I',$refL,'lat')."</div>
	<div id=droite><font color=red>Répons </font>$respfr".affiche_editeur_propre('resp_I',$refL,$lang)."</div>";
 
// Lectio altera
	$lectures.="
	<div id=gauche><center><font color=red><b>Lectio altera</b></font></center></div>
	<div id=droite><center><font color=red><b>2ème lecture</b></font></center></div>";
	$lectioref=$reference['lectio_altera']['latin'];
		
	$lectures.=lectio($lectioref);
	  
// Répons II
	  $refL=$reference['resp_II']['ref'];
	  $resplat=nl2br($reference['resp_II']['latin']);
	  $respfr=nl2br($reference['resp_II']['francais']);
	   
	$lectures.="
	<div id=gauche><font color=red>Responsorium </font>$resplat".affiche_editeur_propre('resp_II',$refL,'lat')."</div>
	<div id=droite><font color=red>Répons </font>$respfr".affiche_editeur_propre('resp_II',$refL,'lat')."</div>";

// Te Deum
$hymne=$reference['te_deum']['latin'];
	    $lectures.= lectio($hymne);

// Oraison.
$lectures.="<div id=gauche>Oremus</div>
			<div id=droite>Prions</div>";
	    
		$oratiolat=$reference['oratio_laudes']['latin'];
	    $oratiofr=$reference['oratio_laudes']['francais'];
	    if($reference['oratio']['latin']) {
            $oratiolat=$reference['oratio']['latin'];
            $oratiofr=$reference['oratio']['francais'];
	    }
	    
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
	    
	     
	    
	    $lectures.="
	    <div id=gauche>$oratiolat</div>
		<div id=droite>$oratiofr</div>";
	 
$lectures.="	 
<div id=gauche><font color=red size=-1>Deinde, saltem in celebratione communi, additur acclamatio:</font></div>
<div id=droite><font color=red size=-1>Ensuite, dans la célébration commune, on ajoute l'acclamation :</font></div>
<div id=gauche>Benedicámus Dómino. </div>
<div id=droite>	Bénissons le Seigneur.</div>
<div id=gauche>R/. Deo grátias.	</div>
<div id=droite>R/. Nous rendons grâces à Dieu.</div>";
 

	$lectures= rougis_verset ($lectures);
    $lectures=utf($lectures);
		
    //print $lectures;
    
   
	return $lectures;
	//return;
}
?>
