<?php
/**
 * Debug Addon 
 * @author redaxo[at]koalashome[dot]de Sven (Koala) Eichler
 * @package redaxo4
 */

$name = null;
$version = null;
if(isset($argv) && count($argv) > 1)
{
	if(!empty($argv[1]))
	{
		$version = $argv[1];
	}
	if(!empty($argv[2]))
	{
		$name = $argv[2];
	}

  // Start Build-Script
  buildRelease($name, $version);
}
else
{
  echo '
/**
 * Erstellt ein Debug Release.
 *
 *
 * Verwendung in der Console:
 *
 *  Erstelles eines Release mit Versionsnummer:
 *  "php release.php 3.3"
 *
 *
 * Vorgehensweise des release-scripts:
 *  - Ordnerstruktur kopieren nach release/ko_debug_<Datum>
 *  - Dateien kopieren
 *  - Sprachdateien zu UTF-8 konvertieren
 *  - CVS Ordner loeschen
 */
';
}

function buildRelease($name = null, $version = null)
{
  // Ordner in dem das release gespeichert wird
  // ohne "/" am Ende!
  $cfg_path = 'release';
  $path = $cfg_path;

  if (!$name)
  {
    $name = 'ko_debug';
    if(!$version)
      $name .= date('ymd');
    else
      $name .= str_replace('.', '_', $version);
  }

  if($version)
    $version = explode('.', $version);

  if(substr($path, -1) != '/')
    $path .= '/';

  if (!is_dir($path))
    mkdir($path);

  $dest = $path . $name;

  if (is_dir($dest))
    trigger_error('release folder already exists!', E_USER_ERROR);
  else
    mkdir($dest);

  echo '>>> Build Debug release..'."\n";
  echo '> read files'."\n";

  // Ordner und Dateien auslesen
  $structure = readFolderStructure('.', array('.project','.settings','.cache', 'CVS', $cfg_path));

  echo '> copy files'."\n";
  // Ordner/Dateien kopieren
  foreach($structure as $path => $content)
  {
    // Zielordnerstruktur anlegen
    $temp_path = '';
    foreach(explode('/', $dest .'/'. $path) as $pathdir)
    {
      if(!is_dir($temp_path . $pathdir .'/'))
      {
        mkdir($temp_path . $pathdir .'/');
      }
      $temp_path .= $pathdir .'/';
    }

    // Dateien kopieren/Ordner anlegen
    foreach($content as $dir)
    {
      if(is_file($path.'/'.$dir))
      {
        copy($path.'/'.$dir, $dest .'/'. $path.'/'.$dir);

        if(substr($dir, -5) == '.lang' && substr($dir, -9) != 'utf8.lang')
        {
          echo '> convert file '. $dir .' to utf-8'."\n";
          buildUtf8LangFile( $dest .'/'. $path.'/'.$dir);
        }
      }
      elseif(is_dir($path.'/'.$dir))
        mkdir($dest .'/'. $path.'/'.$dir);
    }
  }



  $h = fopen($addons, 'w+');
  if (fwrite($h, $cont, strlen($cont)) > 0)
    fclose($h);

  // Das kopierte Release-Script aus dem neu erstellten Release l�schen
  unlink($dest .'/release.php');

  echo '>>> FINISHED'."\n";
}

/**
 * Returns the content of the given folder
 *
 * @param $dir Path to the folder
 * @return Array Content of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readFolder($dir)
{
  if (!is_dir($dir))
  {
    trigger_error('Folder "' . $dir . '" is not available or not a directory');
    return false;
  }
  $hdl = opendir($dir);
  $folder = array ();
  while (false !== ($file = readdir($hdl)))
  {
    $folder[] = $file;
  }

  return $folder;
}

/**
 * Returns the content of the given folder.
 * The content will be filtered with the given $fileprefix
 *
 * @param $dir Path to the folder
 * @param $fileprefix Fileprefix to filter
 * @return Array Filtered-content of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */

function readFilteredFolder($dir, $fileprefix)
{
  $filtered = array ();
  $folder = readFolder($dir);

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if (endsWith($file, $fileprefix))
    {
      $filtered[] = $file;
    }
  }

  return $filtered;
}

/**
 * Returns the files of the given folder
 *
 * @param $dir Path to the folder
 * @return Array Files of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readFolderFiles($dir, $except = array ())
{
  $folder = readFolder($dir);
  $files = array ();

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if (is_file($dir . '/' . $file) && !in_array($file, $except))
    {
      $files[] = $file;
    }
  }

  return $files;
}

/**
 * Returns the subfolders of the given folder
 *
 * @param $dir Path to the folder
 * @param $ignore_dots True if the system-folders "." and ".." should be ignored
 * @return Array Subfolders of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readSubFolders($dir, $ignore_dots = true)
{
  $folder = readFolder($dir);
  $folders = array ();

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if ($ignore_dots && ($file == '.' || $file == '..'))
    {
      continue;
    }
    if (is_dir($dir . '/' . $file))
    {
      $folders[] = $file;
    }
  }

  return $folders;
}

function readFolderStructure($dir, $except = array ())
{
  $result = array ();

  _readFolderStructure($dir, $except, $result);

  uksort($result, 'sortFolderStructure');

  return $result;
}

function _readFolderStructure($dir, $except, & $result)
{
  $files = readFolderFiles($dir, $except);
  $subdirs = readSubFolders($dir);

  if(is_array($subdirs))
  {
    foreach ($subdirs as $key => $subdir)
    {
      if (in_array($subdir, $except))
      {
        unset($subdirs[$key]);
        continue;
      }

      _readFolderStructure($dir .'/'. $subdir, $except, $result);
    }
  }

  $result[$dir] = array_merge($files, $subdirs);

  return $result;
}

function sortFolderStructure($path1, $path2)
{
  return strlen($path1) > strlen($path2) ? 1 : -1;
}

function buildUtf8LangFile($langFile)
{
  $content = '';
  if($hdl = fopen($langFile, 'r'))
  {
    $content = fread($hdl, filesize($langFile));
    fclose($hdl);

    // Charset auf UTF-8 �ndern
    $content = preg_replace('/^htmlcharset = (.*)$/m', 'htmlcharset = utf-8', $content);
  }

  $utf8File = str_replace('.lang', '_utf8.lang', $langFile);
  if($hdl = fopen($utf8File, 'w+'))
  {
    fwrite($hdl, iconv(iconv_get_encoding($content), 'UTF-8', $content));
    fclose($hdl);
  }
}
