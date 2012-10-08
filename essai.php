<?php
$xml=simplexml_load_file("http://www.radio-esperance.fr/wp-content/plugins/liturgia/calendrier/2012-03-05.xml"); 
print"\r\n http://www.radio-esperance.fr/wp-content/plugins/liturgia/calendrier/2012-03-05.xml";

//$expr="ordo[@id='RE']/ant1/@id";
$IN_=$xml->xpath("//ordo[@id='RE']//IN");
print_r($IN_);
//print_r($r);
print"\r\n".$r[0];
?>