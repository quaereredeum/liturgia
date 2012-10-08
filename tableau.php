<?PHP

//
/*
function date2dateTS($date) { // format AAAAMMJJ
	$anno=substr($date,0,4);
	$mense=substr($date,4,2);
	$die=substr($date,6,2);
	$dts=mktime(12,0,0,$mense,$die,$anno);
	//print "<br>".$dts;
	return $dts;
}
*/

/*
function date_latin($j) {
	if($j==null) $j=time();
 $mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
 $jours = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
 $date= $jours[@date("w",$j)]." ".@date("j",$j)." ".$mois[@date("n",$j)-1]." ".@date("Y",$j);
 return $date;
}
*/
/*
function ordo_date($date) {
$calendarium=calendarium($date);
$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$dts=date2dateTS($date);

$dtsmoinsun=$dts-60*60*24;
$dtsplusun=$dts+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);


//$auj_ts=mktime (12,0,0,$mense,$die,$anno);
$jrdelasemaine=date("w",$dts)+1;
$psautier="psautier_".$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
$palterium="psalterium_".$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
	//print"Jour de la semaine :".$jrdelasemaine;
	//print"Semaine :".$calendarium['hebdomada'][$date];
if($calendarium['temporal'][$date]==$calendarium['intitule'][$date]) {
	     $specifique =$calendarium['intitule'][$date];
	}

if($calendarium['sanctoral'][$date]==$calendarium['intitule'][$date]) {
   		if(($calendarium['sanctoral'][$date])&&($calendarium['rang'][$date])) {
		   	$specifique=$mense.$die;
		   	if($date=="20080315") $specifique="0319";
		   	if($date=="20080331") $specifique="0325";
   		}
	}


///////////// MATIN//////////////////
/*
	if ($calendarium["tempus"][$date]=="Tempus per annum") {
		 $ferie="perannum_";
		 $ferie.=$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
		
		 if (($calendarium["hebdomada"][$date]=="Hebdomada XXXIV per annum")
		 &&($jrdelasemaine!="1")) {
		 	$special="Hymne dies irae";
		 }
	}
	*/
	/*
	if ($calendarium["tempus"][$date]=="Tempus Adventus") {
		 if ($calendarium['hebdomada'][$date]=="Hebdomada I Adventus") { $ferie="adventus_1";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada II Adventus") { $ferie="adventus_2";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada III Adventus") { $ferie="adventus_3";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada IV Adventus") { $ferie="adventus_4";}
            $ferie.=$jrdelasemaine;
						if(($die>16)&&($mense==12)) {
								$ferie="adventus_".$die."12";
								if($die<24)$special="adventus_".$jrdelasemaine."_ante24";
						}

	}
	if ($calendarium["tempus"][$date]=="Tempus Nativitatis") {   
	    if(($mense=="12")&&($die < 32)){
						$ferie="infraoctavamnativitas_12".$die;
						if(($jrdelasemaine=="1")&&($die!=25)) $specifique="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						
						}
			
			if($mense=="01"){
					$ferie="nativitatis_".$calendarium['hebdomada_psalterium'][$date];
					$ferie.=$jrdelasemaine;	
					$special="nativitatis_".$mense.$die;						
			}
			if($calendarium["intitule"][$date]=="IN BAPTISMATE DOMINI") $specifique="IN BAPTISMATE DOMINI";
   //print"<br><b>férie</b> :".$ferie; 
	}
	if ($calendarium["tempus"][$date]=="Tempus Quadragesimae"){
		 if ($calendarium['hebdomada'][$date]=="Dies post Cineres") { $ferie="quadragesima_0";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada I Quadragesimae") { $ferie="quadragesima_1";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada II Quadragesimae"){ $ferie="quadragesima_2";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada III Quadragesimae"){ $ferie="quadragesima_3";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada IV Quadragesimae"){ $ferie="quadragesima_4";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada V Quadragesimae"){ $ferie="quadragesima_5";}
		$ferie.=$jrdelasemaine;
		$code=$ferie;

	}
	
	if ($calendarium["tempus"][$date]=="Tempus passionis"){
		 $ferie="passionis_";
		$ferie.=$jrdelasemaine;
		if($jrdelasemaine==5) $specifique="";
		if($jrdelasemaine==7) $specifique="Sabbato Sancto";
	}
	
	
	if ($calendarium["tempus"][$date]=="Tempus Paschale") {
		 	if ($calendarium['hebdomada'][$date]=="Infra octavam paschae") { $ferie="pascha_1";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada II Paschae") { $ferie="pascha_2";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada III Paschae") { $ferie="pascha_3";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada IV Paschae") { $ferie="pascha_4";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada V Paschae") { $ferie="pascha_5";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada VI Paschae") { $ferie="pascha_6";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada VII Paschae") { $ferie="pascha_7";}
            if ($calendarium['hebdomada'][$date]==" ") { $ferie="pascha_8";}
            $ferie.=$jrdelasemaine;
            if ($calendarium['hebdomada'][$date]=="Infra octavam paschae") { $specialS="psalt_oct_paschae";}
	}


/// Calcul année A, B ou C.
//$ann[]={"","A","B","C"};
$diff=$anno-1969;
$annABC=$diff%3;
$lettre_annee=array("A","B","C");
//print_r($lettre_annee);
if(($mense=="11")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$date]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$date]=="Tempus Nativitatis")) {
	//// ici décalage d'un mois de l'année A, B ou C
	$increment=1;
	//if($annABC) $annABC=0;
}
$annABC=$annABC+$increment;
$l_matin=$lettre_annee[$annABC];
//print"<br>Matin : anno=".$anno." diff=".$diff." annABC=".$annABC." Lettre=".$l_matin;

///////////////////////////  SOIR //////////////////////
/// calcul du lendemain :
//print"Demain :".$demain;
//print $calendarium[$demain]["1V"];
$current=$date;
if($calendarium["1V"][$demain]=="1") {

	//print"<br>Il y a peut être des 1ères vêpres";
	//print"<br> Priorite aujourd'hui : ".$calendarium["priorite"][$date]." / Priorite demain : ".$calendarium["priorite"][$demain];
	if($calendarium["priorite"][$demain]<$calendarium["priorite"][$date]) {
		//print"<br>Il y a bien des 1ères vêpres";
		$premvep=1;
		$current=$demain;
	}
	else {
		//print"Non, en fait. Il n'y a pas de 1ères vêpres";
		$premvep=0;
		$current=$date;
	}
	}

/// psautier
$jrdelasemaineS=$jrdelasemaine;
if(($jrdelasemaineS==7)&&($premvep==1)) $jrdelasemaineS=0;
$psautierS="psautier_".$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;
$psalteriumS="psalterium_".$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;

	if($calendarium['temporal'][$current]==$calendarium['intitule'][$current]) {
	     $specifiqueS =$calendarium['intitule'][$current];
	}

	if($calendarium['sanctoral'][$current]==$calendarium['intitule'][$current]) {
   		if(($calendarium['sanctoral'][$current])&&($calendarium['rang'][$current]))  $specifiqueS =substr($current,4,4);
   		if($demain=="20080315") $specifiqueS="0319";
   		if($date=="20080331") $specifiqueS="0325";
	}


	if ($calendarium["tempus"][$current]=="Tempus per annum") {
		 $ferieS="perannum_";
		 $ferieS.=$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;
		 if (($calendarium["hebdomada"][$current]=="Hebdomada XXXIV per annum")
		 &&($jrdelasemaineS!="1")) {
		 	$specialS="Hymne dies irae";
		 }
	}
	if ($calendarium["tempus"][$current]=="Tempus Adventus") {
		 if ($calendarium['hebdomada'][$current]=="Hebdomada I Adventus") { $ferieS="adventus_1";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada II Adventus") { $ferieS="adventus_2";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada III Adventus") { $ferieS="adventus_3";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada IV Adventus") { $ferieS="adventus_4";}
		 $ferieS.=$jrdelasemaineS;
		 //print"<br>die :".$die;
		 if(($die>16)&&($mense==12)) {
								$ferieS="adventus_".$die."12";
								$specialS="adventus_".$jrdelasemaine."_ante24";
						}

	}
	if ($calendarium["tempus"][$current]=="Tempus Nativitatis") {
	    //if ($calendarium['hebdomada'][$current]=="Infra Octavam Nativitatis") { $ferieS="nativitas_1";$ferieS.=$jrdelasemaineS;}
	    if(($mense=="12")&&($die < 32)){
						$ferieS="infraoctavamnativitas_12".$die;
						if($jrdelasemaine=="1") $specifiqueS="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						if($jrdelasemaine=="7") $specifiqueS="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						if($die=="31") {$specifiqueS="0101"; $premvep="1"; }
						}
			if($mense=="01"){
					//$nativitas_.calendarium['hp'][$date].$jrdelasemaine=adventus_.calendarium['hp'][$date].$jrdelasemaine;			
					//print_r($calendarium);
					//print"<br>".$calendarium['hebdomada_psalterium'][$date];;
					$ferieS="nativitatis_".$calendarium['hebdomada_psalterium'][$date];
					$ferieS.=$jrdelasemaine;	
					$specialS="nativitatis_".$mense.$die;						
			}
			if($calendarium["intitule"][$current]=="IN BAPTISMATE DOMINI") $specifiqueS="IN BAPTISMATE DOMINI";
	    

	}
	if ($calendarium["tempus"][$current]=="Tempus Quadragesimae"){
		 if ($calendarium['hebdomada'][$current]=="Dies post Cineres") { $ferieS="quadragesima_0";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada I Quadragesimae") { $ferieS="quadragesima_1";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada II Quadragesimae"){ $ferieS="quadragesima_2";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada III Quadragesimae"){ $ferieS="quadragesima_3";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada IV Quadragesimae"){ $ferieS="quadragesima_4";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada V Quadragesimae"){ $ferieS="quadragesima_5";}
		$ferieS.=$jrdelasemaineS;

	}
	
	if ($calendarium["tempus"][$date]=="Tempus passionis"){
		 $ferieS="passionis_";
		$ferieS.=$jrdelasemaine;
		if($jrdelasemaine=="5") $specifiqueS="IN CENA DOMINI";
		if($jrdelasemaine=="7") $specifiqueS="Sabbato Sancto";

	}
	
 	if ($calendarium["tempus"][$date]=="Tempus Paschale") {
		 	if ($calendarium['hebdomada'][$current]=="Infra octavam paschae") { $ferieS="pascha_1";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada II Paschae") { $ferieS="pascha_2";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada III Paschae") { $ferieS="pascha_3";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada IV Paschae") { $ferieS="pascha_4";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada V Paschae") { $ferieS="pascha_5";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada VI Paschae") { $ferieS="pascha_6";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada VII Paschae") { $ferieS="pascha_7";}
            if ($calendarium['hebdomada'][$current]==" ") { $ferieS="pascha_8";}
            $ferieS.=$jrdelasemaineS;
            if ($calendarium['hebdomada'][$current]=="Infra octavam paschae") { $specialS="psalt_oct_paschae";}

	}


	/// Calcul année A, B ou C.
//$ann[]={"","A","B","C"};
$diff=$anno-1969;
$annABC=$diff%3;
$lettre_annee=array("A","B","C");
//print_r($lettre_annee);
$increment=0;
if(($mense=="11")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$current]=="Tempus Nativitatis")) {
	//// ici décalage d'un mois de l'année A, B ou C
	$increment=1;
	//if($annABC) $annABC=0;
}
$annABC=$annABC+$increment;
$l_soir=$lettre_annee[$annABC];
//print"<br>Soir : anno=".$anno." diff=".$diff." annABC=".$annABC." Lettre=".$l_soir;
	//$ferie=$ferie.date("w",$date);
	
	
//// Calcul du num. des preces

if ($premvep=="1") $preces_soir="I";
if ($jrdelasemaine=="1") { $preces_matin="II"; $preces_soir="III"; }
if ($jrdelasemaine=="2") { $preces_matin="IX"; $preces_soir="X"; }
if ($jrdelasemaine=="3") { $preces_matin="XI"; $preces_soir="XII"; }
if ($jrdelasemaine=="4") { $preces_matin="XIII"; $preces_soir="XIV"; }
if ($jrdelasemaine=="5") { $preces_matin="XV"; $preces_soir="XVI"; }
if ($jrdelasemaine=="6") { $preces_matin="XVII"; $preces_soir="XVIII"; }
if ($jrdelasemaine=="7") $preces_matin="XIII";

if($calendarium['rang'][$date]=="Memoria") {
	if ($jrdelasemaine=="2") { $preces_matin="IV"; $preces_soir="VII"; }
	if ($jrdelasemaine=="3") { $preces_matin="V"; $preces_soir="VIII"; }
	if ($jrdelasemaine=="4") { $preces_matin="VI"; $preces_soir="IV"; }
	if ($jrdelasemaine=="5") { $preces_matin="VII"; $preces_soir="V"; }
	if ($jrdelasemaine=="6") { $preces_matin="VIII"; $preces_soir="VI"; }
	if ($jrdelasemaine=="7") $preces_matin="V";
}
if($calendarium['rang'][$date]=="Festum") {
	$preces_matin="V"; $preces_soir="VI";
}

if($calendarium['rang'][$date]=="Sollemnitas") {
	$preces_matin="IV"; $preces_soir="II";
}

if($calendarium['hebdomada'][$date]=="Infra octavam paschae") {
	$preces_matin="VI"; $preces_soir="III";
}
if (($jrdelasemaine=="1")&&($calendarium['tempus'][$date]=="Tempus Quadragesimae")) { $preces_soir="VIII"; }
////////////////////////////////////

$ordo_date['matin']['temps']=$calendarium["tempus"][$date];
$ordo_date['soir']['temps']=$calendarium["tempus"][$current];
$ordo_date['matin']['psautier']=$psautier;
$ordo_date['soir']['psautier']=$psautierS;
$ordo_date['matin']['ferie']=$ferie;
$ordo_date['soir']['ferie']=$ferieS;
$ordo_date['matin']['special']=$special;
$ordo_date['soir']['special']=$specialS;
$ordo_date['soir']['1V']=$premvep;
$ordo_date['matin']['propre']=$specifique;
$ordo_date['soir']['propre']=$specifiqueS;
$ordo_date['matin']['lettre_annee']=$l_matin;
$ordo_date['soir']['lettre_annee']=$l_soir;
$ordo_date['matin']['preces_matin']=$preces_matin;
$ordo_date['soir']['preces_soir']=$preces_soir;
$ordo_date['matin']['intitule']=$calendarium["intitule"][$date];
$ordo_date['soir']['intitule']=$calendarium["intitule"][$current];
 return $ordo_date;
}

function ordo_plusieursjours($date_debut,$date_fin) {
	$calendarium=calendarium($date_debut);
	$date_debut_ts=date2dateTS($date_debut);
	$date_fin_ts=date2dateTS($date_fin);
	$buff0="<a name=\"Sommaire\">Sommaire</a>";
	for($cour=$date_debut_ts;$cour<=$date_fin_ts;$cour=$cour+60*60*24) {
	    $cc=date("Ymd",$cour);
	    $ordo=ordo_date($cc);
	    $buff0.="<br><a href=\"#$cc\">".date_latin($cour)." ".$ordo['matin']['intitule']."</a>&nbsp;<a href=#Sommaire>Sommaire</a>";
	    //print"<br>$cc";
		
		$buff.="<a name=$cc>".date_latin($cour)." ".$ordo['matin']['intitule']."</a>";
		
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_martyrologe>".date_latin($cour)." ".$ordo['matin']['intitule'];
		$buff.=martyrologe($cc,$my)."<p>";		
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_invitatoire>".date_latin($cour)." ".$ordo['matin']['intitule'];
	  $buff.=invitatoire($cc,$calendarium,$reference,$tableau)."<p>";
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_laudes>".date_latin($cour)." ".$ordo['matin']['intitule'];
	  $buff.=laudes($cc,$ordo,$calendarium,$my)."<p>";
	  $buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
	  $buff.="<br><a name=".$cc."_tierce>".date_latin($cour)." ".$ordo['matin']['intitule'];
	  $buff.=tierce($cc,$ordo,$my)."<p>";
	  $buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
	  $buff.="<br><a name=".$cc."_sexte>".date_latin($cour)." ".$ordo['matin']['intitule'];
		$buff.=sexte($cc,$ordo,$my)."<p>";
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_none>".date_latin($cour)." ".$ordo['matin']['intitule'];
		$buff.=none($cc,$ordo,$my)."<p>";
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_vepres>".date_latin($cour)." ".$ordo['soir']['intitule'];
		$buff.=vepres($cc,$ordo,$calendarium,$my);
		$buff.="<a href=#".$cc."_martyrologe>Martyrologe</a>|<a href=#".$cc."_laudes>Laudes</a>|<a href=#".$cc."_tierce>Tierce</a>|<a href=#".$cc."_sexte>Sexte</a>|<a href=#".$cc."_none>None</a>|<a href=#".$cc."_vepres>Vêpres</a>|<a href=#".$cc."_complies>Complies</a>|&nbsp;<a href=#Sommaire>Sommaire</a><br>";
		$buff.="<br><a name=".$cc."_complies>".date_latin($cour)." ".$ordo['soir']['intitule'];
		$buff.=complies($cc,$ordo,$my)."<p>";
	}
		return $buff0.$buff;
		//exit();
}

*/

