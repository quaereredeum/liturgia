<?php
include_once("lune.php");

include_once("get_traduction.php");
$p=pathinfo("__FILE__");
$pathinfo=$p['dirname'];
print "\r\n PATHINFO = ".$pathinfo."\r\n";
function no_accent($str_accent) {
   $pattern = Array("/ /","/Æ/","/é/", "/è/", "/ê/", "/ç/", "/æ/","/à/", "/á/", "/í/", "/ï/", "/ù/", "/ó/","/ú/","/,/","/__/","/:/");
   // notez bien les / avant et après les caractères
   $rep_pat = Array("_","A","e", "e", "e", "c", "ae","a", "a", "i", "i", "u", "o", "u","_","_",null,null);
   $str_noacc = preg_replace($pattern, $rep_pat, $str_accent);
   $str_noacc=trim($str_noacc,"_");
   $str_noacc = preg_replace($pattern, $rep_pat, $str_noacc);
   $str_noacc = str_replace("*", null, $str_noacc);
   $str_noacc = str_replace("?", null, $str_noacc);
   $str_noacc=trim($str_noacc);
   $str_noacc=str_replace("__", "_", $str_noacc);
   return $str_noacc;
}




$xml=simplexml_load_file("Martyrologe_source.xml");
$select=$xml->xpath("//sect3");
$date=0;

$output="<xml>";
foreach($select as $tt) {
$output.= "\r\n <jour id='".$date."'>\r\n <date >".trim($tt[0]->title)."</date>";
	$id=0;
	//print_r($tt->para);
	foreach($tt->para as $para){
		$output.="\r\n<item id='".$id."'>".$para[0]."</item>";
		$id++;
	}
	$output.= "</jour>";
	$date++;
}
$output.="</xml>";
$xmlmarty=$output;
fwrite($fp, $xmlmarty);
fclose($fp);

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "Calendrier_Re.xlsx";
$inputFileType = "Excel2007";
$sheetname="Vierge Marie";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
//print "Loading Sheet ".$sheetname." only\r\n";
$objReader->setLoadSheetsOnly("Vierge Marie");
$objPHPExcel = $objReader->load($inputFileName);

$sheetDataBVM = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Saint de Jerusalem");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataJerusalem = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Biographie et ...") or die ("Erreur biographie");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataBio = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Vierge Marie") or die ("Erreur Vierge Marie");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataBVM = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Piété populaire") or die ("Erreur Piété populaire");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataPP = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);



