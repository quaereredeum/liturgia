<?php
/* 
include "fonctions.php";
    $dbaddress="192.168.193.1";
    $dbuser="writer";
    $dbpassword="writer";
    $dbname="zenon32";
    $link = mysql_connect($dbaddress, $dbuser,$dbpassword)
    or die("Impossible de se connecter : " . mysql_error());
    $db=mysql_select_db($dbname);
    
    $q="SELECT NUM_ROTATION,COMMENT FROM t_rotation t where NUM_TYPE=3";
    $r=mysql_query($q);
    while($row=mysql_fetch_object($r)) {
    $noacc=no_accent($row->COMMENT);
        $q2="update t_rotation set COMMENT='$noacc' where NUM_ROTATION=$row->NUM_ROTATION;";
        $r2=mysql_query($q2);
        print "<br> $q2";
    }
*/
?>