function tableau($calendarium,$date)  {
	
if (!$date) $date = $_GET['date'];
if (!$date) {
	$tfc=time();
	$date=date("Ymd",$tfc);
}

//print_r($calendarium);


$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);

$mj=$mense.$die;

$dts=mktime(12,0,0,$mense,$die,$anno);
//$datelatin=date_latin($dts);
$dtsmoinsun=$dts-60*60*24;
$dtsplusun=$dts+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);

$auj=$date;

///////////// MATIN//////////////////
$jrdelasemaine=date("w",$dts)+1;
$psautier="psautier_".$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
$psalterium="psalterium_".$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
//print"\r\n date : ".$date." ".$psalterium;
//print " calendarium[hebdomada_psalterium][date]=".$calendarium["hebdomada_psalterium"][$date];
if($calendarium['temporal'][$date]==$calendarium['intitule'][$date]) {
	     $specifique =$calendarium['intitule'][$date];
	}

if($calendarium['sanctoral'][$date]==$calendarium['intitule'][$date]) {
   		if(($calendarium['sanctoral'][$date])&&($calendarium['rang'][$date])) {
		   	$specifique=$mense.$die;
		   	if($date=="20080315") $specifique="0319";
		   	if($da=="20080331") $specifique="0325";
   		}
	}



	if ($calendarium["tempus"][$date]=="Tempus per annum") {
		 $ferie="perannum_";
		 $ferie.=$calendarium["hebdomada_psalterium"][$date].$jrdelasemaine;
		 if (($calendarium["hebdomada"][$date]=="Hebdomada XXXIV per annum")
		 &&($jrdelasemaine!="1")) {
		 	$special="Hymne dies irae";
		 }
	}
	if ($calendarium["tempus"][$date]=="Tempus Adventus") {
		 if ($calendarium['hebdomada'][$date]=="Hebdomada I Adventus") { $ferie="adventus_1";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada II Adventus") { $ferie="adventus_2";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada III Adventus") { $ferie="adventus_3";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada IV Adventus") { $ferie="adventus_4";}
            $ferie.=$jrdelasemaine;
						if(($die>16)&&($mense==12)) {
								$ferie="adventus_".$die."12";
								$code="adventus_post_1217-".$jrdelasemaine;
								if($jrdelasemaine==1) $code="adventus_41";
								if($die<24) $special="adventus_".$jrdelasemaine."_ante24";
						}

	}
	if ($calendarium["tempus"][$date]=="Tempus Nativitatis") {
	    //if ($calendarium['hebdomada'][$date]=="Infra octavam Nativitatis") { $ferie="nativitas_1";$ferie.=$jrdelasemaine;}
	    if(($mense=="12")&&($die < 32)){
						$ferie="infraoctavamnativitas_12".$die;
						$code="infraoctavamnativitas";
						if(($jrdelasemaine=="1")&&($die!=25)) $specifique="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						
						}
						
			if($mense=="01"){
					//$nativitas_.calendarium['hp'][$date].$jrdelasemaine=adventus_.calendarium['hp'][$date].$jrdelasemaine;			
					//print_r($calendarium);
					//print"<br>".$calendarium['hebdomada_psalterium'][$date];;
					$ferie="nativitatis_".$calendarium['hebdomada_psalterium'][$date];
					$ferie.=$jrdelasemaine;	
					$propre="nativitatis_".$mense.$die;
					$special="nativitatis_".$mense.$die;
					$cel=$special;		
					if($calendarium["intitule"][$date]=="Dominica II post Nativitatem") $specifique="Dominica II post Nativitatem";				
			}
			if($calendarium["intitule"][$date]=="IN BAPTISMATE DOMINI") { 
			$specifique="IN BAPTISMATE DOMINI";
			$code="IN_BAPTISMATE_DOMINI";
			}
		
    
	}
	if ($calendarium["tempus"][$date]=="Tempus Quadragesimae"){
		if ($calendarium['hebdomada'][$date]=="Dies post Cineres") { $ferie="quadragesima_0";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada I Quadragesimae") { $ferie="quadragesima_1";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada II Quadragesimae"){ $ferie="quadragesima_2";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada III Quadragesimae"){ $ferie="quadragesima_3";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada IV Quadragesimae"){ $ferie="quadragesima_4";}
		if ($calendarium['hebdomada'][$date]=="Hebdomada V Quadragesimae"){ $ferie="quadragesima_5";}
		$ferie.=$jrdelasemaine;

	}
	
	if ($calendarium["tempus"][$date]=="Tempus passionis"){
		$ferie="passionis_";
		$ferie.=$jrdelasemaine;
		if($jrdelasemaine==5) $specifique="";
		if($jrdelasemaine==7) $specifique="Sabbato Sancto";


	}
	
	
	if ($calendarium["tempus"][$date]=="Tempus Paschale") {
		 	if ($calendarium['hebdomada'][$date]=="Infra octavam paschae") { $ferie="pascha_1";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada II Paschae") { $ferie="pascha_2";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada III Paschae") { $ferie="pascha_3";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada IV Paschae") { $ferie="pascha_4";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada V Paschae") { $ferie="pascha_5";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada VI Paschae") { $ferie="pascha_6";}
            if ($calendarium['hebdomada'][$date]=="Hebdomada VII Paschae") { $ferie="pascha_7";}
            if ($calendarium['hebdomada'][$date]==" ") { $ferie="pascha_8";}
            $ferie.=$jrdelasemaine;
            if ($calendarium['hebdomada'][$current]=="Infra octavam paschae") { $specialS="psalt_oct_paschae";}

	}

/// Calcul année A, B ou C.
//$ann[]={"","A","B","C"};
$diff=$anno-1969;
$annABC=$diff%3;
$lettre_annee=array("A","B","C");
//print_r($lettre_annee);
if(($mense=="11")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="11")&&($calendarium["tempus"][$date]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$date]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$date]=="Tempus Nativitatis")) {
	//// ici décalage d'un mois de l'année A, B ou C
	$increment=1;
	//if($annABC) $annABC=0;
}
$annABC=$annABC+$increment;
$l_matin=$lettre_annee[$annABC];
//print"<br>Matin : anno=".$anno." diff=".$diff." annABC=".$annABC." Lettre=".$l_matin;
if(!$l_matin) $l_matin="A";




