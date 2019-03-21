<?php
ini_set('dislay_errors', 'on');
error_reporting(E_ALL);

class MyAutoLoad
{
  public static function start()
  {
    session_start();
    spl_autoload_register(array(__CLASS__, 'autoload'));

    $root = $_SERVER['DOCUMENT_ROOT'];
    $host = $_SERVER['HTTP_HOST'];

    define("HOST", 'http://' . $host .'/');
    define("ROOT", $root. '/');

    define("CONTROLLER", ROOT . 'controller/');
    define("MODEL", ROOT . 'model/');
    define("WEB", HOST . 'web/');
    define("CLASSES", ROOT .'classes/');
  }

  public static function autoload($class) 
  {
    if (file_exists(MODEL.$class.'.php')) 
    {
      include_once(MODEL.$class.'.php');
    }
    elseif (file_exists(CLASSES.$class.'.php')) 
    {
      include_once(CLASSES.$class.'.php');
    }
    elseif (file_exists(CONTROLLER.$class.'.php')) 
    {
      include_once(CONTROLLER.$class.'.php');
    }
  }
}