function pietePopulaire($id,$date_ts) {
	
	GLOBAL $sheetDataPP;
	$output="<piete>";
	foreach ($sheetDataPP as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	foreach ($sheetDataPP as $line) {
		if(($line['G']==$id)||(no_accent($line['G'])==$id)||(no_accent($line['G'])==no_accent($id))||($line['G']==no_accent($id))) {
				$output.="\r\n <intitule>".$line['F']."</intitule>";
			}	
	}
	$output.="</piete>";
	return $output;
}


$objReader->setLoadSheetsOnly("Journées dédiées") or die ("Journées dédiées");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataJD = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

function journeesdediees($id,$date_ts) {
	
	GLOBAL $sheetDataJD;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="<journeesdediees>";
	foreach ($sheetDataJD as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	$output.="</journeesdediees>";
	return $output;
}

$objReader->setLoadSheetsOnly("Cal Civil") or die ("Cal Civil");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataCivil = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

function calendriercivil($id,$date_ts) {
	GLOBAL $sheetDataCivil;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="<calendriercivil>";
	foreach ($sheetDataCivil as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	$output.="</calendriercivil>";
	return $output;
}



//$xmlmarty=simplexml_load_file("martyrologe.xml");

function martyrologe($date_ts) {
	global $xmlmarty;
	//print_r($xmlmarty);
	$mm=simplexml_load_string($xmlmarty);
	$expr="//jour[@id='".date('z',$date_ts)."']";
	print"  ".$expr;
	$result=$mm->xpath($expr);
	//print_r($result);
	return $result;
}

function biographie($date_ts) {
	GLOBAL $sheetDataBio;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="<biographie>";
	foreach ($sheetDataBio as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
				$output.="\r\n <biographiecourte>".$line['G']."</biographiecourte>";
				$output.="\r\n <canonisebeatifie>".$line['H']."</canonisebeatifie>";
				$output.="\r\n <patronage>".$line['J']."</patronage>";
			}	
	}
	$output.="</biographie>";
	return $output;
}

function viergeMarie($date_ts) {
	GLOBAL $sheetDataBVM;
	//print"\r\n dbug BVM ".date('n-j',$date_ts);
	$output="<viergemarie>";
	foreach ($sheetDataBVM as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
		//print"\r\n \"".$Md."\" =>".date('n-j',$date_ts);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']." ".$line['F']."</intitule>";
			}	
	}
	$output.="</viergemarie>";
	return $output;
}

$compendiumxml=simplexml_load_file("compendium.xml");
function compendium($date_ts) {
	GLOBAL $compendiumxml;
	$debutanneedelafoi=mktime(12, 0, 0, 10, 11, 2012 );
	$r=$date_ts-$debutanneedelafoi;
	if($r>=0) {
		$j=round($r/(60*60*24));
		$expr="//article[@id=\"".$j."\"]";
		$output=$compendiumxml->xpath($expr);
		//print"\r\n ".$expr;
		//print "\r\n ".$output[0];
		return $output[0];
	}
}

function Jerusalem($date_ts) {
	GLOBAL $sheetDataJerusalem;
	//$inputFileType = 'Excel5';
	//	$inputFileType = 'Excel2007';
	//	$inputFileType = 'Excel2003XML';
	$inputFileType = 'OOCalc';
	//	$inputFileType = 'Gnumeric';


	//print"\r\n dbug Jerusalem ".date('n-j',$date_ts);
	$output="<jerusalem>";
	foreach ($sheetDataJerusalem as $line) {
		if($line['E']!="") {
			$Md=(string)$line['A']."-".$line['D'];
			if($Md==(string)date('n-j',$date_ts)) {
				$output.="\r\n <texte>".$line['E']."</texte>";
				//print "\r\n <texte>".$line['E']."</texte>";
			}

		}
	}
	$output.="</jerusalem>";
	/*
	 print $objPHPExcel->getSheetCount()." worksheet".(($objPHPExcel->getSheetCount() == 1) ? '' : 's')." loaded\r\n \r\n";
	 $loadedSheetNames = $objPHPExcel->getSheetNames();
	 foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
	 print $sheetIndex." -> ".$loadedSheetName."<br />";
	 }
	 */
	//print"\r\n".$output;
	return $output;
}






function ajoutexml($liturgia,$xml) {
	//print_r($xml);

	if($xml) {
		if($result=@$xml->xpath('/liturgia/ant_invit/@id')) $liturgia['ant_invit']=$result[0];
		if($result=@$xml->xpath('/liturgia/commun/@id')) $liturgia['commun']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_lectures/@id')) $liturgia['HYMNUS_lectures']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_lec_jour/@id')) $liturgia['HYMNUS_lec_jour']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant01/@id')) $liturgia['ant01']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps01/@id')) $liturgia['ps01']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant02/@id')) $liturgia['ant02']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps02/@id')) $liturgia['ps02']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant03/@id')) $liturgia['ant03']=$result[0];
		if($result=@$xml->xpath('/liturgia/VERS/@id')) $liturgia['VERS']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_laudes/@id')) $liturgia['HYMNUS_laudes']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant1/@id')) $liturgia['ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps1/@id')) $liturgia['ps1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant2/@id')) $liturgia['ant2']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant1/@id')) $liturgia['ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps2/@id')) $liturgia['ps2']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant3/@id')) $liturgia['ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps3/@id')) $liturgia['ps3']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant3/@id')) $liturgia['ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_matin/@id')) $liturgia['LB_matin']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_matin/@id')) $liturgia['RB_matin']=$result[0];
		if($result=@$xml->xpath('/liturgia/benedictus/@id')) $liturgia['benedictus']=$result[0];
		if($result=@$xml->xpath('/liturgia/benedictus_A/@id')) $liturgia['benedictus_A']=$result[0];
		else unset($liturgia['benedictus_A']);
		if($result=@$xml->xpath('/liturgia/benedictus_B/@id')) $liturgia['benedictus_B']=$result[0];
		else unset($liturgia['benedictus_B']);
		if($result=@$xml->xpath('/liturgia/benedictus_C/@id')) $liturgia['benedictus_C']=$result[0];
		else unset($liturgia['benedictus_C']);
		if($result=@$xml->xpath('/liturgia/preces/@id')) $liturgia['laudes_preces']=$result[0];
		//else unset($liturgia['laudes_preces']);
		if($result=@$xml->xpath('/liturgia/oratio_laudes/@id')) $liturgia['oratio_laudes']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio/@id')) $liturgia['oratio']=$result[0];
		else unset ($liturgia['oratio']);
		if($result=@$xml->xpath('/liturgia/HYMNUS_tertiam/@id')) $liturgia['HYMNUS_tertiam']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_sextam/@id')) $liturgia['HYMNUS_sextam']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_nonam/@id')) $liturgia['HYMNUS_nonam']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant4/@id')) $liturgia['ant4']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps4/@id')) $liturgia['ps4']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant5/@id')) $liturgia['ant5']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps5/@id')) $liturgia['ps5']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant6/@id')) $liturgia['ant6']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps6/@id')) $liturgia['ps6']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_3/@id')) $liturgia['LB_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_3/@id')) $liturgia['RB_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_3/@id')) $liturgia['oratio_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_6/@id')) $liturgia['LB_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_6/@id')) $liturgia['RB_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_6/@id')) $liturgia['oratio_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_9/@id')) $liturgia['LB_9']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_9/@id')) $liturgia['RB_9']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_9/@id')) $liturgia['oratio_9']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_vesperas/@id')) $liturgia['HYMNUS_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant7/@id')) $liturgia['ant7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps7/@id')) $liturgia['ps7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant8/@id')) $liturgia['ant8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps8/@id')) $liturgia['ps8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant9/@id')) $liturgia['ant9']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps9/@id')) $liturgia['ps9']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_soir/@id')) $liturgia['LB_soir']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_soir/@id')) $liturgia['RB_soir']=$result[0];
		if($result=@$xml->xpath('/liturgia/magnificat/@id')) $liturgia['magnificat']=$result[0];
		if($result=@$xml->xpath('/liturgia/magnificat_A/@id')) $liturgia['magnificat']=$result[0];
		if($result=@$xml->xpath('/liturgia/magnificat_B/@id')) $liturgia['magnificat']=$result[0];
		if($result=@$xml->xpath('/liturgia/magnificat_C/@id')) $liturgia['magnificat']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_vesperas/@id')) $liturgia['oratio_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio/@id')) $liturgia['oratio_vesperas']=$result[0]; 
		if($result=@$xml->xpath('/liturgia/preces/@id')) $liturgia['vepres_preces']=$result[0];
		//else unset($liturgia['vepres_preces']);
		if($result=@$xml->xpath('/liturgia/HYMNUS_completorium/@id')) $liturgia['HYMNUS_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant10/@id')) $liturgia['ant10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps10/@id')) $liturgia['ps10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant11/@id')) $liturgia['ant11']=$result[0];
		else $liturgia['ant11']="";
		if($result=@$xml->xpath('/liturgia/ps11/@id')) $liturgia['ps11']=$result[0];
		else $liturgia['ps11']="";
		if($result=@$xml->xpath('/liturgia/LB_completorium/@id')) $liturgia['LB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_completorium/@id')) $liturgia['RB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_completorium/@id')) $liturgia['oratio_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_osb_vigiles/@id')) $liturgia['RB_osb_vigiles']=$result[0];
		if($result=@$xml->xpath('/liturgia/commun/@id')) $liturgia['commun']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant_attente/@id')) $liturgia['osb_vig_ant_attente']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps_attente/@id')) $liturgia['osb_vig_ps_attente']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps1')) $liturgia['osb_vig_ps1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant1/@id')) $liturgia['osb_vig_ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps2')) $liturgia['osb_vig_ps2']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant2/@id')) $liturgia['osb_vig_ant2']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps3')) $liturgia['osb_vig_ps3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant3/@id')) $liturgia['osb_vig_ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps4')) $liturgia['osb_vig_ps4']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant4/@id')) $liturgia['osb_vig_ant4']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps5')) $liturgia['osb_vig_ps5']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant5/@id')) $liturgia['osb_vig_ant5']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps6')) $liturgia['osb_vig_ps6']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant6/@id')) $liturgia['osb_vig_ant6']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps7')) $liturgia['osb_vig_ps7']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant7/@id')) $liturgia['osb_vig_ant7']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps8')) $liturgia['osb_vig_ps8']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant8/@id')) $liturgia['osb_vig_ant8']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps9')) $liturgia['osb_vig_ps9']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant9/@id')) $liturgia['osb_vig_ant9']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps10')) $liturgia['osb_vig_ps10']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant10/@id')) $liturgia['osb_vig_ant10']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps11')) $liturgia['osb_vig_ps11']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps12')) $liturgia['osb_vig_ps12']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_LB/@id')) $liturgia['osb_vig_LB']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers1/@id')) $liturgia['osb_vig_vers1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben1/@id')) $liturgia['osb_vig_ben1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_RB/@id')) $liturgia['osb_vig_RB']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers2/@id')) $liturgia['osb_vig_vers1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben2/@id')) $liturgia['osb_vig_ben1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers3/@id')) $liturgia['osb_vig_vers3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben3/@id')) $liturgia['osb_vig_ben3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben3/@id')) $liturgia['osb_vig_ben3']=$result[0];
		if ($result=@$xml->xpath('/liturgia/intitule/la')) $liturgia['intitule_matin_la']=$result[0];
		if ($result=@$xml->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
	}
	//print"</table>";
	//print"\r\n ICI";
	return $liturgia;
}


