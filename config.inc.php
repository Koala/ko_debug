<?php
/**
 * Debug Addon 
 * @author sven[ät]koalshome[punkt]de Sven Eichler
 * @package redaxo4
 */

// addon identifier
$mypage = "ko_debug";

$REX['ADDON']['rxid'][$mypage] = '81';

if ($REX['REDAXO']) {
  $I18N->appendFile($REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/');
}

$REX['ADDON']['page'][$mypage] = $mypage;    
$REX['ADDON']['name'][$mypage] = 'ko_Debug';
$REX['ADDON']['perm'][$mypage] = 'ko_debug[]';
$REX['ADDON']['version'][$mypage] = "1.1.0";
$REX['ADDON']['author'][$mypage] = "Sven (Koala) Eichler";
// $REX['ADDON']['supportpage'][$mypage] = "";

// add default perm for accessing the addon to user-administration
$REX['PERM'][] = 'ko_debug[]';

require_once dirname(__FILE__) .'/settings.inc.php';


if ($REX['ADDON']['settings']['ko_debug']['debug']) {
  include_once ('functions/function_debug.inc.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function Debug_Out() {
    return true;
  }
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function DBO() {
    return true;
  }
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function DebugOut() {
    return true;
  }
}


if ($REX['ADDON']['settings']['ko_debug']['krumo']) {
  include_once ('krumo/class.krumo.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn krumo deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function krumo() {
    return true;
  }
}
