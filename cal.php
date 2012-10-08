<?php
///// PARAMETRES
$annee=2012;
///////////////////////


include_once "cal2XML.php";
include_once "genere_calendarium.php";
include_once "tableau.php";


print"\r\n Début du script.";
$cal[0]=genere_calendarium($annee,"RE");
$cal[1]=genere_calendarium($annee,"SWF");
$cal[2]=genere_calendarium($annee,"SMK");
cal2XML($cal,$annee);

?>