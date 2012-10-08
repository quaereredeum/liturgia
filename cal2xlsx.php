<?php

// PARAMETRES
$annee=2013;

include_once("get_traduction.php");
$traductions=simplexml_load_file("C:/phpscriptscli/liturgia/traductions.xml");
/** PHPExcel_IOFactory */
include "C:/phpscriptscli/PHPExcel/Classes/PHPExcel/IOFactory.php";
/****
/* CREATION D UN FICHIER XLS
/*******/

/** Error reporting */
//error_reporting(E_ALL);

// Create new PHPExcel object
echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Radio Espérance");
$objPHPExcel->getProperties()->setLastModifiedBy("Radio Espérance");
$objPHPExcel->getProperties()->setTitle("Calendrier Radio Espérance");
$objPHPExcel->getProperties()->setSubject("Calendrier Radio Espérance");
$objPHPExcel->getProperties()->setDescription("Calendrier Radio Espérance, generated using PHP classes.");


// Add some data
echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$date_courante=mktime(12,0,0,1,1,$annee);
$dernier_jour=mktime(12,0,0,12,31,$annee);
$jour=60*60*24;
$i=1;
	while($date_courante <= $dernier_jour) {
		
		$xmld=simplexml_load_file("c:/phpscriptscli/liturgia/calendrier/".date('Y-m-d',$date_courante).".xml");
		//print_r($xmld);
		$req="//ordo[@id='RE']";
		$result=$xmld->xpath($req);
		//print_r($result);
		//$xml_file=simplexml_load_file("c:/phpscriptscli/liturgia/calendrier/".date('Y-m-d',$date_courante).".xml");
		$x = trim($xml_file->viergemarie->intitule);
		print "\r\n ".date('Y-m-d',$date_courante).".xml ".$x;
		$intitule=get_traduction($result[0]->intitule[0]->la, "fr", $traductions);
		$tempus=get_traduction($result[0]->tempus[0]->la, "fr", $traductions);
		$hebdomada=get_traduction($result[0]->hebdomada[0]->la, "fr", $traductions);
		
		//if($i==7) {print"\r\n ".date('Y-m-d',$date_courante)." "; print_r($xmld); } //print_r($dd->viergemarie);
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, date('Y-m-d',$date_courante));
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $intitule);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $result[0]->rang[0]->fr);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $hebdomada);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $tempus);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $result[0]->selection[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $result[0]->hebdomada_psalterium[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $result[0]->couleur[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $result[0]->phase_lunaire[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $result[0]->age_lunaire[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $result[0]->lettre_annee[0]);
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $xmld->piete->intitule);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $xmld->calendriercivil->intitule);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $xmld->journeesdediees->intitule);
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $xmld->viergemarie->intitule);
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $xmld->jerusalem->texte);
		
		$date_courante+=$jour;
		$i++;
	}

// Rename sheet
echo date('H:i:s') . " Rename sheet\n";

$objPHPExcel->getActiveSheet()->setTitle('Calendrier');

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('w:/calendrier_radioesperance_'.$annee.'.xlsx');

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";

?>