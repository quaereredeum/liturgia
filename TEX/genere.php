<?php
include "syllabifier.php";
function isAccentuated($syllabe) {
	$res=null;
	$accentuatedVowel=array("á","é","í","ó","ú","ǽ","æ","œ");
	//print_r($accentuatedVowel);
for($i = 0;  $i < count($accentuatedVowel); $i++) {
		$res=strpos($syllabe,$accentuatedVowel[$i]);
		if($res!=null) 
			return true;
	}
	return false;
}
function cadence($word,$ton) {
	$word=syllabify($word);
	
	//print"\r\n".$word;
	$syllabes=explode("#",$word);
	foreach($syllabes as $syllabe) {
		//print"\r\n".$syllabe;
		if(isAccentuated($syllabe)) $syllabe="\underline{".$syllabe."}";
		$cadencedWord.=$syllabe;
	}
	//print "\r\n".$cadencedWord;
	return $cadencedWord." ";
}
function antienne($ref=null,$lang="fr") {
	$xml=simplexml_load_file("http://www.radio-esperance.fr/wp-content/plugins/liturgia/sources/propres/office/AN_A_porta_inferi.xml");
	//print_r($xml);
	//print $xml->ligne->la."\r\n".$xml->ligne->fr;
	$result="
\begin{Parallel}[v]{\colwidth}{\colwidth}
\latin{ Ant. ";
	$result.=$xml->ligne->la;
	$result.="
}
\\vern{ Ant. ";
	$result.=$xml->ligne->fr;
	$result.="}
\end{Parallel}";
	return $result;
}

function hymne($ref=null,$lang="fr",$ton=null){
	$file=file_get_contents("http://www.radio-esperance.fr/wp-content/plugins/liturgia/sources/".$ref.".xml");
	$file=str_ireplace("&#xA0;"," ",$file);
	print_r($file);
	$xml=simplexml_load_string($file);
	$result="\begin{Parallel}[v]{\colwidth}{\colwidth}";
	/*$result.="\latin{\\textsc{\\begin{center}HYMNUS\\end{center}}}\\vern{\\textsc{\\begin{center}HYMNE\\end{center}}}";*/
	foreach ($xml->ligne as $li) {
	$result.="
	\latin{\\textnormal{\\begin{center}~".$li->la."\\end{center}}}
	\\vern{\\textnormal{\\begin{center}~".$li->fr."\\end{center}}}";
	}
	$result.="\end{Parallel}";
	return $result;
}

function psaume($ref=null,$lang="fr") {
	$file=file_get_contents("http://www.radio-esperance.fr/wp-content/plugins/liturgia/sources/".$ref.".xml");
	
	$file=str_ireplace("&#xA0;"," ",$file);
	$xml=simplexml_load_string($file);
	//print_r($xml);
	//print $xml->ligne->la."\r\n".$xml->ligne->fr;
	$result="
\begin{Parallel}[v]{\colwidth}{\colwidth}";
	$n=0;
	foreach ($xml->ligne as $li) {
		$n++;
		$verset="";
		if($li->la) {
			//$li->la=
			//print"\r\n".$li->la;
			$mLa=explode(" ",$li->la);
			foreach($mLa as $m) {
			//print"\r\n".$m;
				$verset.=cadence($m,$ton);
			}
			
			
			//$verset=utf8_decode($verset);
			//print"\r\n".$verset;
			
			if($n==1) $result.="
\latin{\\textsc{\\begin{center}".$li->la."\\end{center}}}
\\vern{\\textsc{\\begin{center}".$li->fr."\\end{center}}}";
		
		elseif($n==2)$result.="
\latin{\\textit{\\textbf{\\begin{center}".$li->la."\\end{center}}}}
\\vern{\\textit{\\textbf{\\begin{center}".$li->fr."\\end{center}}}}";
		
		
		elseif($n==3) $result.="
\latin{\\textit{\\begin{center}".$li->la."\\end{center}}}
\\vern{\\textit{\\begin{center}".$li->fr."\\end{center}}}";
		else
		 $result.="
\latin{ ".$li->la."}
\\vern{ ".$li->fr."}";
		}
	}
	$result.="\end{Parallel}";
	return $result;
}

$output="
\documentclass[twoside,10pt]{book}
\usepackage[francais,latin]{babel}
\usepackage[OT2,T1]{fontenc}
\usepackage{vmargin}
%\setpapersize{A5}
\usepackage{aeguill}
%\usepackage{ae}
%\usepackage{textcomp}
\usepackage{fullpage}
\usepackage{lettrine}
\usepackage{yfonts}
\usepackage{color}
\usepackage{pdfcolmk}
\usepackage{fancyhdr}
\usepackage{parallel}
\usepackage[pdftex]{graphicx}        % Your input file must contain these two lines 
\setlength{\pdfpagewidth}{5.5in}
\setlength{\pdfpageheight}{8.5in}
\usepackage{parallel}
\usepackage{lipsum}
";

// TITRE
$output.="
\usepackage[pdftex, bookmarks, colorlinks=false, pdftitle={".$title."}, pdfborder={0 0 0}, pdfauthor={".$author."}]{hyperref}
\input conf.tex
\begin{document}
\\vspace{0.1cm} ";

// HYmne
$output.=hymne("HY_O_lux_beata_caelitum");

$output.=antienne();
/// Psaume
$output.=psaume("ps126");
//
$output.=antienne();
$output.="
\end{document}
";

$fp = fopen('c:/phpscriptscli/liturgia/tex/output/output.tex', 'w');
fwrite($fp, $output);
fclose($fp);

exec("lualatex c:/phpscriptscli/liturgia/tex/output/output.tex");
 

?>