function cal2XML($cal,$m) {
	
	
	$handle = fopen("selection-RE.csv", "r","1");
	$t=file_get_contents("traductions.xml");
	$traductions=simplexml_load_string($t);
	$t2=$t=file_get_contents("lectures_semaine_temporal.xml");
	$lst=simplexml_load_string($t2);
	
	while (($data = @fgetcsv($handle, 1000, ";")) !== FALSE) {
		//print"<tr>";
		$num = count($data);
		//echo "<p> $num fields in line $row: <br /></p>\n";
		$row++;
		if($data[4]!="") {
			$date_sanctoral=@mktime(12,0,0,$data[0],$data[3],$m);
			$dds=date("Ymd", $date_sanctoral);
			//$sanctoral['vita'][$dds]=$data[8];
			$selection['intitule'][$dds]=$data[4];
		}
	}
	///////////////////////////////////////////////////////////////////////////

	$date_courante=mktime(12,0,0,1,1,$m);
	$dernier_jour=mktime(12,0,0,12,31,$m);

	$jour=60*60*24;
	while($date_courante <= $dernier_jour) {

		$liturgia['office_soir_la']="";
		$liturgia['intitule_soir_la']="";
		$liturgia['rang_soir_la']="";
		$output="<calendarium>";

		for($p=0;$p<count($cal);$p++) {
			$calendarium=$cal[$p];
			if (date('Y',$date_courante)%2 == 0) $parite="paire";
			else $parite="impaire";
			if(($calendarium['tempus'][$d]=="Tempus Adventus")&&(date('mY',$date_courante)==12)){
				if ($parite=="impaire") $parite="paire";
				else $parite="impaire";
			}

			///print"\r\n ".date("Y-m-d",$date_courante)." / ".date("Y-m-d",$dernier_jour);
			$d=date("Ymd",$date_courante);
			//print"\r\n".$d;
			//$calendarium['propre'][$d]=$propre;
			$filename="calendrier/".@date("Y-m-d",$date_courante).".xml";
			$tableau=tableau($calendarium,date("Ymd",$date_courante));
			//print_r($tableau);
			
			if($tableau['matin']['cel']&&($calendarium['priorite'][$d]<12)) $messe=$tableau['matin']['cel'];
			else $messe=$calendarium['messe'][$d];
			$messe=str_replace(" ","_",$messe);
			if ($messe=="HS_5_AD_MISSAM_CHRISMATIS") $messe="HS_5_MISSA_VESPERTINA_IN_CENA_DOMINI";
			if ($messe=="DOMINICA_RESURRECTIONIS") $messe="DOMINICA_RESURRECTIONIS_IN_DIE";
			if ($messe=="Feria_II_infra_octavam_Paschae") $messe="pascha_12";
			if ($messe=="Feria_III_infra_octavam_Paschae") $messe="pascha_13";
			if ($messe=="Feria_IV_infra_octavam_Paschae") $messe="pascha_14";
			if ($messe=="Feria_V_infra_octavam_Paschae") $messe="pascha_15";
			if ($messe=="Feria_VI_infra_octavam_Paschae") $messe="pascha_16";
			if ($messe=="Sabatto_infra_octavam_Paschae") $messe="pascha_17";
			if ($messe=="06-29") $messe="06-29-in-die";

			//print"\r\n".$filename." ";
			$output.="<ordo id=\"".$calendarium['ordo']."\">";
			$output.="<messe>".$messe."</messe>";
			$output.="<priorite>".$calendarium['priorite'][$d]."</priorite>";
			$output.="<pV>".$calendarium['1V'][$d]."</pV>";
			$output.="<couleur>".$calendarium['couleur_template'][$d]."</couleur>";
			$output.="<reference>".$calendarium['reference'][$d]."</reference>";
			$output.="<sanctoral><la>".$calendarium['sanctoral'][$d]."</la><fr>".get_traduction($calendarium['sanctoral'][$d],"fr",$traductions)."</fr></sanctoral>";
			$output.="<tempus><la>".$calendarium['tempus'][$d]."</la><fr>".get_traduction($calendarium['tempus'][$d],"fr",$traductions)."</fr></tempus>";
			$output.="<hebdomada><la>".$calendarium['hebdomada'][$d]."</la><fr>".get_traduction($calendarium['hebdomada'][$d],"fr",$traductions)."</fr></hebdomada>";
			$output.="<intitule><la>".$calendarium['intitule'][$d]."</la><fr>".get_traduction($calendarium['intitule'][$d],"fr",$traductions)."</fr></intitule>";
			$output.="<rang><la>".$calendarium['rang'][$d]."</la><fr>".get_traduction($calendarium['rang'][$d],"fr",$traductions)."</fr></rang>";
			$output.="<hebdomada_psalterium>".$calendarium['hebdomada_psalterium'][$d]."</hebdomada_psalterium>";
			/////////////////////////////////////////////////////////////////////////////////////////////
			//print"\r\n calendarium['hebdomada_psalterium']".$calendarium['hebdomada_psalterium'][$d];
			/////////////////////////////////////////////////////////////////////////////////////////////
			list($MoonPhase, $MoonAge, $MoonDist, $MoonAng, $SunDist, $SunAng, $mpfrac) = Moon::phase(date("Y",$date_courante), date("m",$date_courante), date("d",$date_courante), 00, 00, 01);
			$output.="<phase_lunaire>".number_format($MoonPhase*100, 2, ',', '')."</phase_lunaire>";
			$output.="<age_lunaire>".floor($MoonAge)."</age_lunaire>";
			$output.="<selection>".$selection['intitule'][$d]."</selection>";
			$output.="<matin>
		<temps>".$tableau['matin']['temps']."</temps>
		<psautier>".$tableau['matin']['psautier']."</psautier>
		<psalterium>".$tableau['matin']['psalterium']."</psalterium>
		<ferie>".$tableau['matin']['ferie']."</ferie>
		<special>".$tableau['matin']['special']."</special>
		<propre>".$tableau['matin']['propre']."</propre>
		<lettre_annee>".$tableau['matin']['lettre_annee']."</lettre_annee>
		<cel>".$tableau['matin']['cel']."</cel>
	</matin>";
			$output.="<soir>
		<temps>".$tableau['soir']['temps']."</temps>
		<psautier>".$tableau['soir']['psautier']."</psautier>
		<psalterium>".$tableau['soir']['psalterium']."</psalterium>
		<ferie>".$tableau['soir']['ferie']."</ferie>
		<special>".$tableau['soir']['special']."</special>
		<propre>".$tableau['soir']['propre']."</propre>
		<lettre_annee>".$tableau['soir']['lettre_annee']."</lettre_annee>	
		<premieresvepres>".$tableau['soir']['1V']."</premieresvepres>
		<cel>".$tableau['soir']['cel']."</cel>	
	</soir>	";
			
/****************************************************************************
 * 
 * ICI l'ALGO qui compile ensemble les formulaires 
 * 
 * 
 * 
 ******************************************************************************/
			$psautier=simplexml_load_file("sources/psalterium/".$tableau['matin']['psalterium'].".xml");
			$liturgia=ajoutexml($liturgia,$psautier);
			//$liturgia['preces_matin']=$tableau['matin']['ferie'];
			//$liturgia['preces_soir']=$tableau['soir']['ferie'];
			$ord=date('w',$date_courante)+1;
			$osb_psalterium="";
			$osb_psalterium=simplexml_load_file("sources/psalterium/psalterium_osb_".$ord.".xml");
			if($osb_psalterium) $liturgia=ajoutexml($liturgia,$osb_psalterium);
			$ferie="";
			if($tableau['matin']['ferie']) $ferie=simplexml_load_file("sources/propres/".$tableau['matin']['ferie'].".xml");
			if($ferie) $liturgia=ajoutexml($liturgia,$ferie);
			$special="";
			if($tableau['matin']['special']) $special=simplexml_load_file("sources/propres/".str_replace(" ","_",$tableau['matin']['special']).".xml");
			if($special) $liturgia=ajoutexml($liturgia,$special);
			$propre="";
			$special="";
			//$propre=str_replace(" ","_",$messe);
			if($tableau['matin']['propre']) $propre=simplexml_load_file("sources/propres/".str_replace(" ","_",$tableau['matin']['propre']).".xml");
			if($propre) $liturgia=ajoutexml($liturgia,$propre);
			if($liturgia['commun']!="") {
				//print"\r\n commun=".$liturgia['commun'];
				$commun=simplexml_load_file("sources/propres/".$liturgia['commun'].".xml") or die("\r\n ERREUR !");
				$liturgia=ajoutexml($liturgia,$commun);
				if($special) $liturgia=ajoutexml($liturgia,$special);
				if($propre) $liturgia=ajoutexml($liturgia,$propre);
				$liturgia['commun']="";
			}
				
				
			if($tableau['soir']['1V']==1) { // AJOUT des éléments de premières vepres au propre
				//print "\r\n debug propre=".$tableau['soir']['propre'];
				$premV=simplexml_load_file("sources/propres/".str_replace(" ","_",$tableau['soir']['propre']).".xml");

				if($premV){
					if($result=@$premV->xpath('/liturgia/HYMNUS_1V/@id')) $liturgia['HYMNUS_vesperas']=$result[0];
					//print "\r\n debug propre=".$tableau['soir']['propre'];
					if($result=@$premV->xpath('/liturgia/ant01/@id')) $liturgia['ant7']=$result[0];
					if($result=@$premV->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps01/@id')) $liturgia['ps7']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant02/@id')) $liturgia['ant8']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps02/@id')) $liturgia['ps8']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant03/@id')) $liturgia['ant9']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps03/@id')) $liturgia['ps9']=$result[0];
					if($result=@$premV->xpath('/liturgia/LB_1V/@id')) $liturgia['LB_soir']=$result[0];
					if($result=@$premV->xpath('/liturgia/RB_1V/@id')) $liturgia['RB_soir']=$result[0];
					if($result=@$premV->xpath('/liturgia/pmagnificat/@id')) $liturgia['magnificat']=$result[0];
					if($result=@$premV->xpath('/liturgia/oratio/@id')) $liturgia['oratio_vesperas']=$result[0];
					if($result=@$premV->xpath('/liturgia/preces/@id')) $liturgia['vepres_preces']=$result[0];
					if($result=@$premV->xpath('/liturgia/HYMNUS_completorium/@id')) $liturgia['HYMNUS_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant10/@id')) $liturgia['ant10']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps10/@id')) $liturgia['ps10']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant11/@id')) $liturgia['ant11']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps11/@id')) $liturgia['ps11']=$result[0];
					if($result=@$premV->xpath('/liturgia/LB_completorium/@id')) $liturgia['LB_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/RB_completorium/@id')) $liturgia['RB_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/oratio_completorium/@id')) $liturgia['oratio_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
					if($result=@$premV->xpath('/liturgia/rang/la')) $liturgia['rang_soir_la']=$result[0];
					$liturgia['office_soir_la']="Ad I Vesperas";
					// prévoir l'antienne mariale qui change : Sub tuum praesidium

					//ajoutexml($liturgia, $premV);
				}
				//print "\r\n debug propre=".$tableau['soir']['propre'];
			}
				
			if($calendarium['1V'][$d]=="1") { // il y a des II vêpres

				$liturgia['office_soir_la']="Ad II Vesperas";

				$liturgia['intitule_soir_la']=$calendarium['intitule'][$d];
				//print "\r\n".date('Ymd',$date_courante);
				//$liturgia['rang_soir_la']="Sollemnitas";
			}
			
	
			$output.="
