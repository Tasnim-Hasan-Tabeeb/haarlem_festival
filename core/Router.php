<?php
namespace Core;

//Routing logic
class Router{
  private static $nomatch = true;
  private static function getUrl(){
    $uri = $_SERVER['REQUEST_URI'];
    $uri = parse_url($uri, PHP_URL_PATH);
    $base = '/haarlem_fest';
    if (strpos($uri, $base) === 0) {
        $uri = substr($uri, strlen($base));
    }
     return '/' . ltrim($uri, '/');
  }

  private static function getMatches($pattern){
    $uri = self::getUrl();

    if(preg_match($pattern, $uri, $matches)){
      return $matches;
    }
    return false;

  }

  private static function process($pattern, $callback){
    $pattern = "~^{$pattern}/?$~";
    $params = self::getMatches($pattern);

    if($params){
      self::$nomatch = false;
      $functionArguments = array_slice($params, 1);
      if (is_array($callback) && count($callback) === 2) {
        $className = $callback[0];
        $methodName = $callback[1];
        $instance = $className::getInstance();
        $instance->$methodName(...$functionArguments);
        return;
      }

      if (is_callable($callback)) {
        $callback(...$functionArguments);
        return;
      }
      if (is_string($callback) && strpos($callback, '@') !== false) {
        [$className, $methodName] = explode('@', $callback, 2);
        $instance = $className::getInstance();
        $instance->$methodName(...$functionArguments);
        return;
      }
    }
  }


  static function get($pattern, $callback){

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
      return;
    }
    self::process($pattern, $callback);
  }

  static function post($pattern, $callback){
     if($_SERVER['REQUEST_METHOD'] != 'POST'){
      return;
    }

    self::process($pattern, $callback);

  }

  static function delete($pattern, $callback){
     if($_SERVER['REQUEST_METHOD'] != 'DELETE'){
      return;
    }
    
    self::process($pattern, $callback);
  }

  static function cleanUp(){
    if(self::$nomatch){
        http_response_code(404);
        echo "404 Not Found";
    }
  }

}