<?php


// Activer le rapport d'erreurs PHP

function tierce($jour,$tableau,$calendarium) {
	/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/français ne sont disponibles que pour les utilisateurs enregistrés. <a href=\"index.php?option=com_registration&task=register\">Enregistrez-vous ici pour continuer (simple et gratuit)</a>.</i></center>";
	return;
} */
//print"<br>tableau :";

$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";
//print_r($tableau);
// psautier
$psalterium=$tableau['matin']['psalterium'];
$xmlpsalterium = simplexml_load_file("wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml");
$reference=ajoutexml($reference,$xmlpsalterium);
//print"<br>".$tableau['matin']['psalterium']."<br>";	
//$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/quadragesima_12.xml");
//$reference=ajoutexml($reference,$xml);


/// Férie du temps
$temporal=$tableau['matin']['ferie'];
if($temporal) { 
$xmlferie = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml");
if($xmlferie) print "<br> LOAD temporal :";


}
if($xmlferie) $reference=ajoutexml($reference,$xmlferie);	

/// Propre du temps ou des saints
$propre=$tableau['matin']['propre'];
if($tableau['matin']['propre']) { 
$xmlpropre = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".no_accent($tableau['matin']['propre']).".xml") ; //or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$propre.".xml");
//print_r($xmlpropre);
if($xmlpropre) $reference=ajoutexml($reference,$xmlpropre);
print "<br> LOAD propre du temps ou des saints : ";

}




//print"<br>".$tableau['matin']['ferie'];
/// Sanctoral
/*
if(($tableau['matin']['rang']<13)&&($tableau['matin']['cel'])) {
$sanctoral=$tableau['matin']['cel'];
$sanctoral = str_replace("-", "", $sanctoral);
$xmlsanctoral = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml");
print "<br> LOAD sanctoral : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml";
$reference=ajoutexml($reference,$xmlsanctoral);	
}
*/

if($tableau['matin']['special']) {
$special=$tableau['matin']['special'];

$xmlspe = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$sanctoral.".xml");
if($xmlspe) print "<br> LOAD special : wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml";
if($xmlspe) $reference=ajoutexml($reference,$xmlspe);	
}
//print_r($tableau);
print affiche_tableau($tableau,"laudes");
//print_r($reference);
print"<table>
<th>Int</th><th>Ref</th>
<tr><td>HYMNUS_tertiam</td><td>".$reference['HYMNUS_tertiam']['id']."</td></tr>
<tr><td>HYMNUS_sextam</td><td>".$reference['HYMNUS_sextam']['id']."</td></tr>
<tr><td>HYMNUS_nonam</td><td>".$reference['HYMNUS_nonam']['id']."</td></tr>
<tr><td>ant4</td><td>".$reference['ant4']['id']."</td></tr>
<tr><td>ps4</td><td>".$reference['ps4']['id']."</td></tr>
<tr><td>ant5</td><td>".$reference['ant5']['id']."</td></tr>
<tr><td>ps5</td><td>".$reference['ps5']['id']."</td></tr>
<tr><td>ant6</td><td>".$reference['ant6']['id']."</td></tr>
<tr><td>ps6</td><td>".$reference['ps6']['id']."</td></tr>
<tr><td>LB_3</td><td>".$reference['LB_3']['id']."</td></tr>
<tr><td>RB_3</td><td>".$reference['RB_3']['id']."</td></tr>
<tr><td>LB_6</td><td>".$reference['LB_6']['id']."</td></tr>
<tr><td>RB_6</td><td>".$reference['RB_6']['id']."</td></tr>
<tr><td>LB_9</td><td>".$reference['LB_9']['id']."</td></tr>
<tr><td>RB_9</td><td>".$reference['RB_9']['id']."</td></tr>
<tr><td>oratio_3</td><td>".$reference['oratio_3']['id']."</td></tr>
<tr><td>oratio_6</td><td>".$reference['oratio_6']['id']."</td></tr>
<tr><td>oratio_9</td><td>".$reference['oratio_9']['id']."</td></tr>
</table>
";
/*
print"<p>";
print_r($reference);
print"<p>";
*/



//print"<p>".$reference['HYMNUS_laudes']['id']."<p>";
/*
$special=no_accent($tableau['matin']['propre']);
$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$special.".xml");
$reference=ajoutexml($reference,$xml);	
  */
/// Eventuellement, le commun
$commun=$reference['commun']['latin'];
if($commun) {
$xmlcommun = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$commun.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$commun.".xml");
$reference=ajoutexml($reference,$xmlcommun);
$xml = simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml");
$reference=ajoutexml($reference,$xml);
}


	    $hymne=$reference['HYMNUS_tertiam']['id'];
		//print no_accent($hymne);
	    $tierce.= hymne($hymne,$lang,$reference['HYMNUS_tertiam']['mp3']);

///// Antiennes et premier psaume

	$tierce.=antienne($reference['ant4']['id'],$lang,"1");
	$psaume=$reference['ps4']['id'];
	$tierce.=psaume($psaume,$lang);
	$tierce.=antienne($reference['ant4']['id'],$lang,"");
	
///// Antiennes et deuxième psaume

	$tierce.=antienne($reference['ant5']['id'],$lang,"2");
	$psaume=$reference['ps5']['id'];
	$tierce.=psaume($psaume,$lang);
	$tierce.=antienne($reference['ant5']['id'],$lang,"");
	

	
///// Antiennes et troisième psaume

	$tierce.=antienne($reference['ant6']['id'],$lang,"3");
	$psaume=$reference['ps6']['id'];
	$tierce.=psaume($psaume,$lang);
	$tierce.=antienne($reference['ant6']['id'],$lang,"");
	
	
///// Lectio brevis	

	    $lectiobrevis =lectiobrevis($reference['LB_3']['id'],$lang);
	    $tierce.=$lectiobrevis;

///// Répons bref

	$ref=$reference['RB_3']['id']; //print"<br> REF répons bref".$ref;
	$tierce.=reponsbref($reference['RB_matin']['id'],$lang);
//// Oraison
$ref=$reference['oratio_3']['id'];
$tierce.="
<div id=\"gauche\">Orémus.</div>
	<div id=\"droite\">Prions.</div>";
$tierce.=oratio($ref,$lang);
	
	
	$tierce= rougis_verset ($tierce);

   $tierce=utf($tierce);

	return $tierce;

}


?>