<intitule_matin id=	\"".$liturgia['intitule_matin_la']."\" />
<invitatoire id=\"\" />
<HYMNUS_lectures>".$liturgia['HYMNUS_lectures']."</HYMNUS_lectures>
<HYMNUS_lec_jour>".$liturgia['HYMNUS_lec_jour']."</HYMNUS_lec_jour>
<antL1 id=\"".$liturgia['HYMNUS_lec_jour']."\" />
<psL1 id=\"".$liturgia['psL1']."\" />
<antL2 id=\"".$liturgia['antL2']."\" />
<psL2 id=\"".$liturgia['psL2']."\" />
<antL3 id=\"".$liturgia['antL3']."\" />
<psL3 id=\"".$liturgia['psL3']."\" />
<osb_vig_ant_attente id=\"".$liturgia['osb_vig_ant_attente']."\" />
<osb_vig_ps_attente id=\"".$liturgia['osb_vig_ps_attente']."\" />
<Llec1 id=\"\" />
<Lrep1 id=\"\" />
<Llec2 id=\"\" />
<Lrep2 id=\"\" />
<Loratio id=\"\" />
<Levangile id=\"\" />
<Vant1>".$liturgia['osb_vig_ant1']."</Vant1>
<Vps1>".$liturgia['osb_vig_ps1']."</Vps1>
<Vant2>".$liturgia['osb_vig_ant2']."</Vant2>
<Vps2>".$liturgia['osb_vig_ps2']."</Vps2>
<Vant3>".$liturgia['osb_vig_ant3']."</Vant3>
<Vps3>".$liturgia['osb_vig_ps3']."</Vps3>
<Vant4>".$liturgia['osb_vig_ant4']."</Vant4>
<Vps4>".$liturgia['osb_vig_ps4']."</Vps4>
<Vant5>".$liturgia['osb_vig_ant5']."</Vant5>
<Vps5>".$liturgia['osb_vig_ps5']."</Vps5>
<Vant6>".$liturgia['osb_vig_ant6']."</Vant6>
<Vps6>".$liturgia['osb_vig_ps6']."</Vps6>
<Vlec1 id=\"\" />
<Vrep1 id=\"\" />
<Vlec2 id=\"\" />
<Vrep2 id=\"\" />
<Vlec3 id=\"\" />
<Vlrep3 id=\"\" />
<Vlec4 id=\"\" />
<Vrep4 id=\"\" />
<Vver1 id=\"\" />
<Vant7>".$liturgia['osb_vig_ant7']."</Vant7>
<Vps7>".$liturgia['osb_vig_ps7']."</Vps7>
<Vant8>".$liturgia['osb_vig_ant8']."</Vant8>
<Vps8>".$liturgia['osb_vig_ps8']."</Vps8>
<Vant9>".$liturgia['osb_vig_ant9']."</Vant9>
<Vps9>".$liturgia['osb_vig_ps9']."</Vps9>
<Vant10>".$liturgia['osb_vig_ant10']."</Vant10>
<Vps10>".$liturgia['osb_vig_ps10']."</Vps10>
<Vant11>".$liturgia['osb_vig_ant11']."</Vant11>
<Vps11>".$liturgia['osb_vig_ps11']."</Vps11>
<Vant12>".$liturgia['osb_vig_ant12']."</Vant12>
<Vps12>".$liturgia['osb_vig_ps12']."</Vps12>
<Vver2 id=\"\" />
<Vlec5 id=\"\" />
<Vrep5 id=\"\" />
<Vlec6 id=\"\" />
<Vrep6 id=\"\" />
<Vlec7 id=\"\" />
<Vrep7 id=\"\" />
<Vlec8 id=\"\" />
<Vrep8 id=\"\" />
<Vant13>".$liturgia['osb_vig_ant13']."</Vant13>
<Vcant1 id=\"\" />
<Vcant2 id=\"\" />
<Vcant3 id=\"\" />
<Vver3 id=\"\" />
<Vev_debut id=\"\" />
<Vlec9 id=\"\" />
<Vrep9 id=\"\" />
<Vlec10 id=\"\" />
<Vrep10 id=\"\" />
<Vlec11 id=\"\" />
<Vrep11 id=\"\" />
<Vlec12 id=\"\" />
<Vevangile id=\"\" />
<Voraison id=\"\" />
<HYMNUS_laudes>".$liturgia['HYMNUS_laudes']."</HYMNUS_laudes>
<ant1>".$liturgia['ant1']."</ant1>
<ps1>".$liturgia['ps1']."</ps1>
<ant2>".$liturgia['ant2']."</ant2>
<ps2>".$liturgia['ps2']."</ps2>
<ant3>".$liturgia['ant3']."</ant3>
<ps3>".$liturgia['ps3']."</ps3>
<LB_matin>".$liturgia['LB_matin']."</LB_matin> 
<RB_matin>".$liturgia['RB_matin']."</RB_matin> ";
			if($liturgia['benedictus_A']){ // C'est un dimanche ou une date avec plusieurs A,B,C
				$expr="benedictus_".$tableau['matin']['lettre_annee'];
				$output.="<benedictus>".$liturgia[$expr]."</benedictus>";
			}
			else $output.="<benedictus>".$liturgia['benedictus']."</benedictus>";
