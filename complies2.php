<?php

global $baseurl;

// Activer le rapport d'erreurs PHP
if ($_SERVER['SERVER_NAME'] == "localhost" )  {
	//error_reporting(E_ALL);  
	$baseurl="http://localhost/societaslaudis";
	}
	else $baseurl="http://".$_SERVER['SERVER_NAME'];

function complies($jour,$tableau,$calendarium) {

$lang=$_GET['lang'];
$option=$_GET['option'];
if($lang=="") $lang="fr";
//print_r($tableau);
// psautier
$psalterium=$tableau['soir']['psalterium'];
$xmlpsalterium = simplexml_load_file("wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml") or die ("ERREUR : wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml");
/*
print "<br> LOAD psalterium : ";
print "<a href=\"http://192.168.193.231/wordpress/wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml\">wp-content/plugins/liturgia/sources/psalterium/".$psalterium.".xml</a>";
*/
$reference=ajoutexml($reference,$xmlpsalterium);



/// Férie du temps
$temporal=$tableau['matin']['ferie'];
if($temporal) { 
$xmlferie = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml"); // or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml");
/*
if($xmlferie) print "<br> LOAD temporal :";
if($xmlferie) print "<a href=\"http://192.168.193.231/wordpress/wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml\">wp-content/plugins/liturgia/sources/propres/xml/".$temporal.".xml</a>";

*/
}

if($xmlferie) $reference=ajoutexml($reference,$xmlferie);	
/// Propre du temps ou des saints
$propre=$tableau['soir']['propre'];
if($tableau['soir']['propre']) { 
$xmlpropre = @simplexml_load_file("wp-content/plugins/liturgia/sources/propres/xml/".no_accent($tableau['soir']['propre']).".xml") ; //or die ("ERREUR : wp-content/plugins/liturgia/sources/propres/xml/".$propre.".xml");
//print_r($xmlpropre);
if($xmlpropre) $reference=ajoutexml($reference,$xmlpropre);
/*
print "<br> LOAD propre du temps ou des saints : ";
print "<a href=\"http://192.168.193.231/wordpress/wp-content/plugins/liturgia/sources/propres/xml/".no_accent($tableau['soir']['propre']).".xml\">wp-content/plugins/liturgia/sources/propres/xml/".no_accent($tableau['']['propre']).".xml</a>";
*/
}



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
<tr><td>HYMNUS_completorium</td><td>".$reference['HYMNUS_completorium']['id']."</td></tr>
<tr><td>ant10</td><td>".$reference['ant10']['id']."</td></tr>
<tr><td>ps10</td><td>".$reference['ps10']['id']."</td></tr>
<tr><td>ant11</td><td>".$reference['ant11']['id']."</td></tr>
<tr><td>ps11</td><td>".$reference['ps11']['id']."</td></tr>
<tr><td>LB_completorium</td><td>".$reference['LB_completorium']['id']."</td></tr>
<tr><td>RB_completorium</td><td>".$reference['RB_completorium']['id']."</td></tr>
<tr><td>oratio_completorium </td><td>".$reference['oratio_completorium']['id']."</td></tr>
</table>
";
/*
print"<p>";
print_r($reference);
print"<p>";
*/



	    $hymne=$reference['HYMNUS_completorium']['id'];
		//print no_accent($hymne);
	    $complies.= hymne($hymne,$lang,$reference['HYMNUS_completorium']['mp3']);

///// Antiennes et premier psaume

	$complies.=antienne($reference['ant10']['id'],$lang,"1");
	$psaume=$reference['ps10']['id'];
	$complies.=psaume($psaume,$lang);
	$complies.=antienne($reference['ant10']['id'],$lang,"");
	
///// Antiennes et deuxième psaume
if($reference['ps11']['id']) {
	$complies.=antienne($reference['ant11']['id'],$lang,"2");
	$psaume=$reference['ps11']['id'];
	$complies.=psaume($psaume,$lang);
	$complies.=antienne($reference['ant11']['id'],$lang,"");
}		
///// Lectio brevis	

	    $lectiobrevis =lectiobrevis($reference['LB_completorium']['id'],$lang);
	    $complies.=$lectiobrevis;

///// Répons bref

	$ref=$reference['RB_completorium']['id']; //print"<br> REF répons bref".$ref;
	$complies.=reponsbref($reference['RB_completorium']['id'],$lang);
//// Oraison

$ref=$reference['oratio_completorium']['id'];
$complies.="
<div id=\"gauche\">Orémus.</div>
	<div id=\"droite\">Prions.</div>";
$complies.=oratio($ref,$lang);
	
	
	$complies= rougis_verset ($complies);

   $complies=utf($complies);
   

return $complies;
}

?>
