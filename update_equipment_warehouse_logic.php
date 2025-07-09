<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_POST['id_equipment']) && $_POST['id_equipment']!='' && isset($_POST['equipment_category_id']) && $_POST['equipment_category_id']!='' && isset($_POST['type_of_equipment_id']) && $_POST['type_of_equipment_id']!='' && isset($_POST['equipment_status_id']) && $_POST['equipment_status_id']!='' && isset($_POST['equipment_is_deleted']) && $_POST['equipment_is_deleted']!='' && isset($_POST['warehouse_id']) && $_POST['warehouse_id']!='' && isset($_POST['in_the_warehouse']) && $_POST['in_the_warehouse']!='' && isset($_POST['type_of_activity_id']) && $_POST['type_of_activity_id']!='' && isset($_POST['activity']) && $_POST['activity']!='' && isset($_POST['responsible_id']) && $_POST['responsible_id']!='' && isset($_POST['verified_by_id']) && $_POST['verified_by_id']!='' && isset($_POST['warehouse_is_deleted']) && $_POST['warehouse_is_deleted']!='') { # Si enviaron todos los campos del formulario excepto el del campo de imagenes
    # Verificar que la informacion recibida en el formulario no sea completamente la misma que la del equipo a modificar
    $sqlEquipmentSelected = "SELECT
                              e.id AS id_equipment,
                              e.equipment_category_id,
                              e.type_of_equipment_id,
                              e.equipment_status_id,
                              e.is_deleted AS equipment_is_deleted,
                              w.id AS warehouse_id,
                              w.in_the_warehouse,
                              w.type_of_activity_id,
                              w.activity,
                              w.responsible_id,
                              w.verified_by_id,
                              w.is_deleted AS warehouse_is_deleted
                            FROM equipments e
                            JOIN warehouses w ON e.id = w.equipment_id
                            LEFT JOIN
                              warehouses w2 ON w.equipment_id = w2.equipment_id
                              AND w.date < w2.date
                              AND w2.is_deleted = 0
                            WHERE
                              e.id = ". $_POST['id_equipment'] ."
                              AND w2.id IS NULL;";
    $queryEquipmentSelected = mysqli_query($link, $sqlEquipmentSelected);
    while($row = mysqli_fetch_array($queryEquipmentSelected, MYSQLI_ASSOC)) {
      if ($_POST['id_equipment'] == $row['id_equipment'] && $_POST['equipment_category_id'] == $row['equipment_category_id'] && $_POST['type_of_equipment_id'] == $row['type_of_equipment_id'] && $_POST['equipment_status_id'] == $row['equipment_status_id'] && $_POST['equipment_is_deleted'] == $row['equipment_is_deleted'] && $_POST['warehouse_id'] == $row['warehouse_id'] && $_POST['in_the_warehouse'] == $row['in_the_warehouse'] && $_POST['type_of_activity_id'] == $row['type_of_activity_id'] && $_POST['activity'] == $row['activity'] && $_POST['responsible_id'] == $row['responsible_id'] && $_POST['verified_by_id'] == $row['verified_by_id'] && $_POST['warehouse_is_deleted'] == $row['warehouse_is_deleted'] && $_FILES["image_path"]["error"] == 4) {
        /* El $_FILES["image_path"]["error"] == 4 lo que nos dice es que el archivo no fue subido a la plataforma */
        ?>
          <div class="modal fade" id="sameData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos enviados iguales a los de la base de datos</h1>
                  <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </a>
                </div>
                <div class="modal-body">
                  Los Datos ingresados son iguales a los datos provenientes del equipo, por favor ingrese la informacion que desea cambiar del equipo
                </div>
                <div class="modal-footer">
                  <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
          <script>
            const sameData = new bootstrap.Modal(document.getElementById('sameData'));
            sameData.show();
          </script>
        <?php
        return 0;
      } else {
        # Actualizar los queries
        $sql_equipments = "UPDATE equipments
                            SET
                              equipment_category_id = $_POST[equipment_category_id],
                              type_of_equipment_id = $_POST[type_of_equipment_id],
                              equipment_status_id = $_POST[equipment_status_id],
                              is_deleted = $_POST[equipment_is_deleted]
                            WHERE
                              id = $_POST[id_equipment];";
        mysqli_query($link, $sql_equipments);

        $sql_warehouses = "INSERT INTO warehouses (equipment_id,
                                                    in_the_warehouse,
                                                    type_of_activity_id,
                                                    activity,
                                                    responsible_id,
                                                    verified_by_id,
                                                    is_deleted)
                            VALUES ($_POST[id_equipment],
                                    $_POST[in_the_warehouse],
                                    $_POST[type_of_activity_id],
                                    '$_POST[activity]',
                                    $_POST[responsible_id],
                                    $_POST[verified_by_id],
                                    $_POST[warehouse_is_deleted])";
        mysqli_query($link, $sql_warehouses);
      }
    }

    if (mysqli_error($link)) {
      ?>
        <div class="modal fade" id="equipmentUpdateError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Modificar</h1>
                <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Error en la modificacion del equipo. Por Favor intente de nuevo.
              </div>
              <div class="modal-footer">
                <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const equipmentUpdateError = new bootstrap.Modal(document.getElementById('equipmentUpdateError'));
          equipmentUpdateError.show();
        </script>
      <?php
    } else { # Si no da error la insercion;
      if($_FILES["image_path"]["error"] < 1) { #Si la foto fue enviada en el formulario
      #llegaron los datos
      $temporal = $_FILES['image_path']['tmp_name'];
      $arch = $_FILES['image_path']['name'];
      $tipo = getimagesize($temporal);

        #El índice 2 del arreglo que genera getimagesize es una bandera que indica el tipo de imagen: 1 = GIF, 2 = JPG, 3 = PNG
        if($tipo[2] != 1 && $tipo[2] != 2 && $tipo[2] != 3) { # la extencion de archivo es incorrecta
          ?>
            <div class="modal fade" id="fileTypeError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Error por tipo de archivo</h1>
                    <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    Error por tipo de archivo cargado, el archivo debe ser extension: .jpg .png o .gif
                  </div>
                  <div class="modal-footer">
                    <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>">
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
            # nombres de las imagenes de los equipos y los qr de los equipos
            $imageExtention = ($tipo[2] == 1) ? '.gif' : (($tipo[2] == 2) ? '.jpg' : '.png');
            $equipmentImageName = 'equipment-image-' . $_POST['id_equipment'] . $imageExtention;

            # guardo la imagen del equipo en servidor
            $dir_equipment_image = './equipment_image/';
            if (!file_exists($dir_equipment_image)) mkdir($dir_equipment_image, 0775, true);
            $equipmentImagePath = $dir_equipment_image . $equipmentImageName;
            copy($_FILES['image_path']['tmp_name'], $equipmentImagePath);
          }
        }
      }
      ?>
        <div class="modal fade" id="successfulEquipmentRegistration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro Exitoso</h1>
                <a href="./view_equipment.php?id=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Equipo registrado exitosamente.
              </div>
              <div class="modal-footer">
                <a href="./view_equipment.php?id=<?php echo $_POST['id_equipment'] ?>">
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
      return 0;
    }
  } else { # No se llenaron todos los datos solicitados
    ?>
      <div class="modal fade" id="missingData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Faltan Datos</h1>
              <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </a>
            </div>
            <div class="modal-body">
              Por favor ingrese toda la informacion solicitada
            </div>
            <div class="modal-footer">
              <a href="./update_equipment_warehouse.php?id_equipment=<?php echo $_POST['id_equipment'] ?>">
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
    return 0;
  }

  include_once('./includes/footer.php');
?>
