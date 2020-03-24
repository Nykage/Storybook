<?php
class Route{

  private static $routes = Array(); //pysyvät reitit, eivät sidottu olioon
  private static $pathNotFound = null; //polkuvirhe, ei sidottu olioon, oletusarvo : ei ole
  private static $methodNotAllowed = null;//metodivirhe oletusarvo : ei ole

  //metodilla lisätään reitti reittitaulukkoon, expression on polun se osa, joka näkyy, function on se, mitä tehdään ja method on pyynnön method (post tai get) - taulukon kuva??
  
  public static function add($expression, $function, $method = 'get'){
    array_push(self::$routes,Array(
      'expression' => $expression,
      'function' => $function,
      'method' => $method
    ));
  }

  //virhemetodi (polkua ei löydy)
  public static function pathNotFound($function){
    self::$pathNotFound = $function;
  }

  //virhemetodi
  public static function methodNotAllowed($function){
    self::$methodNotAllowed = $function;
  }

  //korjaa pyynnön URL:n sopivaan muotoon - poistaa kenot ja poimii pyynnöstä URL:n
  // jos muunnettu polku on olemassa, polku on se
  // tekee saman pyynnön method-osalle
  // muuten polku on '/'
  // suorittaa annetun polun
  
  
  public static function run($basepath = '/'){

    // Parse current url
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

    if(isset($parsed_url['path'])){
      $path = $parsed_url['path'];
    }else{
      $path = '/';
    }

    // Get current request method
    $method = $_SERVER['REQUEST_METHOD'];
    $path_match_found = false; 
    $route_match_found = false;

    //käy läpi reittitaulukon
    foreach(self::$routes as $route){

      //jos metodi on ok (eikä esim. tyhjä tai keno eli juuri)
      // Add basepath to matching string
      // annetaan taulukon pyynnön osalle nimi - tämän lähetetään 

      if($basepath!=''&&$basepath!='/'){
        $route['expression'] = '('.$basepath.')'.$route['expression'];
      }

      // Add 'find string start' automatically - lisää haun, jolla määritetään merkkijonon alkukohta ^eli hattu toimii ns.wildcardina
      $route['expression'] = '^'.$route['expression'];

      // Add 'find string end' automatically määrittää merkkijonon loppukohdan
      $route['expression'] = $route['expression'].'$';

      // echo $route['expression'].'<br/>';

      // Check path match    - löytyykö samaa polkua
      if(preg_match('#'.$route['expression'].'#',$path,$matches)){

        $path_match_found = true;

        // Check method match
        if(strtolower($method) == strtolower($route['method'])){

          array_shift($matches);// Always remove first element. This contains the whole string

          if($basepath!=''&&$basepath!='/'){
            array_shift($matches);// Remove basepath
          }

          call_user_func_array($route['function'], $matches);

          $route_match_found = true;

          // Do not check other routes
          break;
        }
      }
    }

    // No matching route was found
    if(!$route_match_found){

      // But a matching path exists
      if($path_match_found){
        header("HTTP/1.0 405 Method Not Allowed");
        if(self::$methodNotAllowed){
          call_user_func_array(self::$methodNotAllowed, Array($path,$method));
        }
      }else{
        header("HTTP/1.0 404 Not Found");
        if(self::$pathNotFound){
          call_user_func_array(self::$pathNotFound, Array($path));
        }
      }

    }

  }

}
?>