////////////////////////////////////////////////////////
///////////////////////////  SOIR //////////////////////
/// calcul du lendemain :
//print"Demain :".$demain;
//print $calendarium[$demain]["1V"];
$current=$date;
if($calendarium["1V"][$demain]=="1") {

	//print"<br>Il y a peut être des 1ères vêpres";
	//print"<br> Priorite aujourd'hui : ".$calendarium["priorite"][$date]." / Priorite demain : ".$calendarium["priorite"][$demain];
	if($calendarium["priorite"][$demain]<$calendarium["priorite"][$date]) {
		//print"<br>Il y a bien des 1ères vêpres";
		$premvep=1;
		$current=$demain;
	}
	else {
		//print"Non, en fait. Il n'y a pas de 1ères vêpres";
		$premvep=0;
		$current=$date;
	}
	}
/// psautier
$jrdelasemaineS=$jrdelasemaine;
if(($jrdelasemaineS==7)&&($premvep==1)) $jrdelasemaineS=0;
$psautierS="psautier_".$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;
$psalteriumS="psalterium_".$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;

	if($calendarium['temporal'][$current]==$calendarium['intitule'][$current]) {
	     $specifiqueS =$calendarium['intitule'][$current];
	}
	if($calendarium['sanctoral'][$current]==$calendarium['intitule'][$current]) {
   		if(($calendarium['sanctoral'][$current])&&($calendarium['rang'][$current]))  $specifiqueS =substr($current,4,4);
   		if($demain=="20080315") $specifiqueS="0319";
   		if($date=="20080331") $specifiqueS="0325";
	}
	if ($calendarium["tempus"][$current]=="Tempus per annum") {
		 $ferieS="perannum_";
		 $ferieS.=$calendarium["hebdomada_psalterium"][$current].$jrdelasemaineS;
		 if (($calendarium["hebdomada"][$current]=="Hebdomada XXXIV per annum")
		 &&($jrdelasemaineS!="1")) {
		 	$specialS="Hymne dies irae";
		 }
	}
	if ($calendarium["tempus"][$current]=="Tempus Adventus") {
		 if ($calendarium['hebdomada'][$current]=="Hebdomada I Adventus") { $ferieS="adventus_1";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada II Adventus") { $ferieS="adventus_2";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada III Adventus") { $ferieS="adventus_3";}
     if ($calendarium['hebdomada'][$current]=="Hebdomada IV Adventus") { $ferieS="adventus_4";}
		 $ferieS.=$jrdelasemaineS;
		 //print"<br>die :".$die;
		 if(($die>16)&&($mense==12)) {
			$ferieS="adventus_".$die."12";
			$specialS="adventus_".$jrdelasemaine."_ante24";
		}
	}
	if ($calendarium["tempus"][$current]=="Tempus Nativitatis") {
	    if ($calendarium['hebdomada'][$current]=="Infra octavam Nativitatis") { $ferieS="nativitas_1";$ferieS.=$jrdelasemaineS;}
	    if(($mense=="12")&&($die < 32)){
						$ferieS="infraoctavamnativitas_12".$die;
						if($jrdelasemaine=="1") $specifiqueS="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						if($jrdelasemaine=="7") $specifiqueS="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
						if($die=="31") {$specifiqueS="0101"; $premvep="1"; }
						}
			if($mense=="01"){
					//$nativitas_.calendarium['hp'][$date].$jrdelasemaine=adventus_.calendarium['hp'][$date].$jrdelasemaine;			
					//print_r($calendarium);
					//print"<br>".$calendarium['hebdomada_psalterium'][$date];;
					$ferieS="adventus_".$calendarium['hebdomada_psalterium'][$date];
					$ferieS.=$jrdelasemaine;	
					$specialS="nativitatis_".$mense.$die;		
					if($calendarium["intitule"][$current]=="Dominica II post Nativitatem") $specifiqueS="Dominica II post Nativitatem";					
			}
			if($calendarium["intitule"][$current]=="IN BAPTISMATE DOMINI") $specifiqueS="IN BAPTISMATE DOMINI";
	}
	if ($calendarium["tempus"][$current]=="Tempus Quadragesimae"){
		 if ($calendarium['hebdomada'][$current]=="Dies post Cineres") { $ferieS="quadragesima_0";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada I Quadragesimae") { $ferieS="quadragesima_1";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada II Quadragesimae"){ $ferieS="quadragesima_2";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada III Quadragesimae"){ $ferieS="quadragesima_3";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada IV Quadragesimae"){ $ferieS="quadragesima_4";}
		if ($calendarium['hebdomada'][$current]=="Hebdomada V Quadragesimae"){ $ferieS="quadragesima_5";}
		$ferieS.=$jrdelasemaineS;

	}
	
	if ($calendarium["tempus"][$date]=="Tempus passionis"){
		 $ferieS="passionis_";
		$ferieS.=$jrdelasemaine;
		if($jrdelasemaine=="5") $specifiqueS="IN CENA DOMINI";
		if($jrdelasemaine==7) $specifiqueS="Sabbato Sancto";

	}
	
 	if ($calendarium["tempus"][$date]=="Tempus Paschale") {
		 	if ($calendarium['hebdomada'][$current]=="Infra octavam paschae") { $ferieS="pascha_1";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada II Paschae") { $ferieS="pascha_2";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada III Paschae") { $ferieS="pascha_3";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada IV Paschae") { $ferieS="pascha_4";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada V Paschae") { $ferieS="pascha_5";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada VI Paschae") { $ferieS="pascha_6";}
            if ($calendarium['hebdomada'][$current]=="Hebdomada VII Paschae") { $ferieS="pascha_7";}
            if ($calendarium['hebdomada'][$current]==" ") { $ferieS="pascha_8";}
            $ferieS.=$jrdelasemaineS;
            if ($calendarium['hebdomada'][$current]=="Infra octavam paschae") { $specialS="psalt_oct_paschae";}

	}


	/// Calcul année A, B ou C.
$diff=$anno-1969;
$annABC=$diff%3;
$lettre_annee=array("A","B","C");
$increment=0;
if(($mense=="11")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$current]=="Tempus Adventus")||($mense=="12")&&($calendarium["tempus"][$current]=="Tempus Nativitatis")) {
	//// ici décalage d'un mois de l'année A, B ou C
	$increment=1;
	//if($annABC) $annABC=0;
}
$annABC=$annABC+$increment;
$l_soir=$lettre_annee[$annABC];
if(!$l_soir) $l_soir="A";

	
	
