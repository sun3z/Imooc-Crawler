<?php 

// $arr = [];


// array_unshift($arr, 1);
// array_unshift($arr, 3);
// array_unshift($arr, 4);
// array_unshift($arr, 5);

// array_pop($arr);



// var_dump($arr);


$logFile = fopen('./App/Log/crawle.log', 'r');
fseek($logFile, -1, SEEK_END);
$s = '';
while(($c = fgetc($logFile)) !== false) 
{
  if($c == "\n" && $s) break;
  $s = $c . $s;
  fseek($logFile, -2, SEEK_CUR);
}
fclose($logFile);
echo $s;