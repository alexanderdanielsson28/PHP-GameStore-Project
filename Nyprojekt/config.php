<?php
$link=mysql_connect('nalaka.se.mysql', 'nalaka_se', 'blommprinsen28'); //connect string,tolkar utf8
mysql_select_db('nalaka_se', $link);mysql_set_charset('utf8',$link);
if (!$link) {
    die('Could not connect: ' . mysql_error());

  
}
  $images_dir = "photos";
?>