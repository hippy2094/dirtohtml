<?php
  function getFiles($order) {
    $files = array();
    $c = 0;
    $dp = opendir(".");
    while(($file = readdir($dp)) !== false) {
      if((is_file($file)) && (substr($file,0,1) != ".") && ($file != basename($_SERVER['PHP_SELF']))) {
        $files[$c]['name'] = $file;

        if(round((filesize($file) / 1024) / 1024,2) < 1) {
          $files[$c]['size'] = round(filesize($file) / 1024,2);
          $files[$c]['size'] .= "Kb";
        }
        else {
          $files[$c]['size'] = round((filesize($file) / 1024) / 1024,2);
          $files[$c]['size'] .= "Mb";
        }

        $files[$c]['date'] = filectime($file);
        $c++;
      }
    }
    // TODO: Sorting
    if($order == "filename") {
      usort($files, "sort_filename");
    }
    return $files;
  }

  function getFileType($file,$imgpath) {
    global $fileTypes;
    $f = strtolower($file);
    // If no file extension show empty icon
    if(strrpos($f,".") === false) $i = "$imgpath/empty.png";
    else {
      // Get file extension
      $ext = substr($f,strrpos($f,".")+1,strlen($f)-strrpos($f,"."));
      // Check the fileTypes array for a sub
      foreach($fileTypes as $type => $sub) {
        if($type == $ext) {
          $ext = $sub;
          break;
        }
      }
      // Check the icon file exists, if not replace with empty
      if(!file_exists("$imgpath/$ext.png")) $i = "$imgpath/empty.png";
      else $i = "$imgpath/$ext.png";
    }
    return $i;
  }

  function sort_filename($a,$b) {
    return $a['name']>$b['name'];
  }
?>
