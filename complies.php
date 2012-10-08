<?php

global $baseurl;

// Activer le rapport d'erreurs PHP
if ($_SERVER['SERVER_NAME'] == "localhost" )  {
	//error_reporting(E_ALL);  
	$baseurl="http://localhost/societaslaudis";
	}
	else $baseurl="http://".$_SERVER['SERVER_NAME'];

function complies($jour,$tableau,$calendarium) {

/*
$psautier=$tableau['soir']['psautier'];
$fp = fopen ("calendrier/liturgia/psautier/".$psautier.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);
*/

$ferie=$tableau['soir']['ferie'];
//print_r($tableau['matin']['ferie']);
$fp = @fopen ("calendrier/liturgia/psautier/".$ferie.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$special=$tableau['soir']['special'];
$fp = @fopen ("calendrier/liturgia/psautier/".$special.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$propre=$tableau['soir']['propre'];
$fp = @fopen ("calendrier/liturgia/psautier/".$propre.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
		$reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);
	
	$tem=$tableau['soir']['temps'];
	//print"<br>".$tem;
	//print_r($reference);
$var=null;

$jours_l = array("Dominica, post II Vesperas, ad ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, post I Vesperas, ad ");
$jours_fr=array("Le Dimanche après les IIes Vêpres, aux  ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche, après les Ières Vêpres, aux ");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);

$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];
$fp = @fopen ("calendrier/liturgia/jours.csv","r","1");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$latin=$data[1];$francais=$data[2];
	$jo[$id]['latin']=$latin;
	$jo[$id]['francais']=$francais;
	$row++;
}
@fclose($fp);

$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];
$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);

//if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)) {
if ($tableau['soir']['1V']=="1") {
    ////////////////////////////////////////
    /// il y a des "1ères Complies"  //////
    //////////////////////////////////////
	$fp = @@fopen ("calendrier/liturgia/psautier/comp_FVS.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$var[$id]['latin']=$data[1];
		$var[$id]['francais']=$data[2];
		$row++;
	}
	$LB_comp=null;
    $RB_comp=null;
    $pr_lat=null;
    $pr_fr=null;
    $intitule_lat=null;
    $intitule_fr=null;
    $rang_lat=null;
    $rang_fr=null;
    $preces=null;
    $ps2=1;
	
	$tempo=$calendarium['intitule'][$demain];
	$fp = @fopen ("calendrier/liturgia/psautier/".$tempo.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temp[$id]['latin']=$data[1];
		$temp[$id]['francais']=$data[2];
		$row++;
	}
	@fclose($fp);

	if($temp['intitule']['latin'])$intitule_lat=$temp['intitule']['latin'];
	if($temp['intitule']['francais'])$intitule_fr=$temp['intitule']['francais'];
	$rang_lat="Sollemnitas";
	$rang_fr="Solennité";
	//$complies_lat="Post I Vesperas, ad Completorium";
	//$complies_fr="Après les Ières Vêpres, aux Complies";
	$date_l = "Post I Vesperas, ad ";
	$date_fr = "Après les Ières Vêpres, aux ";
}

//if (($calendarium['1V'][$jour]==1)&&($calendarium['priorite'][$jour]<$calendarium['priorite'][$demain])&&($jrdelasemaine!=1)) {
if (($calendarium['1V'][$jour]==1)&&($calendarium['priorite'][$jour]<$calendarium['priorite'][$demain])) {
    ////////////////////////////////////////
    /// il y a des "2ndes Complies"  //////
    //////////////////////////////////////
	$fp = @fopen ("calendrier/liturgia/psautier/comp_FS.csv","r","1");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$var[$id]['latin']=$data[1];
		$var[$id]['francais']=$data[2];
		$row++;
	}
	$LB_comp=null;
	$RB_comp=null;
	$pr_lat=null;
	$pr_fr=null;
	$intitule_lat=null;
	$intitule_fr=null;
	$rang_lat=null;
	$rang_fr=null;
	$preces=null;
	
	$ps2=1;
	$tempo=$calendarium['intitule'][$jour];
	$fp = @fopen ("calendrier/liturgia/psautier/".$tempo.".csv","r","1");
	//$fp = @fopen ("calendrier/liturgia/psautier/".$prop.".csv","r");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temp[$id]['latin']=$data[1];
		$temp[$id]['francais']=$data[2];
		$row++;
	}
	@fclose($fp);
	
	if($temp['intitule']['latin'])$intitule_lat=$temp['intitule']['latin'];
	if($temp['intitule']['francais'])$intitule_fr=$temp['intitule']['francais'];
	$rang_lat="Sollemnitas";
	$rang_fr="Solennité";
	$date_l = "Post II Vesperas, ad ";
	$date_fr = "Après les IIes Vêpres, aux ";
}