//// Calcul du num. des preces

if ($premvep=="1") $preces_soir="I";
if ($jrdelasemaine=="1") { $preces_matin="II"; $preces_soir="III"; }
if ($jrdelasemaine=="2") { $preces_matin="IX"; $preces_soir="X"; }
if ($jrdelasemaine=="3") { $preces_matin="XI"; $preces_soir="XII"; }
if ($jrdelasemaine=="4") { $preces_matin="XIII"; $preces_soir="XIV"; }
if ($jrdelasemaine=="5") { $preces_matin="XV"; $preces_soir="XVI"; }
if ($jrdelasemaine=="6") { $preces_matin="XVII"; $preces_soir="XVIII"; }
if ($jrdelasemaine=="7") $preces_matin="XIII";

if($calendarium['rang'][$date]=="Memoria") {
	if ($jrdelasemaine=="2") { $preces_matin="IV"; $preces_soir="VII"; }
	if ($jrdelasemaine=="3") { $preces_matin="V"; $preces_soir="VIII"; }
	if ($jrdelasemaine=="4") { $preces_matin="VI"; $preces_soir="IV"; }
	if ($jrdelasemaine=="5") { $preces_matin="VII"; $preces_soir="V"; }
	if ($jrdelasemaine=="6") { $preces_matin="VIII"; $preces_soir="VI"; }
	if ($jrdelasemaine=="7") $preces_matin="V";
}
if($calendarium['rang'][$date]=="Festum") {
	$preces_matin="V"; $preces_soir="VI";
}

