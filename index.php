<?php
  /* Dynamic Directory To HTML script v0.3
     By Matthew Hipkin, visit http://www.matthewhipkin.co.uk for more information

     CHECK .dirtohtml/config.inc.php FILE FOR CONFIGURATION OPTIONS */

  /* VERSION HISTORY

     2015-06-12 - 0.3 - Added column sort
                      - Set units on filesize
     2012-05-16 - 0.2 - Modified title tag to use $_SERVER['HTTP_HOST']
     2009-05-28 - 0.1 - First version
  */

  include(".dirtohtml/config.inc.php");
  include(".dirtohtml/funcs.inc.php");
?>
<html>
<head>
<style type="text/css">
  body { background-color: <?php echo $config['bgcolour']; ?>; }
  th { text-align: left; }
  body,td,th { color: <?php echo $config['textcolour']; ?>;
               font-family: <?php echo $config['font']; ?>;
               font-size: <?php echo $config['fontsize']; ?>;
  }
  a { color: <?php echo $config['linkcolour']; ?>; }
  table { width: <?php echo $config['width']; ?>;
          border-top: <?php echo $config['bordercolour']." ".$config['borderwidth']; ?>;
          border-left: <?php echo $config['bordercolour']." ".$config['borderwidth']; ?>;
          border-right: <?php echo $config['bordercolour']." ".$config['borderwidth']; ?>; }
  .bborder { border-bottom: <?php echo $config['bordercolour']." ".$config['borderwidth']; ?> }
</style>
<title>Directory listing for http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?></title>
<body>
<center>
<table cellpadding="0" cellspacing="0">
<?php
  // To make the heading match the height of the content rows, we'll get the height of one of the images
  $info = getimagesize($config['imgpath']."/empty.png");
  $h = $info[1];
?>
<tr style="height: <?php echo $h; ?>; background-color: <?php echo $config['headcolour']; ?>"><th style="width: 1px" class="bborder">&nbsp;</th><th class="bborder">Filename</th><th class="bborder">Filesize</th><th class="bborder">Date</th></tr>
<?php
  // Retrieve file list
  $fileList = getFiles($config['order']);
  $switch = true;
  // Display files
  for($x=0;$x<count($fileList);$x++) {
    // Check to see if we need to alternate row colours
    if($config['cellbg2'] != "") {
      if($switch) $bgcol = $config['cellbg'];
      else $bgcol = $config['cellbg2'];
      $switch = !$switch;
    }
    else $bgcol = $config['cellbg'];
    echo "<tr style=\"background-color: $bgcol\">";
    // Display file icon
    echo "<td class=\"bborder\"><img src=\"".getFileType($fileList[$x]['name'],$config['imgpath'])."\"></td>";
    // File name (with href)
    echo "<td class=\"bborder\"><a href=\"".$fileList[$x]['name']."\">".$fileList[$x]['name']."</a></td>";
    // File size
    echo "<td class=\"bborder\">".$fileList[$x]['size']."</td>";
    // Date
    echo "<td class=\"bborder\">".date($config['date'],$fileList[$x]['date'])."</td>";
    echo "</tr>\n";
  }
?>
</table>
</center>
</body>
</html>