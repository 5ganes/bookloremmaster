<?php

// Nepali Date Manipulation Functions *******************************************************
	
	// get current nepali year
		function getCurrentNepaliYear(){
		    $currentEnglishDay = date('d'); $currentEnglishMonth = date('m'); $currentEnglishYear = date('Y');
		    $monthCarry = floor(($currentEnglishDay + 15) / 30);
		    $yearCarry = floor(($currentEnglishMonth + $monthCarry + 8) / 12);
		    return intval($currentEnglishYear + $yearCarry + 56);
		}
	// get current nepali year ends

	// get Nepali Months Array or single month
		function getNepaliMonth($numericMonth = ''){
			$monthArray= array('', 'Baisakh', 'Jestha', 'Asar', 'Shrawan', 'Bhadra', 'Ashoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra');
			if(empty($numericMonth)) return $monthArray;
			else return $monthArray[$numericMonth];
		}
	// get Nepali Months Array ends	

// Nepali Date Manipulation Functions ********************************************************