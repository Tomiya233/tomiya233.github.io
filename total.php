<?php
    $files
    = Array();

    //specify the directory
    @$handle = opendir("./files/"); while (
   false !== (@$file = readdir($handle))) {     if (
    $file != "." && $file != "..") {
   $files[] = $file;     }
   }
   @
   closedir($handle);
   $top = count($files);

$total=  $top - 1;
      ?>