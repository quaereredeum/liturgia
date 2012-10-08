<?php
/*
$linkwp=mysql_connect("192.168.193.231", "fxp", "fxp")
    or die("Impossible de se connecter : " . mysql_error());
$db_selected = mysql_select_db('wordpress', $linkwp);
if (!$db_selected) die ('Impossible de sélectionner la base de données WP : ' . mysql_error());
/*
$q="select * from sanctoral_messe";
$r=mysql_query($q);

$xml="<sanctoral_messe>";
while($o=mysql_fetch_object($r)) {
 $xml.="<celebration id='".$o->celebration."'>";
 if($o->sanctus) $xml.="<sanctus id='".$o->sanctus."' />";
 if($o->tempus) $xml.="<tempus id='".$o->tempus."' />";
 if($o->IN_) $xml.="<IN_>$o->IN_</IN_>";
 if($o->PS1) $xml.="<PS1>$o->PS1</PS1>";
 if($o->PS2) $xml.="<PS2>$o->PS2</PS2>";
 if($o->SEQ) $xml.="<SEQ>$o->SEQ</SEQ>";
 if($o->OF) $xml.="<OF>$o->OF</OF>";
 if($o->CO) $xml.="<CO>$o->CO</CO>";
 if($o->autre1) $xml.="<autre1>$o->autre1</autre1>";
if($o->autre2) $xml.="<autre2>$o->autre2</autre2>";
if($o->autre3) $xml.="<autre3>$o->autre3</autre3>";
if($o->autre4) $xml.="<autre4>$o->autre4</autre4>";
if($o->autre5) $xml.="<autre5>$o->autre5</autre5>";
if($o->autre6) $xml.="<autre6>$o->autre6</autre6>"; 
if($o->autre7) $xml.="<autre7>$o->autre7</autre7>";
if($o->autre8) $xml.="<autre8>$o->autre8</autre8>";

 $xml.="</celebration>\r"; 
}
$xml.="</sanctoral_messe>";
print $xml;
*/
/*
$sxe = simplexml_load_file ("testxml.txt");
$sxe->asXML("sanctoral_messe.xml");

$q="SELECT * FROM temporal_a";
$r=mysql_query($q);

$xml="<temporal_a>";
while($o=mysql_fetch_object($r)) {
 $xml.="<celebration id='".$o->celebration."'>";
  if($o->IN_) $xml.="<IN_>$o->IN_</IN_>";
 if($o->PS1) $xml.="<PS1>$o->PS1</PS1>";
 if($o->PS2) $xml.="<PS2>$o->PS2</PS2>";
 if($o->SEQ) $xml.="<SEQ>$o->SEQ</SEQ>";
 if($o->OF) $xml.="<OF>$o->OF</OF>";
 if($o->CO) $xml.="<CO>$o->CO</CO>";
 if($o->autre1) $xml.="<autre1>$o->autre1</autre1>";
if($o->autre2) $xml.="<autre2>$o->autre2</autre2>";
if($o->autre3) $xml.="<autre3>$o->autre3</autre3>";
if($o->autre4) $xml.="<autre4>$o->autre4</autre4>";
if($o->autre5) $xml.="<autre5>$o->autre5</autre5>";
if($o->autre6) $xml.="<autre6>$o->autre6</autre6>"; 
if($o->autre7) $xml.="<autre7>$o->autre7</autre7>";
if($o->autre8) $xml.="<autre8>$o->autre8</autre8>";

 $xml.="</celebration>\r"; 
}
$xml.="</temporal_a>";

$sxe = new SimpleXMLElement($xml);
$sxe->asXML("temporal_a.xml");

$q="SELECT * FROM temporal_a";
$r=mysql_query($q);

$xml="<temporal_b>";
while($o=mysql_fetch_object($r)) {
 $xml.="<celebration id='".$o->celebration."'>";
  if($o->IN_) $xml.="<IN_>$o->IN_</IN_>";
 if($o->PS1) $xml.="<PS1>$o->PS1</PS1>";
 if($o->PS2) $xml.="<PS2>$o->PS2</PS2>";
 if($o->SEQ) $xml.="<SEQ>$o->SEQ</SEQ>";
 if($o->OF) $xml.="<OF>$o->OF</OF>";
 if($o->CO) $xml.="<CO>$o->CO</CO>";
 if($o->autre1) $xml.="<autre1>$o->autre1</autre1>";
if($o->autre2) $xml.="<autre2>$o->autre2</autre2>";
if($o->autre3) $xml.="<autre3>$o->autre3</autre3>";
if($o->autre4) $xml.="<autre4>$o->autre4</autre4>";
if($o->autre5) $xml.="<autre5>$o->autre5</autre5>";
if($o->autre6) $xml.="<autre6>$o->autre6</autre6>"; 
if($o->autre7) $xml.="<autre7>$o->autre7</autre7>";
if($o->autre8) $xml.="<autre8>$o->autre8</autre8>";

 $xml.="</celebration>\r"; 
}
$xml.="</temporal_b>";

$sxe = new SimpleXMLElement($xml);
$sxe->asXML("temporal_b.xml");


$q="SELECT * FROM temporal_c";
$r=mysql_query($q);

$xml="<temporal_c>";
while($o=mysql_fetch_object($r)) {
 $xml.="<celebration id='".$o->celebration."'>";
  if($o->IN_) $xml.="<IN_>$o->IN_</IN_>";
 if($o->PS1) $xml.="<PS1>$o->PS1</PS1>";
 if($o->PS2) $xml.="<PS2>$o->PS2</PS2>";
 if($o->SEQ) $xml.="<SEQ>$o->SEQ</SEQ>";
 if($o->OF) $xml.="<OF>$o->OF</OF>";
 if($o->CO) $xml.="<CO>$o->CO</CO>";
 if($o->autre1) $xml.="<autre1>$o->autre1</autre1>";
if($o->autre2) $xml.="<autre2>$o->autre2</autre2>";
if($o->autre3) $xml.="<autre3>$o->autre3</autre3>";
if($o->autre4) $xml.="<autre4>$o->autre4</autre4>";
if($o->autre5) $xml.="<autre5>$o->autre5</autre5>";
if($o->autre6) $xml.="<autre6>$o->autre6</autre6>"; 
if($o->autre7) $xml.="<autre7>$o->autre7</autre7>";
if($o->autre8) $xml.="<autre8>$o->autre8</autre8>";

 $xml.="</celebration>\r"; 
}
$xml.="</temporal_c>";

$sxe = new SimpleXMLElement($xml);
$sxe->asXML("temporal_c.xml");


$q="SELECT * FROM lectures_semaine_temporal";
$r=mysql_query($q);

$xml="<lectures_semaine_temporal>";
while($o=mysql_fetch_object($r)) {
 $xml.="<celebration id='".$o->celebration."'>";
  if($o->LEC_1_impaire) $xml.="<LEC_1_impaire>$o->LEC_1_impaire</LEC_1_impaire>";
 if($o->PR_impaire) $xml.="<PR_impaire>$o->PR_impaire</PR_impaire>";
 if($o->LEC_1_paire) $xml.="<LEC_1_paire>$o->LEC_1_paire</LEC_1_paire>";
 if($o->PR_paire) $xml.="<PR_paire>$o->PR_paire</PR_paire>";
 if($o->EV) $xml.="<EV>$o->EV</EV>";
 $xml.="</celebration>\r"; 
}
$xml.="</lectures_semaine_temporal>";
$sxe = new SimpleXMLElement($xml);
$sxe->asXML("lectures_semaine_temporal.xml");
*/
?>