if(!$var){
	$fp = @fopen ("calendrier/liturgia/psautier/comp_F".$jrdelasemaine.".csv","r","1");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$var[$id]['latin']=$latin;
		$var[$id]['francais']=$francais;
		$row++;
	}
	@fclose($fp);
}
$row = 0;

$fp = @fopen ("calendrier/liturgia/complies.csv","r","1");
while ($data = @fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$comp[$row]['latin']=$latin;
	$comp[$row]['francais']=$francais;
	$row++;
}
$max=$row;

$complies="<table bgcolor=#FEFEFE>";
for($row=0;$row<$max;$row++){

    $lat=$comp[$row]['latin'];
    $fr=$comp[$row]['francais'];

    //Suppression de l'Alléluia en Carême et Semaine Sainte
    if(($tem=="Tempus Quadragesimae")&&($lat=="Allelúia.")) {
        $lat="";
        $fr="";
    }
    if(($tem=="Tempus passionis")&&($lat=="Allelúia.")) {
        $lat="";
        $fr="";
    }

    switch ($lat) {
        
        case "#JOUR":
        if($reference['intitule']) {
			$complies.="<tr><td width=49%><center><b>{$reference['intitule']['latin']}</b></center></td><td width=49%><b><center><b>{$reference['intitule']['francais']}</b></center></td></tr>";
            $complies.="<tr><td width=49%><center><font color=red><b>Ad Completorium</b></font></center></td>";
            $complies.="<td width=49%><b><center><font color=red><b>Aux Complies</b></font></center></td></tr>";
        }
        else {
        /*
        	if($reference['jour']) {
                $complies.="<tr><td width=49%><center><font color=red><b>{$reference['jour']['latin']}</b></font></center></td><td width=49%><b><center><font color=red><b>{$reference['jour']['francais']}</b></font></center></td></tr>";
                if(($jrdelasemaine!=7)&&($jrdelasemaine!=1))$complies.="<tr><td width=49%><center><font color=red>$rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
                $complies.="<tr><td width=49%><center><font color=red> $date_l Completorium</font></center></td><td width=49%><center><font color=red>$date_fr Complies</font></center></td></tr>";

				}
			*/
            if($rang_lat){
                $complies.="<tr><td width=49%><center><font color=red><b>$intitule_lat</b></font></center></td><td width=49%><b><center><font color=red><b>$intitule_fr</b></font></center></td></tr>";
                //if(($jrdelasemaine!=7)&&($jrdelasemaine!=1))$complies.="<tr><td width=49%><center><font color=red>$rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
                $complies.="<tr><td width=49%><center><font color=red> $date_l Completorium</font></center></td><td width=49%><center><font color=red>$date_fr Complies</font></center></td></tr>";
            }

            
            else{
                $complies.="<tr><td width=49%><center><font color=red><b>$date_l Completorium</b></font></center></td>";
                $complies.="<td width=49%><b><center><font color=red><b>$date_fr Complies</b></font></center></td></tr>";
                $complies.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
            }
        }
            if($reference['rubrique_complies']) {
                $complies.="<tr><td width=49%><font color=red size=-1>{$reference['rubrique_complies']['latin']}</font></td>";
                $complies.="<td width=49%><font color=red size=-1>{$reference['rubrique_complies']['francais']}</font></td></tr>";
            }
            break; //fin du case #JOUR

        case "#HYMNUS":
            if($reference['hymne_complies']) $complies.=hymne($reference['hymne_complies']['latin']);
            else switch ($tem) {
                case "Tempus Paschale":
                    $complies.=hymne("hy_Iesu, redémptor");
                break;

                case "Tempus Quadragesimae":
                case "Tempus per annum":
                    switch ($spsautier) {
                        case 1:
                        case 3:
                            $complies.=hymne("hy_Te lucis");
                            break;
                        case 2:
                        case 4:
                            $complies.=hymne("hy_Christe, qui, splendor");
                            break;
                    }
                    break;
                case "Tempus Adventus":
                    $seizedec=mktime(12,0,0,12,16,$anno);
                    if($day<=$seizedec) {
                        $complies.=hymne("hy_Te lucis");
                    }
                    else{
                        $complies.=hymne("hy_Christe, qui, splendor");
                    }
                    break;
                case "Tempus Nativitatis":
                    $sixjanv=mktime(12,0,0,1,6,$anno);
                    if($mense=="12"){
                        $annosuivante=$anno+1;
                        $sixjanv=mktime(12,0,0,1,6,$annosuivante);
                    }
                    if($day<=$sixjanv) {
                        $complies.=hymne("hy_Te lucis");
                    }
                    else{
                        $complies.=hymne("hy_Christe, qui, splendor");
                    }
                    break;
            } //fin du switch $tem

            break; //fin du case #HYMNUS

    case "#ANT1*":
        if($reference['comp_ant1']) {

			$complies.="<tr><td id=\"colgauche\"><font color=red>Ant. 1</font> {$reference['comp_ant1']['latin']}</td><td id=\"coldroite\"><font color=red>Ant.1</font>{$reference['comp_ant1']['francais']}</td></tr>";
        }
        else {
        $antlat=$var['ant1']['latin'];
        $antfr=$var['ant1']['francais'];
        if($tem=="Tempus Paschale") {
            $antlat="Allelúia, allelúia, allelúia.";
            $antfr="Alléluia, alléluia, alléluia.";
        }
        $complies.="
        <tr><td id=\"colgauche\"><font color=red>Ant. 1</font> $antlat</td><td id=\"coldroite\"><font color=red>Ant.1</font> $antfr</td></tr>";
        }
		break; //fin du case #ANT1*

    case "#PS1":
    if($reference['comp_ps1']) {
			$psaume=$reference['comp_ps1']['latin'];
        	$complies.=psaume($psaume);
		}
        else {
        $psaume=$var['ps1']['latin'];
        $complies.=psaume($psaume);
        }
        break; //fin du case #PS1

    case "#ANT1":
    if($reference['comp_ant1']) {
			$complies.="<tr><td id=\"colgauche\"><font color=red>Ant.</font> {$reference['comp_ant1']['latin']}</td><td id=\"coldroite\"><font color=red>Ant.</font>{$reference['comp_ant1']['francais']}</td></tr>";
        }
        else {
        $antlat=$var['ant1']['latin'];
        $antfr=$var['ant1']['francais'];
        if($tem=="Tempus Paschale") {
            $antlat="Allelúia, allelúia, allelúia.";
            $antfr="Alléluia, alléluia, alléluia.";
        }
        $complies.="
        <tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
        }
		break; //fin du case #ANT1

    case "#ANT2*":
    if($reference['comp_ant2']) {
        if($reference['comp_ant2']['latin']=="abs") break;
		else $complies.="<tr><td id=\"colgauche\"><font color=red>Ant 2.</font> {$reference['comp_ant2']['latin']}</td><td id=\"coldroite\"><font color=red>Ant 2.</font>{$reference['comp_ant2']['francais']}</td></tr>";
        }
        else {
        $antlat=$var['ant2']['latin'];
        $antfr=$var['ant2']['francais'];
        if ($antlat=="") {
            $ps2=0;
        }
        else {
            $ps2=1;
            if($tem=="Tempus Paschale") {
                $antlat="Allelúia, allelúia, allelúia.";
                $antfr="Alléluia, alléluia, alléluia.";
            }
        $complies.="
        <tr><td id=\"colgauche\"><font color=red>Ant.2 </font>$antlat</td>
	<td id=\"coldroite\"><font color=red>Ant.2 </font> $antfr</td></tr>";
        }
        }
        break; //fin du case #ANT2*

    case  "#PS2":
    if($reference['comp_ps2']) {
            if($reference['comp_ps2']['latin']=="abs") break;
            else {
			$psaume=$reference['comp_ps2']['latin'];
			//print"affichage gloglo";
        	$complies.=psaume($psaume);
            }
		}
        else {
        $psaume=$var['ps2']['latin'];
        if ($ps2==1) {$complies.=psaume($psaume);}
        }
		break; //fin du case #PS2

    case "#ANT2":
    if($reference['comp_ant2']) {
        if($reference['comp_ant2']['latin']=="abs") break;
		else $complies.="<tr><td id=\"colgauche\"><font color=red>Ant.</font> {$reference['comp_ant2']['latin']}</td><td id=\"coldroite\"><font color=red>Ant.</font>{$reference['comp_ant2']['francais']}</td></tr>";
        }
        else {
        $antlat=$var['ant2']['latin'];
        $antfr=$var['ant2']['francais'];
        if ($ps2==1) {
            if($tem=="Tempus Paschale") {
                $antlat="Allelúia, allelúia, allelúia.";
                $antfr="Alléluia, alléluia, alléluia.";
            }
            $complies.="
        <tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
        }
        }
        break; //fin du case #ANT2

    case "#LB":
    if($reference['comp_LB']) {
			$lectiobrevis=$reference['comp_LB']['latin'];
        	$complies.=lectiobrevis($lectiobrevis);
		}
        else {
        $lectiobrevis=$var['LB_comp']['latin'];
        $complies.=lectiobrevis($lectiobrevis);
        }
        break; //fin du case #LB

    case "#RB":
    if($reference['comp_RB']) {
			$complies.="<tr><td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>Répons bref</center></b></font></td></tr>
					<tr><td id=\"colgauche\">{$reference['comp_RB']['latin']}</td><td id=\"coldroite\">{$reference['comp_RB']['francais']}</td></tr>";
		}
        else {
    	if($tem=="Tempus Paschale"){
            $rblat=nl2br($var['RB_comp_TP']['latin']);
            $rbfr=nl2br($var['RB_comp_TP']['francais']);
        }
        
        else {
        $rblat=nl2br($var['RB_comp']['latin']);
        $rbfr=nl2br($var['RB_comp']['francais']);
        }
        $complies.="<tr><td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>Répons bref</center></b></font></td></tr>
					<tr><td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>";
        }
		break; //fin du case #RB

    case "#ANT_NUNCD":
        $magniflat="Salva nos, Dómine, vigilántes, custódi nos dormiéntes, ut vigilémus cum Christo et requiescámus in pace." ;
        $magniffr="Sauve-nous, Seigneur, quand nous veillons, garde-nous quand nous dormons, et nous veillerons avec le Messie et nous reposerons en paix.";
        if($tem=="Tempus Paschale") {
            $magniflat.=" allelúia." ;
            $magniffr.=" alléluia." ;
        }
        $complies.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$magniflat</td><td id=\"coldroite\"><font color=red>Ant. </font> $magniffr</td></tr>";
        break; //fin du case #ANT_NUNCD

    case "#NUNCDIMITTIS":
        $complies.=psaume("NT3");
        break; //fin du case #NUNCDIMITTIS

    case "#ORATIO":
    if($reference['comp_oratio']) {
            $complies.="<tr><td id=\"colgauche\">{$reference['comp_oratio']['latin']}</td><td id=\"coldroite\">{$reference['comp_oratio']['francais']}</td></tr>";
			}
        else {
        if (!$oratiolat) {
            $oratiolat=$var['oratio_vesperas']['latin'];
            $oratiofr=$var['oratio_vesperas']['francais'];
        }
        if ($calendarium['hebdomada'][$jour]=="Infra octavam paschae"){
            $oratiolat="Vox nostra te, Dómine, humíliter deprecétur, ut, domínicæ resurrectiónis hac die mystério celebráto, in pace tua secúri a malis ómnibus quiescámus, et in tua resurgámus laude gaudéntes. Per Christum Dóminum nostrum.";
            $oratiofr="Notre voix te supplie humblement, Seigneur. Nous avons célébré aujourd'hui le mystère de la résurrection du Seigneur : fais-nous reposer dans ta paix à l'abri de tout mal, et nous relever pour chanter joyeusement ta louange.";
            }
        $complies.="<tr><td id=\"colgauche\">$oratiolat</td><td id=\"coldroite\">$oratiofr</td></tr>";
        }
		break; //fin du case #ORATIO

    case "#ANT_MARIALE":
    if($reference['comp_ant_marie']) {
        $ant_marie=$reference['comp_ant_marie']['latin'];
    }
    else {
        $ant_marie="";
        switch($tem){
            case "Tempus Paschale":
                $ant_marie="ant_regina caeli";
                //$complies.=hymne("ant_regina caeli");
                break;
            case "Tempus Quadragesimae":
                $ant_marie="ant_ave regina";
                //$complies.=hymne("ant_ave regina");
                break;
            case "Tempus passionis":
                $ant_marie="ant_ave regina";
                //$complies.=hymne("ant_ave regina");
                break;
            case "Tempus Nativitatis":
                $ant_marie="ant_alma redemtoris";
                //$complies.=hymne("ant_alma redemtoris");
                break;
            case "Tempus Adventus":
                $ant_marie="ant_alma redemtoris";
                //$complies.=hymne("ant_alma redemtoris");
                break;
            case "Tempus per annum":{
                $deuxfev=mktime(12,0,0,2,2,$anno);
                /*
                if($day<=$deuxfev){
                    $complies.=hymne("ant_alma redemtoris");
                }
                */
                //print"<br>mense : $mense";
                if (($mense=="01") or ($mense=="02") or ($mense=="03")){
                    $ant_marie="ant_ave regina";
                    //$complies.=hymne("ant_ave regina");
                }
                elseif($tempo=="IN ASSUMPTIONE B. MARIAE VIRGINIS") {
                    $ant_marie="ant_ave regina";
                    //$complies.=hymne("ant_ave regina");
                }
                else {
                    $ant_marie="ant_salve regina";
                    //$complies.=hymne("ant_salve regina");
                }
            }
        }

        if(($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)){
            $ant_marie="ant_sub tuum";
        }
    }
        $complies.=hymne($ant_marie);
        break; //fin du case #ANT_MARIALE

    default :
         $complies.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
        break; //fin default

    } // fin switch $lat
} // fin boucle for
$complies.="</table>";
$complies= rougis_verset ($complies);

$complies=utf($complies);

return $complies;
}

?>
