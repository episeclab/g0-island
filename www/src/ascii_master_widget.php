<?php

// Simply contains a list of sub widgets that need to be rendered
// At that moment, this class doesn't add any graphic stuff
//
// This can be seen as a QtWidget without parent, but to keep
// the code simple, let's separate this two different things.

class				AsciiMasterWidget extends AsciiBaseWidget
{
  private			$width;
  private			$children = array();

  // The only thing that's required here is a width (in characteres)
  // Height will depend of the size of children

  public function		__construct($aWidth)
  {
    $this->width = $aWidth;
  }

  // Returns a string of what we need to render

  public function		__toString()
  {
    $result = '';
    foreach ($this->children as $child)
      {
	$sub_array = $child->render();
	foreach ($sub_array as $line)
	  {
	    $result .= $line . "\n";
	  }
      }
    return $result;
  }

  // Returns current width

  public function		getWidth()
  {
    return $this->width;
  }

  // Let's register a new child

  public function		registerChild(AsciiWidget $aChild)
  {
    $this->children[] = $aChild;
  }

}
