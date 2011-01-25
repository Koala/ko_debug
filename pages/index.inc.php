<?php
/**
 * Debug Addon 
 * @author sven[ät]koalshome[punkt]de Sven Eichler
 * @package redaxo4
 */


// Parameter
$Basedir = dirname(__FILE__);
$func = rex_request('func', 'string');
$subpage = rex_request('subpage', 'string');

if (!isset ($func))
{
  $func = '';
}

if (!isset ($subpage))
{
  $subpage = '';
}

//------------------------------> Main


// Include Header and Navigation
include $REX['INCLUDE_PATH'].'/layout/top.php';

// Build Subnavigation
$subpages = array (
    array ('','Startseite'),
    array ('settings','Konfiguration')
  );

rex_title('Debug Addon', $subpages);


switch ($subpage){
    
    case 'settings':
        require $Basedir .'/settings.inc.php';
    break;
    default:
        require $Basedir .'/start.inc.php';
}


// Include Footer 
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
