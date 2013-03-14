<?php

// Base class TextWidgets

class			AsciiWidgetText extends AsciiWidget
{
  private		$text;
  private		$uppercase = false;
  private		$bbcode;

  public function	__construct(AsciiBaseWidget $parent)
  {
    parent::__construct($parent);
  }

  public function	setText($aText)
  {
    $this->text .= $aText;
  }

  public function	setUpperCase()
  {
    $this->uppercase = true;
  }

  public function	render()
  {
    $result = array();
    $tmp = explode("\n\n", $this->text);
    $width = $this->getWidth();

    $lines = array();
    foreach ($tmp as $line)
      {
        // if the line starts with a space, treat it as indented
        if ($line[0] == " ") {
          $lines = array_merge($lines, explode("\n", $line));
          $lines[] = "";
        }
        // otherwise, cut it nicely
        else
          {
            $line = str_replace("\n", " ", $line);
            $words = explode(" ", $line);
            $current_line = "";
            foreach ($words as $word)
              {
                $word .= " ";
                if ((strlen($current_line) + strlen($word)) > $width)
                  {
                    $lines[] = $current_line;
                    $current_line = "";
                  }
                $current_line .= $word;
              }
            if (strlen($current_line) > 0)
              $lines[] = $current_line;
            $lines[] .= "";
          }
      }

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
