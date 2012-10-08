<?php

$xml = simplexml_load_file("tables.xml");
$objet = $xml->xpath("//table[@name='sanctoral_messe']//column[@name='celebration']");
print_r($objet);

?>