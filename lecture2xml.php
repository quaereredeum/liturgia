<?php
include ("fonctions.php");

function lec2xml($ref) {
$output="<liturgia> ";
$fp = fopen ("sources/propres/messe/lectures/".$ref,"r","1");
$l=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	$output.="<ligne id=\"$l\">\r";
	if($data[0]) $output.="<la>".$data[0]."</la>";
	if($data[1]) $output.="<fr>".$data[1]."</fr>";
	if($data[2]) $output.="<en>".$data[2]."</en>";
	if($data[3]) $output.="<ar>".$data[3]."</ar>";
	$output.="</ligne>\r";
	$ligne[$l]=$data[0];
	$l++;
	}
	@fclose($fp);
$output.="</liturgia>";

$sxe = new SimpleXMLElement($output);
$ref = str_replace(".csv", ".xml", $ref);
$ref = str_replace("hy_", "HY_", $ref);
$ref=no_accent($ref);
$sxe->asXML("sources/propres/messe/lectures/".$ref);
}


$dir_nom = 'sources/propres/messe/lectures/';// dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')


foreach(glob($dir_nom."*.csv") as $lien) {
echo "<li><a href=$lien >$lien</a></li>n";
///////////// ICI le code pour le traitement des fichiers d'office
$ll=explode("/",$lien);
$lll=$ll[4];
print "<br>lll=".$lll;
//print_r($ll);
if ((substr($lll,0,3)=="EV_")||(substr($lll,0,3)=="LEC")) lec2xml($lll);
print"<br>".$lien -> XML;
echo "</ul>";
}







?>