$output.="<laudes_preces>".$liturgia['laudes_preces']."</laudes_preces>";
			if($liturgia['oratio'])	$output.="<oratio_laudes>".$liturgia['oratio']."</oratio_laudes>";
			else $output.="<oratio_laudes>".$liturgia['oratio_laudes']."</oratio_laudes>";

$output.="
<osb_laudes_ex_intitule id=\"\" />
<osb_laudes_ex_ps1 id=\"\" />
<osb_laudes_ex_ps2 id=\"\" />
<osb_laudes_ex_ps3 id=\"\" />
<osb_laudes_ex_ps4 id=\"\" />
<osb_laudes_ex_ps5 id=\"\" />
<osb_laudes_ex_ant1 id=\"\" />
<osb_laudes_ex_ant2 id=\"\" />
<osb_laudes_ex_ant3 id=\"\" />
<osb_laudes_ex_ant4 id=\"\" />
<osb_laudes_ex_ant5 id=\"\" />
<osb_laudes_ex_hymne id=\"\" />
<osb_laudes_ex_vers id=\"\" />
<osb_laudes_ex_LB id=\"\" />
<osb_laudes_ex_RB id=\"\" />
<osb_laudes_ex_benedictus id=\"\" />
<osb_laudes_ex_oratio id=\"\" />
<HYMNUS_3>".$liturgia['HYMNUS_tertiam']."</HYMNUS_3>
<HYMNUS_6>".$liturgia['HYMNUS_sextam']."</HYMNUS_6>
<HYMNUS_9>".$liturgia['HYMNUS_nonam']."</HYMNUS_9>
<osb_sexte_ant id=\"\" />
<osb_none_ant id=\"\" />
<osb_sexte_ps1 id=\"\" />
<osb_sexte_ant2 id=\"\" />
<osb_sexte_ant3 id=\"\" />
<osb_none_ps1 id=\"\" />
<osb_none_ant2 id=\"\" />
<osb_none_ant3 id=\"\" />
<ant4>".$liturgia['ant4']."</ant4>
<ps4>".$liturgia['ps4']."</ps4>
<ant5>".$liturgia['ant5']."</ant5>
<ps5>".$liturgia['ps5']."</ps5>
<ant6>".$liturgia['ant6']."</ant6>
<ps6>".$liturgia['ps6']."</ps6>
<LB_3>".$liturgia['LB_3']."</LB_3>
<RB_3>".$liturgia['RB_3']."</RB_3>
<LB_6>".$liturgia['LB_6']."</LB_6>
<RB_6>".$liturgia['RB_6']."</RB_6>
<LB_9>".$liturgia['LB_9']."</LB_9>
<RB_9>".$liturgia['RB_9']."</RB_9>
<oratio_3>".$liturgia['oratio_3']."</oratio_3>
<oratio_6>".$liturgia['oratio_6']." </oratio_6>
<oratio_9>".$liturgia['oratio_9']."</oratio_9>";

			$output.="
