<?php

class Dispatcher
{
  // Includes the appropriated controller according to the request
  public static function dispatch()
  {
    $rules = parse_ini_file(ROUTING, true) or Common::fatalError('unable to open routing ini file.');
    foreach ($rules as $name => $route) {
      if (Holder::get('page') === $name)
        return $route['controller'];
    }
    return Holder::get('page') === false ? "pages/home.php" : "pages/404.php";
  }
}
