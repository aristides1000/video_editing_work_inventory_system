<?php
  if(extension_loaded('gd') && function_exists('gd_info')) {
      echo "GD está instalado";
      print_r(gd_info());
  } else {
      echo "GD NO está instalado";
  }
?>