<intitule_soir><la>".$liturgia['intitule_soir_la']."</la></intitule_soir>
<rang_soir><la>".$liturgia['rang_soir_la']."</la></rang_soir>
<office_soir><la>".$liturgia['office_soir_la']."</la></office_soir>
<HYMNUS_vepres>".$liturgia['HYMNUS_vesperas']."</HYMNUS_vepres>
<ant7>".$liturgia['ant7']."</ant7>
<ps7>".$liturgia['ps7']."</ps7>
<ant8>".$liturgia['ant8']."</ant8>
<ps8>".$liturgia['ps8']."</ps8>
<ant9>".$liturgia['ant9']."</ant9>
<ps9>".$liturgia['ps9']."</ps9>
<LB_soir>".$liturgia['LB_soir']."</LB_soir>
<RB_soir>".$liturgia['RB_soir']."</RB_soir>
<magnificat>".$liturgia['magnificat']."</magnificat>
<vepres_preces>".$liturgia['vepres_preces']."</vepres_preces>
<oratio_vepres>".$liturgia['oratio_vesperas']."</oratio_vepres>
<osb_vepres_ps1 id=\"\" />
<osb_vepres_ps2 id=\"\" />
<osb_vepres_ps3 id=\"\" />
<osb_vepres_ps4 id=\"\" />
<osb_vepres_ant1 id=\"\" />
<osb_vepres_ant2 id=\"\" />
<osb_vepres_ant3 id=\"\" />
<osb_vepres_ant4 id=\"\" />
<osb_vepres_hymne id=\"\" />
<osb_vepres_vers id=\"\" />
<osb_vepres_LB id=\"\" />
<osb_vepres_RB id=\"\" />
<osb_vepres_magnificat id=\"\" />
<osb_vepres_oratio id=\"\" />
<osb_vepres_ex_intitule id=\"\" />
<osb_vepres_ex_ps1 id=\"\" />
<osb_vepres_ex_ps2 id=\"\" />
<osb_vepres_ex_ps3 id=\"\" />
<osb_vepres_ex_ps4 id=\"\" />
<osb_vepres_ex_ant1 id=\"\" />
<osb_vepres_ex_ant2 id=\"\" />
<osb_vepres_ex_ant3 id=\"\" />
<osb_vepres_ex_ant4 id=\"\" />
<osb_vepres_ex_hymne id=\"\" />
<osb_vepres_ex_vers id=\"\" />
<osb_vepres_ex_LB id=\"\" />
<osb_vepres_ex_RB id=\"\" />
<osb_vepres_ex_magnificat id=\"\" />
<osb_vepres_ex_oratio id=\"\" />
";
	$output.="		
