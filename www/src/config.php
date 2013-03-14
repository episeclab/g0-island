<?php

// -- enable/disable debugs
define('DEVEL', true);

// -- root
define('ROOT_URI', '');

// -- admin to contact
define('ADMIN', 'island@sec-l.org');

// -- ini file which stores routing rules
define('ROUTING', 'routing.ini');

// -- width of the template (in characteres)
define('WIDTH', 240);

// -- title of the page
define('TITLE', "m1ch3l's Island - the r3p41r3");

// -- menu pages
$menu_pages = array('ma1s0n' => 'home',
                    'suj3t' => 'subject',
                    'r4nk1ng' => 'stats',
                    'st4tus' => 'status');

// --
error_reporting(DEVEL ? E_ALL : E_NONE);