if($calendarium['rang'][$date]=="Sollemnitas") {
	$preces_matin="IV"; $preces_soir="II";
}

if($calendarium['hebdomada'][$date]=="Infra octavam paschae") {
	$preces_matin="VI"; $preces_soir="III";
}
if (($jrdelasemaine=="1")&&($calendarium['tempus'][$date]=="Tempus Quadragesimae")) { $preces_soir="VIII"; }
////////////////////////////////////

$task=$_GET['task'];
if($task=="tableau") {
	print "TABLEAU";
/////// affichage tableau

print"<table>";
print"<tr><td><b>$date</b></td><td><b><center>Matin</center></b></td><td><b><center>Soir</center></b></td></tr>";
print"<tr><td><b>Psautier</b></td><td><center>".$psautier."</td><td><center>".$psautierS."</center></td></tr>";
print"<tr><td><b>Temps</b></td><td><center>".$calendarium["tempus"][$date]."</td><td><center>".$calendarium["tempus"][$current]."</center></td></tr>";
print"<tr><td><b>Férie</b></td><td><center>".$ferie."</td><td><center>".$ferieS."</center></td></tr>";
print"<tr><td><b>Spécial</b></td><td><center>".$special."</td><center><td>".$specialS."</center></td></tr>";
print"<tr><td><b>1V</b></td><td><center> </td><td><center>".$premvep."</center></td></tr>";
print"<tr><td><b>Intitule</b></td><td><center>".$calendarium["intitule"][$date]."</td><center><td>".$calendarium["intitule"][$current]."</center></td></tr>";
print"<tr><td><b>Propre</b></td><td><center>".$specifique."</td><td><center>".$specifiqueS."</center></td></tr>";
print"<tr><td><b>Annee</b></td><td><center>".$l_matin."</td><td><center>".$l_soir."</center></td></tr>";
print"<tr><td><b>Preces</b></td><td><center>".$preces_matin."</td><td><center>".$preces_soir."</center></td></tr>";
print"<tr><td><b>Cel</b></td><td><center>".$cel_matin."</td><td><center>".$cel_soir."</center></td></tr>";
print"</table>";
	
}