<HYMNUS_complies>".$liturgia['HYMNUS_completorium']."</HYMNUS_complies>
<comp_ant1>".$liturgia['ant10']."</comp_ant1>
<comp_ps1>".$liturgia['ps10']."</comp_ps1>
<comp_ant2>".$liturgia['ant11']."</comp_ant2>
<comp_ps2>".$liturgia['ps11']."</comp_ps2>
<comp_LB>".$liturgia['LB_completorium']."</comp_LB>
<comp_RB>".$liturgia['RB_completorium']."</comp_RB>
<comp_oratio>".$liturgia['oratio_completorium']."</comp_oratio>";
	
	if ($tableau['soir']['temps']=="Tempus Adventus") $liturgia['comp_AM']="Alma_redemptoris";
	if ($tableau['soir']['temps']=="Tempus Nativitatis") $liturgia['comp_AM']="Alma_redemptoris";
	if(date("m",$date_courante)=="01") $liturgia['comp_AM']="Alma_redemptoris";
	elseif(date("m-d",$date_courante)=="02-01") $liturgia['comp_AM']="Alma_redemptoris";
	elseif ($tableau['soir']['temps']=="Tempus per annum") $liturgia['comp_AM']="Salve_regina";
	if ($tableau['soir']['temps']=="Tempus Quadragesimae") $liturgia['comp_AM']="Ave_regina_caelorum";
	if ($tableau['soir']['temps']=="Tempus Paschale") $liturgia['comp_AM']="Regina_caeli";
	if (($tableau['soir']['1V']=="1")&&($calendarium['priorite'][$d]<6))  $liturgia['comp_AM']="Sub_tuum";
	$output.="<comp_AM>".$liturgia['comp_AM']."</comp_AM>";
			//2 cas : sanctoral ou temporal
			$ref_=strtolower("temporal_".$tableau['matin']['lettre_annee']);
			$ref_messe=$messe;
			if($ref_messe=="Feria II hebdomadae sanctae") $ref_messe="HS_2";
			if($ref_messe=="Feria III hebdomadae sanctae") $ref_messe="HS_3";
			if($ref_messe=="Feria IV hebdomadae sanctae") $ref_messe="HS_4";
			if($ref_messe=="HS_5_AD_MISSAM_CHRISMATIS") $ref_messe="HS_5_AD_MISSA_VESPERTINA_IN_CENA_DOMINI";
			if($ref_messe=="06-24") $ref_messe="06-24-in-die";
			//print" ref_messe=".$ref_messe."\n ";
			$xmlT = simplexml_load_file($ref_.".xml");
			$propreT = $xmlT->xpath("//".$ref_."//celebration[@id='".$ref_messe."']");
			//print"\r\n //celebration[@id='".$ref_messe."']";
			//print_r($propre);

			// sanctoral
			$xmlS = simplexml_load_file("sanctoral_messe.xml");
			$propreS = $xmlS->xpath("//celebration[@id='".$ref_messe."']");
			//print"\r\n //celebration[@id='".$ref_messe."']";
			//print_r($propre);
			if($propreS) { // priorité au sanctoral
				$propre=$propreS;
				$lecture1=$messe;
				$lecture2="";
				if($calendarium['priorite'][$d]<7) $lecture2=$messe;
				$evangile="EV_".$messe;
			}
			else { // priorite au temporal
				$propre=$propreT;
				if($calendarium['priorite'][$d]>6){
					$expr="//celebration[@id='".$messe."']//LEC_1_".$parite;
					$lec1=$lst->xpath($expr);
					$lecture1=$lec1[0];
					$lecture2="";
					$expr="//celebration[@id='".$messe."']//EV";
					$ev=$lst->xpath($expr);
					$evangile="EV_".$ev[0];
				}
				if($calendarium['priorite'][$d]<7){
					$lecture1=$messe."_".$tableau['matin']['lettre_annee'];
					$lecture2=$messe."_".$tableau['matin']['lettre_annee'];
					$evangile="EV_".$messe."_".$tableau['matin']['lettre_annee'];
				}
			}
			$output.="<messe id=\"".$messe."\">
