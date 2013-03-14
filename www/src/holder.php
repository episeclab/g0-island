<?php

// This class is a kind of garbage where you can put everything you want!
// This is also the place where GET/POST query are stored

class Holder
{
  private static $holder = array();

  // let's store get request (no need of post or anything else at that moment)
  // if the key already exists, we don't erase it and we should NEVER (for security reasons)

  public static function init()
  {
    global $_GET;

    foreach ($_GET as $key => $value)
      {
        if (isset(self::$holder[$key]) === false)
          {
            self::$holder[$key] = $value;
          }
      }
  }

  public static function set($aKey, $aValue)
  {
    self::$holder[$aKey] = $aValue;
  }

  // simply returns the associated value

  public static function get($aKey, $default = false)
  {
    return isset(self::$holder[$aKey]) ? self::$holder[$aKey] : $default;
  }

}

