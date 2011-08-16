<?php
/**
 * Debug Addon 
 * @author sven[ät]koalashome[punkt]de Sven Eichler
 * @package redaxo4
 */


/**
 * Pruefe ob Session neu gestartet wurde.
 * Wenn ja, vergib eine neue Session-ID.
 * 
 * @link	http://phpsec.org/projects/guide/4.html
 * @return	bool
 */
function checkInitiatedSession() {
  $status = '';
  if (!isset($_SESSION['initiated']))
  {
      $status = session_regenerate_id();
      $_SESSION['initiated'] = true;
  }
  return $status === false? false : true;
}


/**
 * Vergleiche in Session gespeicherten USER_AGENT mit dem vom Client gesendeten.
 * Stimmen die beiden nicht überein, beende das Script.
 * 
 * Status: EXPERIMENTAL !!!
 * @link	http://phpsec.org/projects/guide/4.html
 * 
 * @return	bool
 */
function checkUserAgentPerMD5() {

  $status = '';
  if (isset ($_SERVER['HTTP_USER_AGENT'])) {
    if (isset($_SESSION['HTTP_USER_AGENT']))
    {
      if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
      {
        // ziemlich drastisch!?
        // Besser eine Nachricht ausgeben?
        exit;
      }
    }
    else
    {
      $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
    }
  }
  return $status === false? false : true;
}



