<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title><?php echo TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
  </head>
  <body>
    <div id="main">
      <div id="menu">
        <?php foreach ($menu_pages as $page => $link): ?>
        <a href="index.php?page=<?php echo $link ?>"><?php echo $page ?></a>
        <?php endforeach ?>
      </div>
      <pre id="content"><?php echo $app ?></pre>
   </div>
  </body>
</html>
