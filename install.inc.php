<?php
/**
 * Debug Addon 
 * @author sven[ät]koalshome[punkt]de Sven Eichler
 * @package redaxo4
 */


$dir = dirname(__FILE__);
$I18N->appendFile($dir .'/lang/');
require_once $dir .'/settings.inc.php';

$msg = '';

if (!@is_writeable($dir .'/settings.inc.php')) 
{
  $msg = $I18N->msg('ko_debug_install_perm_settings');
}


if ($msg != '') 
{
  $REX['ADDON']['installmsg']['ko_debug'] = $msg;
  $REX['ADDON']['install']['ko_debug'] = false;
} else {
  $REX['ADDON']['install']['ko_debug'] = true;
}