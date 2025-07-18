<?php

  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');
  include_once('./phpqrcode/qrlib.php');

  $dir_qr_image = './qr_equipment_image/';
  $size = 5; # tamanio de la imagen
  $level = 'M'; # Precision del qr, puede ser ()
  $frameSize = 2; # el padding blanco del qr

  for ($i = 1; $i < 10; $i++) {
    $qrEquipmentImageName = 'qr-equipment-image-' . $i . '.png';
    $content = SERVER_HOSTNAME . '/video_editing_work_inventory_system/view_equipment.php?id=' . $i; # es lo que va a monstrar nuestro codigo qr
    $qrEquipmentImagePath = $dir_qr_image . $qrEquipmentImageName; # donde lo va a guardar y con cual nombre

    #generamos el qr con la siguiente clase:
    QRcode::png($content, $qrEquipmentImagePath, $level, $size, $frameSize);
  }
?>