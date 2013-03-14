<?php

require_once('src/config.php');
require_once('src/common.php');
require_once('src/ascii.php');
require_once('src/skeleton.php');

$app = new AsciiMasterWidget(80);
$skeleton = new Skeleton($app);

require_once('pages/sujet.php');

$lines = $skeleton->render();

foreach ($lines as $line)
  echo $line . "\n";
