<?php

function page_sujet($skeleton)
{
  new_chapter('0x00 - Preambule', 'data/preambule.txt', $skeleton);
  new_chapter('0x01 - Introduction', 'data/introduction.txt', $skeleton);
  new_chapter('0x02 - Le chateau', 'data/chateau.txt', $skeleton);
  new_chapter('0x03 - Le m1ch3l4ng', 'data/lang.txt', $skeleton);
  new_chapter('0x04 - Le repaire des aventuriers', 'data/repaire.txt', $skeleton);
}

if (!isset($skeleton))
  Common::goToHell();

page_sujet($skeleton);
