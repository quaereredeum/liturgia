<?php
$source="Dixit Dóminus Dómino meo: *
«Sede a dextris meis,
donec ponam inimícos tuos * 
scabéllum pedum tuórum».
Virgam poténtiæ tuæ emíttet Dóminus ex Sion: * 
domináre in médio inimicórum tuórum.
Tecum principátus in die virtútis tuæ, in splendóribus sanctis, * 
ex útero ante lucíferum génui te.
";

function substr_unicode($str, $s, $l = null) {
	return join("", array_slice(
	preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}


/*
 $vowels = array('a', 'e', 'i', 'o', 'u',
 'á', 'é', 'í', 'ó', 'ú',
 'æ', 'œ',
 'ǽ',  // no accented œ in unicode?
 'y'); // y is treated as a vowel; not native to Latin but useful for words borrowed from Greek
 */
$vowels = array('a', 'e', 'i', 'o', 'u','æ', 'œ','y');
$muteConsonantsAndF = array('b', 'c', 'd', 'g', 'p', 't','f');
$liquidConsonants = array('l', 'r');
$diphthongs = array("ae", "au", "oe");
/*
 $wordExceptions["huius"] = new Word(["hu", "ius"]);
 $wordExceptions["cuius"] = new Word(["cu", "ius"]);
 $wordExceptions["huic"] = new Word(["huic"]);
 $wordExceptions["cui"] = new Word(["cui"]);
 $wordExceptions["hui"] = new Word(["hui"]);
 */


function isMuteConsonantOrF($c) {
	global $muteConsonantsAndF;
	for($i = 0;  $i < count($muteConsonantsAndF); $i++) {
		if ($muteConsonantsAndF[$i] == $c)
		return true;
	}
	return false;
}

function isVowel($v) {
	global $vowels;
	for($i = 0;  $i < count($vowels); $i++) {
		if (utf8_decode($vowels[$i]) == utf8_decode($v))
		return true;
	}
	return false;
}

function isLiquidConsonant($c) {

	global $liquidConsonants;
	for($i = 0;  $i < count($liquidConsonants); $i++) {
		if ($liquidConsonants[$i] == $c)
		return true;
	}

	return false;
}

/**
 *
 * @param {String} s The string to test; must be lowercase
 * @return {boolean} true if s is a diphthong
 */

function isDiphthong($s) {
	global $diphtongs;
	for($i = 0;  $i < count($diphtongs); $i++) {
		if ($diphtongs[$i] == $c)
		return true;
	}
}

function work($string) {
	//$string=strtolower($string);
	$avecaccent=array("á","é","í","ó","ú","ǽ");
	$sansaccent=array("a","e","i","o","u","æ");
	//str_replace($search, $replace, $subject)
	//$noaccent=str_replace($avecaccent, $sansaccent, $lowstring);
	//print"\r\n ".str_replace( $avecaccent,$sansaccent, $string)."\r\n";
	return utf8_decode(strtolower(str_replace( $avecaccent,$sansaccent, $string)));
	//return "primordiis";
}

/**
 * @param {String} s the string to search
 * @param {Number} startIndex The index at which to start searching for a vowel in the string
 * @retuns a custom class with three properties: {found: (true/false) startIndex: (start index in s of vowel segment) length ()}
 */



/**
 * Rules for Latin syllabification (from Collins, "A Primer on Ecclesiastical Latin")
 *
 * Divisions occur when:
 *   1. After open vowels (those not followed by a consonant) (e.g., "pi-us" and "De-us")
 *   2. After vowels followed by a single consonant (e.g., "vi-ta" and "ho-ra")
 *   3. After the first consonant when two or more consonants follow a vowel
 *      (e.g., "mis-sa", "minis-ter", and "san-ctus").
 *
 * Exceptions:
 *   1. In compound words the consonants stay together (e.g., "de-scribo").
 *   2. A mute consonant (b, c, d, g, p, t) or f followed by a liquid consonant (l, r)
 *      go with the succeeding vowel: "la-crima", "pa-tris"
 *
 * In addition to these rules, Wheelock's Latin provides this sound exception:
 *   -  Also counted as single consonants are qu and the aspirates ch, ph,
 *      th, which should never be separated in syllabification:
 *      architectus, ar-chi-tec-tus; loquacem, lo-qua-cem.
 *
 * @param {String} The word to divide into syllables
 * @returns {Word} The Word object with parsed syllables
 */
$syllables = array();

function syllabify($word) {

	$s=0;
	$haveCompleteSyllable = false;
	$previousWasVowel = false;
	$workingString = work($word);
	$ss = 0;
	$wordLength=strlen ($workingString);

	global $syllables;
	$syllables=null;

	for ($i = 0; $i < $wordLength; $i++) { // BOUCLE principale : on parcourt le mot
		//print" startSyllable :".$ss."\r\n";
		$lookahead=null;
		$c=substr($workingString, $i,1);
		if(($i + 1) < $wordLength) $lookahead=substr($workingString, $i+1,1);
		//if(!$lookahead) $syllables[$s-1].=$c;
		$next=null;
		if(($i + 2) < $wordLength) $next=substr($workingString, $i+2,1);

		$cIsVowel = isVowel($c);
		//if ($haveLookahead) $lookahead = substr($workingString, $i+1,1); // On a une lettre après l'actuelle


		// i is a special case for a vowel. when i is at the beginning
		// of the word (Iesu) or i is between vowels (alleluia),
		// then the i is treated as a consonant (y)
		if ($c == 'i') {
			if ($i == 0 && ($lookahead!=null) && isVowel($lookahead)) $cIsVowel = false;
			elseif (isVowel(substr($workingString, $i-1,1)) && ($lookahead!=null) && isVowel($lookahead)) $cIsVowel = false;
		}
		if(($c=='a')&&(($lookahead=='e')||($lookahead=='u'))) { // DIPHTONGUE ae ou au
			$i++;
			$haveLookahead = ($i + 1) < $wordLength;
			if(($i + 1) < $wordLength) $lookahead=substr($workingString, $i+1,1);
			if(($i + 2) < $wordLength) $next=substr($workingString, $i+2,1);
		} // FIN CAS DIPHTONGUE
	 if (($c == 'q' && $lookahead == 'u') ||  ($lookahead == 'n' && ($c == 'g'))||  ($lookahead == 'h' && ($c == 'c' || $c == 'p' || $c == 't'))) {
			// handle wheelock's exceptions for qu, ch, ph and th and gn \r\n";
			//if($lookahead == 'h' && ($c == 'c' || $c == 'p' || $c == 't')) print"// handle wheelock's exceptions for qu, ch, ph and th \r\n";
			$i=$i+1; // skip over the 'h' or 'u'
			$c=substr($workingString, $i,1);
			$cIsVowel=false;
	 }
		if(($cIsVowel) && (isVowel($lookahead))) { // c est une voyelle et lookahead est une voyelle
			//CAS COLLINS 1 - creation syllabe :
			//print"// $i $c  lookahead est une voyelle : $lookahead CAS COLLINS 1  \r\n";
			$syllables[$s]=substr_unicode($word,$ss,$i-$ss+1);
			//print $ss." ".$syllables[$s]." ".strlen($syllables[$s])."\r\n";
			$ss=$i+1;

			$s++;
		}


		if($cIsVowel && (!isVowel($lookahead)) && (isVowel($next)) ) {
			//print"// $i $c lookahead est une consonne $lookahead et next est une voyelle $next : CAS COLLINS 2 \r\n";
			$syllables[$s]=substr_unicode($word,$ss,$i-$ss+1);
			$ss=$i+1;
			//print $syllables[$s]."\r\n";
			$s++;
		}
		if($cIsVowel && (!isVowel($lookahead)) && (!isVowel($next)) ) {
			//2. A mute consonant (b, c, d, g, p, t) or f followed by a liquid consonant (l, r)
			//*      go with the succeeding vowel: "la-crima", "pa-tris"
			if(isMuteConsonantOrF($lookahead) && isLiquidConsonant($next)) {
				//print"// A mute consonant (b, c, d, g, p, t) or f followed by a liquid consonant (l, r)";
				$syllables[$s]=substr_unicode($word,$ss,$i-$ss+1);
				//print $ss." ".$ss[$s]." ".strlen($syllables[$s])."\r\n";
				$ss=$i+1;

			}
			else {
				//print"// $i $c  lookahead est une consonne $lookahead et next est une consonne $next : CAS COLLINS 3 \r\n";
				if($next == 'h' && ($lookahead == 'c' || $lookahead == 'p' || $lookahead == 't') ||  ($next == 'n' && ($lookahead == 'g'))) {
					//print"// handle wheelock's exceptions for qu, ch, ph and th and gn\r\n";
					$syllables[$s]=substr_unicode($word,$ss,$i-$ss+1);
					$ss=$i+1;
				}
				else {
					$syllables[$s]=substr_unicode($word,$ss,$i-$ss+2);
					//print $ss." ".$ss[$s]." ".strlen($syllables[$s])."\r\n";
					$ss=$i+2;
				}
				//if($i+2==$wordLength) ;
			}
			//print $syllables[$s]."\r\n";
			$s++;
		}


		/*
		 if($cIsVowel && !$haveLookahead) {
			$syllables[$s]=substr($word,$startSyllable,$i-$startSyllable+1);
			$ss+=strlen($syllables[$s]);
			$s++;

			}
			*/
			
	}
	$syllables[$s-1].=substr_unicode($word,$ss);

	for ($ii=0; $ii<count($syllables);$ii++) {
		if($syllables[$ii]) { $result.=$syllables[$ii]."#";
		}
	}
	$result=trim($result,"()");


	return $result;
}

/*
 function  syllabifyWord($word) {

 $haveCompleteSyllable = false;
 $previousWasVowel = false;
 $workingString = strtolower($word);
 $startSyllable = 0;

 //var c, lookahead, haveLookahead;


 $c = ' '; // used just for a silly breakpoint in firebug!
 $wordLength=strlen ($workingString);
 for ($i = 0; $i < $wordLength; $i++) {

 $c = $workingString[$i];

 // get our lookahead in case we need them...
 $lookahead = '*';
 $haveLookahead = ($i + 1) < $wordLength;

 if ($haveLookahead) $lookahead = $workingString[$i + 1];

 $cIsVowel = isVowel($c);

 // i is a special case for a vowel. when i is at the beginning
 // of the word (Iesu) or i is between vowels (alleluia),
 // then the i is treated as a consonant (y)
 if ($c == 'i') {
 if ($i == 0 && $haveLookahead && $isVowel($lookahead)) $cIsVowel = false;
 elseif ($previousWasVowel && $haveLookahead && $isVowel($lookahead)) {
 $cIsVowel = false;
 }
 }

 if ($c == '-') {

 // a hyphen forces a syllable break, which effectively resets
 // the logic...

 $haveCompleteSyllable = true;
 $previousWasVowel = false;
 makeSyllable($i - $startSyllable);
 $startSyllable++;

 } elseif ($cIsVowel) {

 // once we get a vowel, we have a complete syllable
 $haveCompleteSyllable = true;

 if ($previousWasVowel && !isDiphthong($workingString[$i - 1]."".$c)) {
 makeSyllable($i - $startSyllable);
 $haveCompleteSyllable = true;
 }

 $previousWasVowel = true;

 } elseif ($haveLookahead) {

 if (($c == 'q' && $lookahead == 'u') ||
 ($lookahead == 'h' && ($c == 'c' || $c == 'p' || $c == 't'))) {
 // handle wheelock's exceptions for qu, ch, ph and th
 makeSyllable($i - $startSyllable);
 $i++; // skip over the 'h' or 'u'
 } elseif ($previousWasVowel && isVowel($lookahead)) {
 // handle division rule 2
 makeSyllable($i - $startSyllable);
 } elseif (isMuteConsonantOrF($c) && isLiquidConsonant($lookahead)) {
 // handle exception 2
 makeSyllable($i - $startSyllable);
 } elseif ($haveCompleteSyllable) {
 // handle division rule 3
 makeSyllable($i + 1 - $startSyllable);
 }

 $previousWasVowel = false;
 }
 }

 // if we have a complete syllable, we can add it as a new one. Otherwise
 // we tack the remaining characters onto the last syllable.
 if ($haveCompleteSyllable)
 //$syllables.push(new Syllable(word.substr(startSyllable)));
 $syllables[]=substr($word,$startSyllable);
 elseif ($startSyllable > 0)
 $syllables[strlen($syllables) - 1] += substr($word,$startSyllable);

 return $syllables;
 }
 */
// a helper function to create syllables


/*
 print syllabify("sanctus")."\r\n";
 print syllabify("minister")."\r\n";
 print syllabify("missa")."\r\n";
 print syllabify("pius")."\r\n";
 print syllabify("Deus")."\r\n";
 print syllabify("Dominus")."\r\n";

 print syllabify("describo")."\r\n";


 print syllabify("hora")."\r\n";
 print syllabify("misericordia")."\r\n";

 print syllabify("lacrima")."\r\n";
 print syllabify("patris")."\r\n";
 print syllabify("potentiae")."\r\n";
 print syllabify("loquacem")."\r\n";
 print syllabify("Iesu")."\r\n";
 print syllabify("alleluia")."\r\n";

 print syllabify("Phillipenses")."\r\n";
 print syllabify("loqueris")."\r\n";
 print syllabify("saeculorum")."\r\n";
 print syllabify("aeternum")."\r\n";
 print syllabify("saepe")."\r\n";
 print syllabify("laudas")."\r\n";
 print syllabify("adulescentia")."\r\n";
 print syllabify("caelorum")."\r\n";
 print syllabify("regnans")."\r\n";
 print syllabify("primórdiis")."\r\n";
 /*
 print syllabify("auge")."\r\n";
 print work(syllabify("mortuus"))."\r\n";
 print work(syllabify("saeculum"))."\r\n";
 print work(syllabify("Praesta"))."\r\n";
 print work(syllabify("Præsta"))."\r\n";

 print work(syllabify("Præsta"))."\r\n";
 print work(syllabify("cuius"))."\r\n";
 print work(syllabify("Alpha"))."\r\n";
 print work(syllabify("Photographia"))."\r\n";
 print work(syllabify("appropiphare"))."\r\n";
 */
//print work(syllabify("próferens"))."\r\n";
/*
 print syllabify("sæculum")."\r\n";
 print syllabify("saeculum")."\r\n";
 print syllabify("siculum")."\r\n";
 print syllabify("sáculum")."\r\n";

 $texte= "Lucis creátor óptime,
 lucem diérum próferens,
 primórdiis lucis novæ
 mundi parans oríginem;
 Qui mane iunctum vésperi
 diem vocári præcipis:
 tætrum chaos illábitur;
 audi preces cum flétibus.
 Ne mens graváta crímine
 vitæ sit exsul múnere,
 dum nil perénne cógitat
 seséque culpis ílligat.
 Cælórum pulset íntimum,
 vitále tollat præmium;
 vitémus omne nóxium,
 purgémus omne péssimum.
 Præsta, Pater piíssime,
 Patríque compar Unice,
 cum Spíritu Paráclito
 regnans per omne sæculum. Amen.
 ";

 $txt="";
 $mots=explode(" ",$texte);
 foreach ($mots as $mot) {
 print syllabify($mot)." ";
 $txt.=syllabify($mot)." ";
 }

 $fp = fopen('texte.txt', 'w');
 fwrite($fp, $txt);
 fclose($fp);

 //print"\r\n".isVowel("s");
 */
?>