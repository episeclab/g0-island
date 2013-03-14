<?php

// Here we can peacely define some functions that will be used everywhere

class Common
{

  // Okay something bad went wrong, let's stop the fan before shit arrives in it.
  // Prints a diagnostic (or not) before dying
  public static function fatalError($aMessage = false)
  {
    if ($aMessage !== false && true === DEVEL)
      {
        printf("Fatal error: %s\n", $aMessage);
        die();
      }
    printf("Ooops, something went wrong :( Feel free to wake up %s\n", ADMIN);
    die();
  }

  // This is called when the user tries to make something wrong
  public static function goToHell()
  {
    header('location: index.php');
    exit;
  }

  // Generates an URL
  public static function urlFor($action, $get = array())
  {
    $url = "index.php?page=" . $action;

    foreach ($get as $key => $value)
      {
        $url .= "&amp;" . urlencode($key) . "=" . urlencode($value);
      }

    return $url;
  }

  // Generates a string with a prefixed ending
  public static function stripString($str, $size, $suffix = "...")
  {
    $suffix_len = strlen($suffix);
    $len = $size - $suffix_len;

    if ($len > 0 && strlen($str) > $len)
      {
        $str = substr($str, 0, $len) . $suffix;
      }

    return $str;
  }

}