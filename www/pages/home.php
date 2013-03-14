<?php

function page_home($skeleton)
{
  $content = new Content($skeleton);

  $text = <<<EOT
Le Tao donna naissance au Un. Le Un donna naissance au Deux. Le Deux
donna naissance au Trois. Le Trois donna naissance à toute la
création. De cette création émergea un maître, qui leur péta tous
la gueule.

Personne ne sait ce que devint le maître... 
EOT;
  $content->setText($text);
  $skeleton->addWidget($content);
}

if (!isset($skeleton))
  Common::goToHell();

page_home($skeleton);