$tableau['matin']['temps']=$calendarium["tempus"][$date];
$tableau['soir']['temps']=$calendarium["tempus"][$current];
$tableau['matin']['psautier']=$psautier;
$tableau['matin']['psalterium']=$psalterium;
$tableau['soir']['psautier']=$psautierS;
$tableau['soir']['psalterium']=$psalteriumS;
$tableau['matin']['ferie']=$ferie;
$tableau['soir']['ferie']=$ferieS;
$tableau['matin']['special']=$special;
$tableau['soir']['special']=$specialS;
$tableau['soir']['1V']=$premvep;
$tableau['matin']['propre']=$specifique;
$tableau['soir']['propre']=$specifiqueS;
$tableau['matin']['lettre_annee']=$l_matin;
$tableau['soir']['lettre_annee']=$l_soir;
$tableau['matin']['preces_matin']=$preces_matin;
$tableau['soir']['preces_soir']=$preces_soir;

$cel_matin=$ferie;
if($tableau['matin']['temps']=="Tempus Quadragesimae") $cel_matin=$calendarium['code'][$date];
if($tableau['soir']['temps']=="Tempus Quadragesimae") $cel_soir=$calendarium['code'][$date];

if($tableau['matin']['temps']=="Tempus passionis") $cel_matin=$calendarium['code'][$date];
if($tableau['soir']['temps']=="Tempus passionis") $cel_soir=$calendarium['code'][$date];

