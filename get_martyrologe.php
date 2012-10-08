<?php
$xml=simplexml_load_file("w:/martyrologe.xml");
$select=$xml->xpath("//sect3");
$date=0;
$output="<xml>";
foreach($select as $tt) {
$output.= "\r\n <jour>\r\n <date id=".$date.">".trim($tt[0]->title)."</date>";
	$id=0;
	//print_r($tt->para);
	foreach($tt->para as $para){
		$output.="\r\n<item id=".$id.">".$para[0]."</para>";
		$id++;
	}
	$output.= "</jour>";
	$date++;
}
$output.="</xml>";

$xmlmarty=$output;
//print $output;
?>