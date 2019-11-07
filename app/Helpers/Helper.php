<?php
// helper file
function getCurrentNepaliYear(){
    $currentEnglishDay = date('d'); $currentEnglishMonth = date('m'); $currentEnglishYear = date('Y');
    $monthCarry = floor(($currentEnglishDay + 15) / 30);
    $yearCarry = floor(($currentEnglishMonth + $monthCarry + 8) / 12);
    return intval($currentEnglishYear + $yearCarry + 56);
}