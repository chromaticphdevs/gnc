<?php   

class Cookie {

// const DEFAULT_EXPIRY = time() + (86400 * 30);

public static function set($name , $value , $availability = '/'){

  $time = time() + (86400 * 30);
  
  setcookie($name , json_encode($value) , $time , $availability);
}

public static function get($name){

  if(isset($_COOKIE[$name]))
    return json_decode($_COOKIE[$name]);

  return FALSE;
}
}
?>