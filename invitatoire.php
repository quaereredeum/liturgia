<?php



//fonction de lecture et de mis en forme du psaume invitatoire

function psaume_invitatoire($ref,$ant_lat,$ant_fr) {

$row = 0;
$fp = fopen ("calendrier/liturgia/ps94_inv.csv","r","1");
    while ($data = fgetcsv ($fp, 1000, ";")) {
        switch ($row){

            case 0:
                if ($data[0]!="&nbsp;") {
                    $latin="<b><center><font color=red>$data[0]</font></b></center>";
                    $francais="<b><center><font color=red>$data[1]</b></font></center>";
                }

                break;



            case 1:
                if ($data[0]!="&nbsp;") {
                    $latin="<center><font color=red>$data[0]</font></center>";
                    $francais="<center><font color=red>$data[1]</font></center>";
                }

                break;



            case 2:

                if ($data[0]!="&nbsp;") {
                    $latin="<center><i>$data[0]</i></center>";
                    $francais="<center><i>$data[1]</i></center>";
                }

                break;



            case 3:

                if($data[0]=="antiphona"){
                   $latin="V/. ".$ant_lat;
                   $francais="V/. ".$ant_fr;
                }

                break;



            default:

                switch ($data[0]){

                    case "antiphona":
                        $latin="R/. ".$ant_lat;
                        $francais="R/. ".$ant_fr;
                        break;

                    default :
                        $latin=$data[0];
                        $francais=$data[1];
                        break;
                }

                break;

        }

   //$num = count ($data);

   //print "<p> $num fields in line $row: <br>\n";

      $psaume_invitatoire .="
      
    <tr>
    <td id=\"colgauche\">$latin</td>
    <td id=\"coldroite\">$francais</td>
    </tr>";
      $row++;
    }
    //$psaume_invitatoire.="</table>";
    fclose ($fp);
    return $psaume_invitatoire;

}





/// ici le code pour l'invitatoire



function invitatoire($jour,$calendarium,$reference,$tableau) {
$invitatoire="<table bgcolor=#FEFEFE>";
//print_r($tableau);

if($reference=="") {
$psautier=$tableau['matin']['psautier'];
$fp = fopen ("calendrier/liturgia/psautier/".$psautier.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);

$ferie=$tableau['matin']['ferie'];
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
$fp = @fopen ("calendrier/liturgia/psautier/".$propre.".csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
		$reference[$id]['latin']=$data[1];
	    $reference[$id]['francais']=$data[2];
	    $row++;
	}
	@fclose($fp);
}

$jours_l = array("Dominica, post II Vesperas, ad ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, post I Vesperas, ad ");
$jours_fr=array("Le Dimanche après les IIes Vêpres, aux  ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche, après les Ières Vêpres, aux ");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=@mktime(12,0,0,$mense,$die,$anno);
if($day==-1) $day=time();



$jrdelasemaine=date("w",$day);

$date_fr=$jours_fr[$jrdelasemaine];

$date_l=$jours_l[$jrdelasemaine];

$fp = fopen ("calendrier/liturgia/jours.csv","r","1");

    while ($data = fgetcsv ($fp, 1000, ";")) {
        $id=$data[0];$latin=$data[1];$francais=$data[2];
        $jo[$id]['latin']=$latin;
        $jo[$id]['francais']=$francais;
        $row++;
    }

    fclose($fp);

$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];


$ant_invit_lat=$reference['ant_invit']['latin'];
$ant_invit_fr=$reference['ant_invit']['francais'];



$row = 0;

$fp = fopen ("calendrier/liturgia/invitatoire.csv","r","1");

while ($data = @fgetcsv ($fp, 1000, ";")) {

    $latin=$data[0];$francais=$data[1];
    $comp[$row]['latin']=$latin;
    $comp[$row]['francais']=$francais;
    $row++;

}

$max=$row;
@fclose ($fp);


for($row=0;$row<$max;$row++){

    $lat=$comp[$row]['latin'];

    $fr=$comp[$row]['francais'];



    switch ($lat) {

         case "#ANT_INVIT*":
            if (!$ant_invit_lat) {
                $ant_invit_lat=$var['ant_invit']['latin'];
                $ant_invit_fr=$var['ant_invit']['francais'];
            }
            break; //fin case #ANT_INVIT*

        case "#PS_INVIT":
            $invitatoire.=psaume_invitatoire($psaume_invit,$ant_invit_lat,$ant_invit_fr);
            break; //fin case #PS_INVIT

        case "#ANT_INVIT":
            $lat="R/. ".$ant_invit_lat;
            $fr="R/. ".$ant_invit_fr;
             $invitatoire.="
    <tr>
    <td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
            break; //fin case #ANT_INVIT

        default :
             $invitatoire.="
    <tr>
    <td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
            break; //fin default
    } // fin switch $lat
} // fin boucle for

$invitatoire= rougis_verset ($invitatoire);
$invitatoire=utf($invitatoire);
//$invitatoire.="</table>";
return $invitatoire;
}

?>
