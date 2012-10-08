<?php
$xml=simplexml_load_file("C:/phpscriptscli/liturgia/sources/psalterium/psalterium_osb_3.xml");
$result= $xml->xpath('/liturgia/osb_vig_ant_attente/@id');
print"result=".$result[0];

?>