if($tableau['matin']['temps']=="Tempus Paschale") $cel_matin=$calendarium['code'][$date];
if($tableau['matin']['temps']=="Tempus Paschale") $cel_soir=$calendarium['code'][$date];
if($tableau['matin']['temps']=="Tempus per annum") $cel_matin=$calendarium['code'][$date];
if($tableau['soir']['temps']=="Tempus per annum") $cel_soir=$calendarium['code'][$date];
if($tableau['matin']['temps']=="Tempus Adventus") $cel_matin=$ferie;
if($tableau['matin']['temps']=="Tempus Nativitatis") $cel_matin=$special;
if(($tableau['matin']['temps']=="Tempus Adventus")&&($die>16)&&($mense==12)) {
	$cel_matin=$code;
	$cel_soir=$code;
}

$tableau['matin']['cels']=$calendarium['codes'][$date];
$tableau['matin']['cel']=$cel_matin;
if(($calendarium['sanctoral'][$date]==$calendarium['intitule'][$date])&&($calendarium['priorite'][$date]<12)) $tableau['matin']['cel']="";
if(($calendarium['temporal'][$date]==$calendarium['intitule'][$date])&&($calendarium['priorite'][$date]<12)) {
 $tableau['matin']['cels']="";
 if(strstr($calendarium['intitule'][$date] , "Dominica")==null) $tableau['matin']['cel']=$tableau['matin']['propre'];
 }
