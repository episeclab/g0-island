<?php

function page_404(&$skeleton)
{
  $content = new Content($skeleton);
  $content->setText("page not found :'(");  
  $skeleton->addWidget($content);
}

if (!isset($skeleton))
  Common::goToHell();

page_404($skeleton);
