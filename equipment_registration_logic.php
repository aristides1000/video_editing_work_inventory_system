<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');
  include_once('./phpqrcode/qrlib.php');

  if(isset($_POST['equipment_category_id']) && $_POST['equipment_category_id']!='' && isset($_POST['type_of_equipment_id']) && $_POST['type_of_equipment_id']!='' && isset($_POST['equipment_status_id']) && $_POST['equipment_status_id']!='' && isset($_FILES['image_path']['name']) && $_FILES['image_path']['name']!='') {
    #llegaron los datos
    $temporal = $_FILES['image_path']['tmp_name'];
    $arch = $_FILES['image_path']['name'];
    $tipo = getimagesize($temporal);

    #El índice 2 del arreglo que genera getimagesize es una bandera que indica el tipo de imagen: 1 = GIF, 2 = JPG, 3 = PNG
    if($tipo[2] != 1 && $tipo[2] != 2 && $tipo[2] != 3) {
      ?>
        <div class="modal fade" id="fileTypeError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error por tipo de archivo</h1>
                <a href="./equipment_registration.php" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Error por tipo de archivo cargado, el archivo debe ser extension: .jpg .png o .gif
              </div>
              <div class="modal-footer">
                <a href="./equipment_registration.php">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const fileTypeError = new bootstrap.Modal(document.getElementById('fileTypeError'));
          fileTypeError.show();
        </script>
      <?php
    } else { # el tipo de archivo es correcto se efectua la carga del producto
      if ($tipo !== false) { # Si la foto ha sido cargada

        $result = mysqli_query($link, "SHOW CREATE TABLE equipments");
        $row = mysqli_fetch_assoc($result);
        $create_table = $row['Create Table'];

        // Extraer el valor AUTO_INCREMENT
        preg_match('/AUTO_INCREMENT=(\d+)/', $create_table, $matches);
        $next_id = $matches[1] ?? null;

        # nombres de las imagenes de los equipos y los qr de los equipos
        $imageExtention = ($tipo[2] == 1) ? '.gif' : (($tipo[2] == 2) ? '.jpg' : '.png');
        $equipmentImageName = 'equipment-image-' . $next_id . $imageExtention;
        $qrEquipmentImageName = 'qr-equipment-image-' . $next_id . '.png';

        $sql_equipments = "INSERT INTO equipments (equipment_category_id, type_of_equipment_id, equipment_status_id, image_path, qr_equipment_image, is_deleted)
          VALUES ('$_POST[equipment_category_id]', '$_POST[type_of_equipment_id]', '$_POST[equipment_status_id]', '". $equipmentImageName ."', '". $qrEquipmentImageName ."', 0);";
        mysqli_query($link, $sql_equipments);

        $sql_warehouses = "INSERT INTO warehouses (equipment_id, in_the_warehouse, type_of_activity_id, activity, responsible_id, verified_by_id, is_deleted)
          VALUES (". intval($next_id) .", 1, 3, 'almacenado', ". $_SESSION['id'] .", ". $_SESSION['id'] .", 0)";

        mysqli_query($link, $sql_warehouses);
        if (mysqli_error($link)) {
          ?>
            <div class="modal fade" id="equipmentRegistrationError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Registrar</h1>
                    <a href="./equipment_registration.php" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    Error en el registro del equipo. Por Favor intente de nuevo.
                  </div>
                  <div class="modal-footer">
                    <a href="./equipment_registration.php">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
            <script>
              const equipmentRegistrationError = new bootstrap.Modal(document.getElementById('equipmentRegistrationError'));
              equipmentRegistrationError.show();
            </script>
          <?php
        } else { # Si no da error la insercion;
          # guardo la imagen del equipo en servidor
          $dir_equipment_image = './equipment_image/';
          if (!file_exists($dir_equipment_image)) mkdir($dir_equipment_image);
          $equipmentImagePath = $dir_equipment_image . $equipmentImageName;
          copy($_FILES['image_path']['tmp_name'], $equipmentImagePath);

          # creo y guardo el qr del equipo en servidor
          $dir_qr_image = './qr_equipment_image/';
          if (!file_exists($dir_qr_image)) mkdir($dir_qr_image);
          $qrEquipmentImagePath = $dir_qr_image . $qrEquipmentImageName; # donde lo va a guardar y con cual nombre
          $size = 5; # tamanio de la imagen
          $level = 'M'; # Precision del qr, puede ser ()
          $frameSize = 2; # el padding blanco del qr
          $content = SERVER_HOSTNAME . '/video_editing_work_inventory_system/view_equipment.php?id=' . intval($next_id); # es lo que va a monstrar nuestro codigo qr

          #generamos el qr con la siguiente clase:
          QRcode::png($content, $qrEquipmentImagePath, $level, $size, $frameSize);
          ?>
            <div class="modal fade" id="successfulEquipmentRegistration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro Exitoso</h1>
                    <a href="./equipment_registration.php" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    Equipo registrado exitosamente.
                  </div>
                  <div class="modal-footer">
                    <a href="./equipment_registration.php">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
            <script>
              const successfulEquipmentRegistration = new bootstrap.Modal(document.getElementById('successfulEquipmentRegistration'));
              successfulEquipmentRegistration.show();
            </script>
          <?php
        }
      } else { # La foto NO ha sido cargada
        ?>
          <script> alert("Error en la carga de la foto. Intente de nuevo"); </script>
          <meta http-equiv="refresh" content="2;URL=./producto.php" />
        <?php

        /* Modificar hasta lo interno de este else */
      }
    }
  } else {
    ?>
      <div class="modal fade" id="missingData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Faltan Datos</h1>
              <a href="./equipment_registration.php" class="ms-auto">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </a>
            </div>
            <div class="modal-body">
              Por favor ingrese toda la informacion solicitada
            </div>
            <div class="modal-footer">
              <a href="./equipment_registration.php">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </a>
            </div>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
      <script>
        const missingData = new bootstrap.Modal(document.getElementById('missingData'));
        missingData.show();
      </script>
    <?php
  }

  include_once('./includes/footer.php');
?>
