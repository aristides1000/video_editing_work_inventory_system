<?php
  $link = mysqli_connect('localhost','root','','video_inventory_system_TEST');

  if (!$link) {
    die('Error de Conexión: (' . mysqli_connect_errno() . ') '
      . mysqli_connect_error());
  }
?>