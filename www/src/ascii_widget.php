<?php

// Base class for everything you want to display

abstract class			AsciiWidget extends AsciiBaseWidget
{
  abstract public function	render();

  protected			$borders = array('top'		=> '',	// bottom = top = '-', left = right = '|' will give:
						 'left'		=> '',  // ------------------
						 'right'	=> '',  // |Widget's content|
						 'bottom'	=> ''); // ------------------

  protected			$margins = array('top'		=> 0,	// bottom = top = 0, left = 5, right = 0 will give:
						 'left'		=> 0,   //      ------------------
						 'right'	=> 0,   //      |Widget's content|
						 'bottom'	=> 0);  //      ------------------

  protected			$paddings = array('top'		=> 0,	// bottom = top = 0, left = 1, right = 3 will give:
						  'left'	=> 0,   // -----------------
						  'right'	=> 0,   // | Widget's co   |
						  'bottom'	=> 0);  // -----------------

  private			$parent;				// Widgets always have one parent (AsciiWidget or AsciiMasterWidget)

  // Constructor, you can't construct an AsciiWidget without a parent
  // which can either a AsciiWidget subclass or a AsciiMasterWidget

  public function		__construct(AsciiBaseWidget $aParent)
  {
    $this->parent = $aParent;
  }

  // Returns internal width of the widget (what it can actually contain)
  // Example:
  //
  // Current widget has: left/right padding of 1
  //			 left/right margin of 1
  //  
  //  -------------
  //  |           |
  //  | {content} |
  //  |           |
  //  -------------
  //
  // getWidth() will return the width the content can feet in

  public function		getWidth()
  {
    $parentWidth = $this->parent->getWidth();

    $addedWidth = 0;
    $addedWidth += Ascii::getStrippedSize($this->borders['left']);
    $addedWidth += Ascii::getStrippedSize($this->borders['right']);
    $addedWidth += $this->margins['left'];
    $addedWidth += $this->margins['right'];
    $addedWidth += $this->paddings['left'];
    $addedWidth += $this->paddings['right'];

    return $parentWidth - $addedWidth;
  }

  public function		setBorders($array)
  {
    $this->borders = array_merge($this->borders, $array);
  }

  public function		setMargins($array)
  {
    $this->margins = array_merge($this->margins, $array);
  }

  public function		setPaddings($array)
  {
    $this->paddings = array_merge($this->paddings, $array);    
  }

  // Okay, this is tricky, ugly, whatever you want, but I haven't found any better solution.
  // Here is the problem: we can have html tags in content which is several lines long.
  // The content may be wrapped by borders or another AsciiWidget, so we need to find a way to
  // cancel effects of tags at the end of each line, and re-enable it later:
  //
  // <b> Hejla, kako
  // si?</b>
  //
  // Is replaced by:
  //
  // <b> Hejla, kako</b>
  // <b>si?</b>
  //
  // It also handles more sophisticated forms :
  //
  // <b> Hello<b><b></b>
  // world </b> !
  // :)</b>
  // </b>
  // 
  
  private function		cleanMultilineTags(&$content)
  {
    $cancelled_tags = '';
    $opening_tags = array();
    $all_matches = array();

    if (preg_match_all("#<(\w+)(?: \w+=\"[^\"]+\")*>#i", $content, $all_matches, PREG_SET_ORDER))
      {
	foreach ($all_matches as $matches)
	  {
	    if (!isset($opening_tags[$matches[1]]))
	      {
		$opening_tags[$matches[1]] = array('count' => 0,
						   'stack' => array());
	      }
	    $opening_tags[$matches[1]]['count']++;
	    $opening_tags[$matches[1]]['stack'][] = $matches[0];
	  }
      }

    foreach ($opening_tags as $name => $tag)
      {
	$closing_tag = '</' . $name . '>';
	$closing_tag_number = substr_count($content, $closing_tag);
	for ($i = $closing_tag_number; $i < $tag['count']; ++$i)
	  {
	    $content .= $closing_tag;
	    $cancelled_tags .= $tag['stack'][$tag['count'] - $i - 1];
	  }
      }

    return $cancelled_tags;
  }

  // Let's render a $line
  // Content is the line to be rendered
  // Content_width is the maximum displayed length of the content
  // Prefix is what we need to add at beginning of the next line to be rendered
  // Previous is the previous value of prefix, used to add additionnal opening tags at start

  private function		renderLine($content, $content_width, &$prefix, $previous = '')
  {
    $left = '';
    $right = '';
    $middle = '';
    
    $left .= Ascii::generatePattern(' ', $this->margins['left']);
    $left .= $this->borders['left'];
    $left .= Ascii::generatePattern(' ', $this->paddings['left']);

    $right .= Ascii::generatePattern(' ', $this->paddings['right']);
    $right .= $this->borders['right'];
    $right .= Ascii::generatePattern(' ', $this->margins['right']);

    $content = $previous . $content;
    $spaces = Ascii::generatePattern(' ', $content_width - (Ascii::getStrippedSize($content)));
    $content .= $spaces;
    $prefix = $this->cleanMultilineTags($content);
    $middle .= $content;

    return $left . $middle . $right;
  }

  public function		drawBorder($aPattern, $parent_width)
  {
    $left = '';
    $right = '';
    $middle = '';
    
    $left .= Ascii::generatePattern(' ', $this->margins['left']);
    $left .= $this->borders['left'];

    $right .= $this->borders['right'];
    $right .= Ascii::generatePattern(' ', $this->margins['right']);

    $middle .= Ascii::generatePattern($aPattern, $parent_width - Ascii::getStrippedSize($right) - Ascii::getStrippedSize($left));

    return $left . $middle . $right;
  }

  // Returns an array representing each line
  // What we take as parameter is a pre-formatted array, we only need
  // to wrap it with padding, border, and margin
  //
  // This method assumes the array is already splitted and has a correct size
  // If it's not the case, lines may be truncated

  public function		renderContent($aArray)
  {
    $result = array();
    $parent_width = $this->parent->getWidth();
    $content_width = $this->getWidth();

    $prefix = '';

    // Top
    for ($i = 0; $i < $this->margins['top']; ++$i)	$result[] = Ascii::generatePattern(' ', $parent_width);
    if (Ascii::getStrippedSize($this->borders['top']))	$result[] = $this->drawBorder($this->borders['top'], $parent_width);
    for ($i = 0; $i < $this->paddings['top']; ++$i)	$result[] = $this->renderLine("", $content_width, $prefix);

    $prefix = '';
    $backup = '';

    // Content
    foreach ($aArray as $line)
      {
	$result[] = $this->renderLine($line, $content_width, $prefix, $backup);
	$backup = $prefix;
      }

    // Bottom
    for ($i = 0; $i < $this->paddings['bottom']; ++$i)		$result[] = $this->renderLine("", $content_width, $prefix);
    if (Ascii::getStrippedSize($this->borders['bottom']))	$result[] = $this->drawBorder($this->borders['bottom'], $parent_width);
    for ($i = 0; $i < $this->margins['bottom']; ++$i)		$result[] = Ascii::generatePattern(' ', $parent_width);

    return $result;
  }

}
