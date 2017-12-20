<?php

function code62($x) {
    $show = '';
    while($x > 0) {
        $s = $x % 62;
        if ($s > 35) {
            $s = chr($s+61);
        } elseif ($s > 9 && $s <=35) {
            $s = chr($s + 55);
        }
        $show .= $s;
        $x = floor($x/62);
    }
    return $show;
}

function shorturl($url) {
    $url = crc32($url);
    $result = sprintf("%u", $url);
    return code62($result);
}

function dwz($url){  
      $code = floatval(sprintf('%u', crc32($url)));  
      $surl = '';  
      while($code){  
          $mod = fmod($code, 62);  
          if($mod>9 && $mod<=35){  
              $mod = chr($mod + 55);  
          }elseif($mod>35){  
              $mod = chr($mod + 61);  
          }  
          $surl .= $mod;  
          $code = floor($code/62);  
      }  
      return $surl;  
  } 