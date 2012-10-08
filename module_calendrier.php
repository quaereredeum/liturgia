<?php

function mod_calendarium($mois,$an) {
//print "calendrier";

$date=$_GET['date'];
$lang=$_GET['lang'];

if(!$lang) $lang="la";

if(!$mois) $mois=$_GET['mois'];
if(!$mois) $mois=date("m",time());

if (!$an) $an=$_GET['an'];
if(!$an) $an=date("Y",time());

if(!date) {
$date=date("Ymd", @mktime(0, 0, 0, $mois, 1,$an));
}

if (!$date) {
   $date=date("Ymd",time());
}

$an=substr($date,0,4);
$mois=substr($date,4,2);
$date_ts=mktime(12,0,0,$mois,1,$an);
//print"<br>an=".$an." mois=".$mois;

$file="calendrier/".date("Y-n",$date_ts).".xml";
$xml = simplexml_load_file($file);
//print_r($xml);


if ($lang=="la") {
$men= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
$do="Do.";
$f2="F.2";
$f3="F.3";
$f4="F.4";
$f5="F.5";
$f6="F.6";
$sa="Sa.";
//$calendarium="";
}
if ($lang=="fr") {
$men= array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$do="Dim";
$f2="Lun";
$f3="Mar";
$f4="Mer";
$f5="Jeu";
$f6="Ven";
$sa="Sam";
//$calendarium="";
}

//print_r($men);

if($mois=="13") {
	$mois=1;
	$an++;
}
if($mois=="0") {
	$mois=12;
	$an--;
}

$s=0;$i=1;$sem=array();
while(date("m",$date_ts)==$mois) {
	$jour=date("w",$date_ts);

	$sem[$s][$jour]=$i;
	if ($jour==6) { $jour=0; $s++;}
 	//print"[$s|$jour]=$i";
	$i++;
	$date_ts=$date_ts+60*60*24;

}

$coul['Rouge']="#ff0000";
$coul['Vert']="#1b6f1f";
$coul['Blanc']="#ffeda6";
$coul['Violet']="#6b0d24";
$coul['Rose']="#d1a8a8";
$coul['Noir']="#000000";

$calendarium="<h4><center>$calendarium $an</center></h4>
<div align=center>
<table style=\"text-align: center;\" border=\"0\" cellpadding=\"0\" cellspacing=\"3\">
  <tbody><tr >
  <td style=\"color: #777;\"><b>$do</b></td>
  <td style=\"color: #777;\">$f2</td>
  <td style=\"color: #777;\">$f3</td>
  <td style=\"color: #777;\">$f4</td>
  <td style=\"color: #777;\">$f5</td>
  <td style=\"color: #777;\">$f6</td>
  <td style=\"color: #777;\">$sa</td>
  </tr>";

	for ($u=0;$u<6;$u++) { // boucle semaines
		
    $calendarium.="<tr>";
    $f=$sem[$u][0];
    $jour_ts=@mktime(12,0,0,$mois,$f,$an);
   
	$url="/".$GLOBALS['wp']->request;
   
    $jour=@date("Ymd",$jour_ts);
	$req="//jour[@date='".$jour."']";
	$result=$xml->xpath($req);
    $iff=(string) $result[0]->couleur;
	$titre=(string) $result[0]->intitule;
	$coloris=$coul[$iff];
	//print"<br>".$jour." ".$req." ".$iff." "; //print_r($result);
	 $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";	
//	print"<br>".$couleur_fonte;
	if($f!="")    {
		$calendarium.="
		<td style=\" background-color: $coloris;  font-weight:700; text-align: center;  text-decoration: none;\">
		<a style=\"color: #000000; text-decoration: none;\"  href=\"?date=$jour&mois=$mois&an=$an\" title=\"$titre\">
		<font color=\"$couleur_fonte\">$f</font></a></td>";
		}
	else $calendarium.="<td style=\" color: #000000; text-align: center; text-decoration: none;\"></td>";
	
	for($n=1;$n<7;$n++) { // boucle jours
	$f=$sem[$u][$n];
    $jour_ts=@mktime(12,0,0,$mois,$f,$an);
    $jour=@date("Ymd",$jour_ts);
	$req="//jour[@date='".$jour."']";
	$result=$xml->xpath($req);
    $iff=(string) $result[0]->couleur;
	$titre=(string) $result[0]->intitule;
	//print"<br>".$jour." ".$req." ".$iff." "; //print_r($result);
	///
	//print_r($result);
			///
    $coloris=$coul[$iff];
    $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";
	//print"<br>".$couleur_fonte;
    //$titre=$calend['intitule'][$jour];
	  if($f!="") {
	  $calendarium.="
	  <td style=\" background-color: $coloris; text-align: center; text-decoration: none;\">
	  <a style=\"color: #000000; text-decoration: none;\" href=\"?date=$jour&mois=$mois&an=$an\" title=\"".$titre."\">
	  <font color=\"$couleur_fonte\">$f</font></a></td>
	  ";
      }
	else {
	$calendarium.="<td style=\" text-align: center;  text-decoration: none;\"></td>";
	   }

	} // fin boucle jours
} // fin boucle semaines

    $calendarium.="
    <tr>";
    $mois_moins=$mois-1;
    $mois_plus=$mois+1;
		
    $calendarium.="
      <td style=\"color: black;\"><a href=\"".$url."?mois=$mois_moins&an=$an\">&lt;&lt;</a></td>
      <td style=\"text-align: center;\" colspan=\"5\" rowspan=\"1\"><a href=\"?mois=$mois&an=$an\">".$men[$mois-1]."</a></td>
      <td style=\"color: black;\"><a href=\"".$url."?mois=$mois_plus&&an=$an\">&gt;&gt;</a></td>
    </tr>
  </tbody>
</table>
</div>
";

return $calendarium;

}

print mod_calendarium("09","2011");


?>