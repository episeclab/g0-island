<?php

class			AsciiWidgetFile extends AsciiWidget
{
  private		$text;
  private		$uppercase = false;
  private		$bbcode;


  public function	__construct(AsciiBaseWidget $parent)
  {
    parent::__construct($parent);
  }

  public function	setFile($aFile)
  {
    $this->text .= file_get_contents($aFile);
  }

  public function	setUpperCase()
  {
    $this->uppercase = true;
  }

  public function	render()
  {
    $result = array();
    $lines = explode("\n", $this->text);
    $width = $this->getWidth();

    $i = 0;
    $max = count($lines);

    foreach ($lines as $line)
      {
        ++$i;
	if ($this->uppercase)
          $line = strtoupper($line);
        if ($i != $max || strlen($line) > 0) {
          $result[] = $line;
        }
      }

    return parent::renderContent($result);
  }
}
