<?php
  require __DIR__ . "/config.php";

  $link = mysqli_connect(DATABASE_HOSTNAME,
                          DATABASE_USERNAME,
                          DATABASE_PASSWORD,
                          DATABASE_NAME);

  if (!$link) {
    die('Error de Conexión: (' . mysqli_connect_errno() . ') '
      . mysqli_connect_error());
  }
?>