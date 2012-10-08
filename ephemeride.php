<?php

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'C:/phpscriptscli/PHPExcel/Classes/PHPExcel/IOFactory.php';

function viergemarie() {

//$inputFileType = 'Excel5';
//	$inputFileType = 'Excel2007';
//	$inputFileType = 'Excel2003XML';
	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
$inputFileName = "W:/Calendrier_Re.ods";
$sheetname="Vierge Marie";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
print "Loading Sheet ".$sheetname." only\r\n";
$objReader->setLoadSheetsOnly($sheetname);
$objPHPExcel = $objReader->load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

print"\r\n";
$output="<viergemarie>";
foreach ($sheetData as $line) {
	if($line['E']!="") $output.="\r\n<date id=\"".$line['A']."-".$line['D']."\">\r\n <texte>".$line['E']."</texte>\r\n</date>";
}
$output.="</viergemarie>";
 /*
print $objPHPExcel->getSheetCount()." worksheet".(($objPHPExcel->getSheetCount() == 1) ? '' : 's')." loaded\r\n \r\n";
$loadedSheetNames = $objPHPExcel->getSheetNames();
foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
	print $sheetIndex." -> ".$loadedSheetName."<br />";
}
*/

return $output;
}
//$objPHPExcel = PHPExcel_IOFactory::load("w:/Calendrier_Re.ods");

?>