$tableau['soir']['cel']=$cel_soir;
$tableau['matin']['rang']=$calendarium['priorite'][$date];
$tableau['soir']['rang']=$calendarium['priorite'][$dateS];
if($tableau['matin']['ferie']=="infraoctavamnativitas_1225") {
	$tableau['matin']['cel']="12-25_jour";
	$tableau['matin']['cels']="";
}

if($tableau['matin']['ferie']=="infraoctavamnativitas_1226") $tableau['matin']['cel']="12-26";
if($tableau['matin']['ferie']=="infraoctavamnativitas_1227") $tableau['matin']['cel']="12-27";
if($tableau['matin']['ferie']=="infraoctavamnativitas_1228") $tableau['matin']['cel']="12-28";
if($tableau['matin']['ferie']=="infraoctavamnativitas_1229") $tableau['matin']['cel']="infraoctavamnativitas";
if($tableau['matin']['cel']=="nativitatis_0101") $tableau['matin']['cel']="01-01";
if($tableau['matin']['cel']=="nativitatis_0102") $tableau['matin']['cel']="nativitatis_01-02";
if($tableau['matin']['cel']=="nativitatis_0103") $tableau['matin']['cel']="nativitatis_01-03";
if($tableau['matin']['cel']=="nativitatis_0104") $tableau['matin']['cel']="nativitatis_01-04";
if($tableau['matin']['cel']=="nativitatis_0105") $tableau['matin']['cel']="nativitatis_01-05";
if($tableau['matin']['cel']=="nativitatis_0106") $tableau['matin']['cel']="nativitatis_01-06";
if($tableau['matin']['cel']=="nativitatis_0107") $tableau['matin']['cel']="nativitatis_01-07";
if($tableau['matin']['cel']=="nativitatis_0108") $tableau['matin']['cel']="nativitatis_01-08";
if($tableau['matin']['propre']=="IN BAPTISMATE DOMINI") $tableau['matin']['cel']="IN_BAPTISMATE_DOMINI";
if($tableau['matin']['propre']=="0106") $tableau['matin']['cel']="IN_EPIPHANIA_DOMINI";
if($tableau['matin']['ferie']=="infraoctavamnativitas_1231") $tableau['matin']['cel']="infraoctavamnativitas";
if($tableau['matin']['ferie']=="infraoctavamnativitas_1230") $tableau['matin']['cel']="infraoctavamnativitas";

//$tableau['matin']['cel']=
//$tableau['soir']['cel']=$calendarium['code'][$current];
return $tableau;
}

?>
