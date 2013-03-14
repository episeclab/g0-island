<?php

require_once('ascii_base_widget.php');
require_once('ascii_widget.php');
require_once('ascii_master_widget.php');
require_once('ascii_widget_text.php');
require_once('ascii_widget_file.php');
require_once('ascii_widget_vertical.php');

class				Ascii
{

  // Generates a string composed of N times $aPattern + a random number of
  // characteres from $aPattern so that strlen($result) == $aSize

  public static function	generatePattern($aPattern, $aSize)
  {
    $len = self::getStrippedSize($aPattern);
    $result = '';
    for ($i = 0; ($i + $len) <= $aSize; $i += $len)
      {
	$result .= $aPattern;
      }
    return $result;
  }

  // Returns the length of a string stripping html tags

  public static function	getStrippedSize($content)
  {
    return strlen(strip_tags(utf8_decode($content)));
  }

}
