<?php
function get_traduction($atraduire,$lang,$traductions) {
//print_r($traductions);
if(!$lang) $lang="fr";
$path="//item[@ref='".$atraduire."']//".$lang;
//$path="//item[@ref='Tempus Quadragesimae']/fr";
//print"<br>".$path." ";
$traduit=@$traductions->xpath($path);
//print $traduit[0];
if(!$traduit[0]) return $atraduire;
else return $traduit[0];
}

?>