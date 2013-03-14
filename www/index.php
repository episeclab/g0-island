<?php

require_once('src/config.php');
require_once('src/common.php');
require_once('src/ascii.php');
require_once('src/holder.php');
require_once('src/dispatcher.php');
require_once('src/skeleton.php');

Holder::init();

$app = new AsciiMasterWidget(80);
$skeleton = new Skeleton($app);

require_once(Dispatcher::dispatch());
require_once('pages/template.php');
