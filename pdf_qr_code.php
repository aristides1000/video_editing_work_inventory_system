<?php
  session_start();
  include 'conexion.php';
  ?>
    <span style="display: flex; align-items: center; flex-wrap: wrap;">
  <?php
  for ($i = 1; $i < 501; $i++) {
    ?>
      <span style="display: flex; align-items: center; border: 3px black solid;">
        <img alt="qr-equipment-image-<?php echo $i ?>.png" src="<?php echo SERVER_HOSTNAME ?>/video_editing_work_inventory_system/qr_equipment_image/qr-equipment-image-<?php echo $i ?>.png" width="75" style="padding: 3px 0 3px 3px;">
        <span style="padding: 1rem; font-size: 1.7rem;"><?php echo $i ?></span>
      </span>
    <?php
  }
  ?>
    </span>
  <?php
?>