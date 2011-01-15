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
$REX['ADDON']['version'][$mypage] = "0.0.4";
$REX['ADDON']['author'][$mypage] = "Sven (Koala) Eichler";
// $REX['ADDON']['supportpage'][$mypage] = "";

// add default perm for accessing the addon to user-administration
$REX['PERM'][] = 'debug[]';


include_once ('functions/function_debug.inc.php');
include_once ('krumo/class.krumo.php');