<IN>".$propre[0]->IN_."</IN>";
			if($propre[1]->IN_) $output.="<IN>".$propre[1]->IN_."</IN>";
			if($propre[2]->IN_) $output.="<IN>".$propre[2]->IN_."</IN>";
			$output.="

<KY></KY>
<GLO></GLO>";
			if($liturgia['oratio'])	$output.="<COL>".$liturgia['oratio']."</COL>";
			else $output.="<COL>".$liturgia['oratio_laudes']."</COL>";
			$output.="
<LEC1>".$lecture1."</LEC1>	
<PS1>".$propre[0]->PS1."</PS1>
<LEC2>".$lecture2."</LEC2>
<PS2>".$propre[0]->PS2."</PS2>
<SEQ>".$propre[0]->SEQ."</SEQ>
<EV>".$evangile."</EV>
<OF>".$propre[0]->OF."</OF>
<SO></SO>
<PREF></PREF>
<SAN></SAN>
<CAN></CAN>
<AGN></AGN>
<CO>".$propre[0]->CO."</CO>
<PC></PC>
<ML_IN></ML_IN>
<ML_PS></ML_PS>
<ML_AL></ML_AL>
<ML_CO></ML_CO>
</messe>
";	
			$output.="</ordo>";
		}
		$output.=viergemarie($date_courante);
		$output.=jerusalem($date_courante);
		$output.=pietePopulaire($messe,$date_courante);
		$output.=calendriercivil($messe,$date_courante);
		$output.=journeesdediees($messe,$date_courante);
		
		$output.=biographie($date_courante);
		$mar=martyrologe($date_courante);
		$output.="<martyrologe>";
		//print_r($mar);
		
		foreach ($mar as $martyrologe) {
			$fd=0;
			foreach ($martyrologe->item as $para) {
			$output.="<para id=\"".$fd."\">".$para."</para>";
			$fd++;
			}
		}
		$output.="</martyrologe>";
		$output.="<compendium>".compendium($date_courante)."</compendium>";
		
		$output.="</calendarium>";

		$sxe = new SimpleXMLElement($output);
		
		//$sxe->addChild("martyrologe",$mar);
		$sxe->asXML("calendrier/".@date("Y-m-d",$date_courante).".xml");
		$date_courante=$date_courante+$jour;
		$output="";
	}
	$codes="";

	$i++; if ($i==7) $i=0;

	////////////////////////////////////////////////////////////
	////////////// Génération du calendrier mensuel
	////////////////////////////////////////////////////////////
	
	$annee=$m;
	for($p=0;$p<count($cal);$p++) {
		$calendarium=$cal[$p];
		//print_r($calendarium);
		$ordo=$calendarium['ordo'];
		$date_courante=mktime(12,0,0,1,1,$m);
		$dernier_jour=mktime(12,0,0,12,31,$m);
		$jour=60*60*24;
		while($date_courante <= $dernier_jour) {
			//print"\r\n".date("Y-m-d",$date_courante);
			$mois[$ordo][date('n',$date_courante)].="
		<jour date=\"".@date("Ymd",$date_courante)."\">
		<intitule>
		<la>".$calendarium['intitule'][date("Ymd",$date_courante)]."</la>
		<fr>".get_traduction($calendarium['intitule'][date("Ymd",$date_courante)],"fr",$traductions)."</fr>
		</intitule>
		<couleur>".$calendarium['couleur_template'][date("Ymd",$date_courante)]."</couleur>
		</jour>";
			$date_courante+=$jour;
		}
	}

	for($b=1;$b<13;$b++) {
		print"\r\n DEBUG annee= ".$annee;
		$content="<mois>";
		for($p=0;$p<count($cal);$p++) {
			$calendarium=$cal[$p];

			$ordo=$calendarium['ordo'];
			$content.="<ordo id=\"".$ordo."\">";
			$content.=$mois[$ordo][$b];
			$content.="</ordo>";
		}
		$content.="</mois>";
		//print_r($content);
		$sxe = new SimpleXMLElement($content);
		$sxe->asXML("calendrier/".$annee."-".$b.".xml");
		

	}
	print"\r\n Fin du script.";
	
}

?>