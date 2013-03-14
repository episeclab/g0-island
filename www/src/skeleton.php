<?php

class			Title extends AsciiWidgetFile
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);
    $this->paddings['left'] = 3;
    $this->paddings['right'] = 3;
    $this->paddings['top'] = 1;
    $this->paddings['bottom'] = 1;
    $this->setFile("art/banner");
  }
}

class			Content extends AsciiWidgetText
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);

    $this->borders['left'] = '+';
    $this->borders['right'] = '+';
    $this->borders['bottom'] = '-';
    $this->borders['top'] = '-';

    $this->paddings['top'] = 1;
    $this->paddings['bottom'] = 1;
    $this->paddings['left'] = 2;
    $this->paddings['right'] = 2;

    $this->margins['top'] = 1;
    $this->margins['bottom'] = 1;
    $this->margins['left'] = 2;
    $this->margins['right'] = 2;
  }
}

class			TextContent extends AsciiWidgetText
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);

    $this->paddings['left'] = 1;
    $this->margins['left'] = 1;    
  }
}

class			Item extends AsciiWidgetText
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);

    $this->paddings['left'] = 1;
    $this->margins['left'] = 1;
  }
}

class			ItemList extends AsciiWidgetText
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);

    $this->paddings['left'] = 1;
    $this->margins['left'] = 1;
    $this->paddings['right'] = 1;
    $this->margins['right'] = 1;
    $this->margins['bottom'] = 1;
  }

  public function	setText($aText)
  {
    parent::setText("- $aText");
  }
}

class			Skeleton extends AsciiVerticalWidget
{
  public function	__construct(AsciiBaseWidget & $aParent)
  {
    parent::__construct($aParent);
    $aParent->registerChild($this);
    $this->borders['left'] = '|';
    $this->borders['right'] = '|';
    $this->borders['top'] = '|';
    $this->borders['bottom'] = '|';
    $this->addWidget(new Title($this));
  }
}

function new_chapter($title, $file, $skeleton)
{
  $content = new Content($skeleton);
  $item = new Item($skeleton);
  $item->setUpperCase();
  $item->setText($title);
  $content->setText(file_get_contents($file));
  $skeleton->addWidget($item);
  $skeleton->addWidget($content);
}
