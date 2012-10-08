<?php
/*
Plugin Name: Liturgia
Plugin URI: http://www.societaslaudis.org
Description: Liturgie latine et multilingue
Author: FXP
Version: 1.0
Author URI: http://www.societaslaudis.org
*/




add_action('wp_head','liturgia_head');
//add_action('loop_start','affiche_liturgia');

include_once ("calendarium.php");
include_once ("fonctions.php");

include_once ("tableau.php");
/*
include_once ("invitatoire.php");
include_once ("osb_vigiles.php");
include_once ("lectures.php");
include_once ("laudes2.php");
include_once ("messe.php");
include_once ("tierce2.php");
include_once ("sexte2.php");
include_once ("none2.php");
include_once ("vepres.php");
include_once ("complies2.php");
*/
//include_once ("../../../wp-includes/pluggable.php");

//$user= wp_get_current_user();

if($_GET['task']=="edit") edit_content();
if($_GET['task']=="maj") maj_content($_POST['miseajour'],$user->ID);
if($_GET['task']=="creation") creation_xml($_GET['comment']);
if($_GET['task']=="enregistreXML") enregistre_XML($_GET['comment']);
function affiche_liturgia()
{

	$lang=$_GET['lang'];
	$date=$_GET['date'];
	$option=$_GET['option'];
	print affichage();
}

function liturgia_head() {
$date=$_GET['date'];
if (!$_GET['date']) $date=date("Ymd",time());


$an=substr($date,0,4);
$mois=substr($date,4,2);
$jour=substr($date,6,2);
$date_ts=mktime(12,0,0,$mois,$jour,$an);
//print"<br>an=".$an." mois=".$mois;

$file="wp-content/plugins/liturgia/calendrier/".date("Y-m-d",$date_ts).".xml";
$xml = simplexml_load_file($file);
$couleur=$xml->couleur;
//print"<br>$file<b>couleur</b>:".$couleur;
//print"<br><b>DATE=</b>".$date;
//$calendarium=calendarium($date,$ordo);
//print "<br>Couleur date : $date ".$calendarium['couleur_template'][$date]; //print_r($calendarium['couleur_template']);
  $tempus=$xml->tempus; 
  $hebdomada=$xml->hebdomada;
  $intitule=$xml->intitule;
 
  $GLOBALS['tempus']=$xml->tempus->fr;
  $GLOBALS['hebdomada']=$xml->hebdomada->fr;
  $GLOBALS['intitule']=$xml->intitule->fr;
  $GLOBALS['rang']=$xml->rang->fr;
  $GLOBALS['lune']=$xml->age_lunaire;
  $GLOBALS['selection']=$xml->selection;
  $GLOBALS['nb_promos']=$xml->nb_promos;

//print"<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.web-esperance.fr/wp-content/plugins/liturgia/style/liturgie-".$couleur.".css\" />";

//print"<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.web-esperance.fr/wp-content/plugins/liturgia/style/liturgia.css\" />";
print" <script>
function affichage_popup(nom_de_la_page, nom_interne_de_la_fenetre) {
	window.open (nom_de_la_page, nom_interne_de_la_fenetre, config='height=300, width=400, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no')
}
</script>";

}


?>