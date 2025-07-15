<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_POST['id_equipment']) && $_POST['id_equipment']!=''&& isset($_POST['warehouse_id']) && $_POST['warehouse_id']!='' && isset($_POST['type_of_activity_id']) && $_POST['type_of_activity_id']!='' && isset($_POST['activity']) && $_POST['activity']!='' && isset($_POST['verified_by_id']) && $_POST['verified_by_id']!='') { # Si enviaron todos los campos del formulario excepto el del campo de imagenes
    # insertar query de warehouse

    $sql_warehouses = "INSERT INTO warehouses (equipment_id,
                                                in_the_warehouse,
                                                type_of_activity_id,
                                                activity,
                                                responsible_id,
                                                verified_by_id,
                                                is_deleted)
                        VALUES ($_POST[id_equipment],
                                0,
                                $_POST[type_of_activity_id],
                                '$_POST[activity]',
                                $_SESSION[id],
                                $_POST[verified_by_id],
                                0)";
    mysqli_query($link, $sql_warehouses);

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
      ?>
        <div class="modal fade" id="successfulEquipmentRemoval" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Retiro Exitoso</h1>
                <a href="./view_equipment.php?id=<?php echo $_POST['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Equipo retirado exitosamente.
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
          const successfulEquipmentRemoval = new bootstrap.Modal(document.getElementById('successfulEquipmentRemoval'));
          successfulEquipmentRemoval.show();
        </script>
      <?php
      return 0;
    }
  } else { #No se llenaron todos los datos solicitados
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
              <a href="./equipment_removal.php?id_equipment=<?php echo $_POST['id_equipment'] ?>">
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
